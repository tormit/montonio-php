<?php

namespace Montonio\Payments;

/**
 * We use php-jwt for JWT creation
 */

/**
 * SDK for Montonio Payments.
 * This class contains methods for starting and validating payments.
 */

class PaymentSDK
{
    public const CURRENCY_EUR = 'EUR';
    public const CURRENCY_PLN = 'PLN';

    private const JWT_TOKEN_ALGO = 'HS256';

    /**
     * Root URL for the Montonio Payments Sandbox application
     */
    private const MONTONIO_PAYMENTS_SANDBOX_APPLICATION_URL = 'https://sandbox-stargate.montonio.com/api';

    /**
     * Root URL for the Montonio Payments application
     */
    private const MONTONIO_PAYMENTS_APPLICATION_URL = 'https://stargate.montonio.com/api';
    private const PAYMENT_TOKEN_EXPIRY_SECONDS = 10 * 60; // 10 minutes
    private const VALIDATION_TOKEN_EXPIRY_SECONDS = 60 * 5; // 5 minutes

    private static array $validCurrencies = [
        self::CURRENCY_EUR,
        self::CURRENCY_PLN,
    ];

    /**
     * Order data structure
     * @see https://docs.montonio.com/api/stargate/guides/orders
     *
     * @var \Montonio\Payments\Model\PaymentData
     */
    protected \Montonio\Payments\Model\PaymentData $_paymentData;

    /**
     * Montonio Access Key
     *
     * @var string
     */
    protected string $_accessKey;

    /**
     * Montonio Secret Key
     *
     * @var string
     */
    protected string $_secretKey;

    /**
     * Montonio Environment (Use sandbox for testing purposes)
     *
     * @var string 'production' or 'sandbox'
     */
    protected string $_environment;

    public function __construct(string $accessKey, string $secretKey, string $environment)
    {
        $this->_accessKey = $accessKey;
        $this->_secretKey = $secretKey;
        $this->_environment = $environment;
    }

    /**
     * Get the URL string where to redirect the customer to
     *
     * @return string
     */
    public function getPaymentUrl(): string
    {
        $base = ($this->_environment === 'sandbox')
        ? self::MONTONIO_PAYMENTS_SANDBOX_APPLICATION_URL
        : self::MONTONIO_PAYMENTS_APPLICATION_URL;

        return $base . '?payment_token=' . $this->_generatePaymentToken();
    }

    /**
     * Generate JWT from Payment Data
     *
     * @return string
     */
    protected function _generatePaymentToken(): string
    {
        /**
         * Parse Payment Data to correct data types
         * and add additional data
         */
        if (!in_array($this->_paymentData['currency'], self::$validCurrencies)) {
            throw new \Exception\MontonioException('Invalid currency');
        }

        $paymentData = array(
            'accessKey' => $this->_accessKey,
            'merchantReference' => $this->_paymentData->merchant_reference,
            'returnUrl' => $this->_paymentData->merchant_return_url,
            'notificationUrl' => $this->_paymentData->merchant_notification_url,
            'grandTotal' => $this->_paymentData->amount,
            'currency' => $this->_paymentData->currency,
            'exp' => time() + self::PAYMENT_TOKEN_EXPIRY_SECONDS,
            'payment' => $this->_paymentData->payment->toArray(),
            'locale' => $this->_paymentData->preselected_locale,
            'expiresIn' => 30,
            'billingAddress' => $this->_paymentData->billing_address?->toArray() ?? [],
            'shippingAddress' => $this->_paymentData->billing_address?->toArray() ?? [],
            'lineItems' => array_map(function (\Montonio\Payments\Model\LineItem $line) {
                return $line->toArray();
            }, $this->_paymentData->lines),
        );

        foreach ($paymentData as $key => $value) {
            if (empty($value)) {
                unset($paymentData[$key]);
            }
        }

        return \Firebase\JWT\JWT::encode($paymentData, $this->_secretKey, self::JWT_TOKEN_ALGO);
    }

    /**
     * Set payment data
     *
     * @param \Montonio\Payments\Model\PaymentData $paymentData
     * @return static
     */
    public function setPaymentData(\Montonio\Payments\Model\PaymentData $paymentData): PaymentSDK
    {
        $this->_paymentData = $paymentData;
        return $this;
    }

    /**
     * Decode the Payment Token
     * This is used to validate the integrity of a callback when a payment was made via Montonio
     * @see https://payments-docs.montonio.com/#validating-the-returned-payment-token
     *
     * @param string $token - The Payment Token
     * @param string $secretKey Your Secret Key for the environment
     * @return object The decoded Payment token
     */
    public static function decodePaymentToken(string $token, string $secretKey): \stdClass
    {
        \Firebase\JWT\JWT::$leeway = self::VALIDATION_TOKEN_EXPIRY_SECONDS;
        return \Firebase\JWT\JWT::decode($token, new \Firebase\JWT\Key($secretKey, self::JWT_TOKEN_ALGO));
    }

    /**
     * Decode the Payment Token to data object
     * @param string $token - The Payment Token
     * @param string $secretKey Your Secret Key for the environment
     * @return \Montonio\Payments\Model\ReturnData The decoded return data
     * @see \Montonio\Payments\PaymentSDK::decodePaymentToken
     */
    public static function decodePaymentTokenToModel(string $token, string $secretKey): \Montonio\Payments\Model\ReturnData
    {
        return \Montonio\Payments\Model\ReturnData::fromToken(
            self::decodePaymentToken($token, $secretKey)
        );
    }

    /**
     * @param string $token
     * @param string $accessKey
     * @param string $secretKey
     * @param string $orderId
     * @param \Montonio\Payments\Model\ReturnData|null $returnData Return token data will be stored here if successful payment
     * @return bool
     */
    public static function isPaymentFinalized(
        string $token,
        string $accessKey,
        string $secretKey,
        string $orderId,
        ?\Montonio\Payments\Model\ReturnData &$returnData = null
    ): bool {
        $decoded = self::decodePaymentTokenToModel($token, $secretKey);

        if ($decoded->access_key === $accessKey
            && $decoded->merchant_reference === $orderId
            && $decoded->status === \Montonio\Payments\Model\ReturnData::STATUS_FINALIZED) {
            $returnData = $decoded;
            return true;
        }

        return false;
    }

    /**
     * Get the Bearer auth token for requests to Montonio
     *
     * @param string $accessKey - Your Access Key
     * @param string $secretKey - Your Secret Key
     * @return string
     */
    static function getBearerToken(string $accessKey, string $secretKey): string
    {
        $data = array(
            'access_key' => $accessKey,
        );

        return \Firebase\JWT\JWT::encode($data, $secretKey, self::JWT_TOKEN_ALGO);
    }

    /**
     * Function for making API calls with file_get_contents
     *
     * @param string $url URL
     * @param array $options Context Options
     * @return array Array containing status and json_decoded response
     */
    protected function _apiRequest(string $url, array $options): array
    {
        $context = stream_context_create($options);
        $result  = @file_get_contents($url, false, $context);

        if ($result === false) {
            return array(
                "status" => "ERROR",
                "data"   => false,
            );
        } else {
            return array(
                "status" => "SUCCESS",
                "data"   => json_decode($result),
            );
        }
    }

    /**
     * Fetch info about banks and card processors that
     * can be shown to the customer at checkout.
     *
     * Banks have different identifiers for separate regions,
     * but the identifier for card payments is uppercase CARD
     * in all regions.
     * @see https://docs.montonio.com/api/stargate/reference#get-available-payment-methods
     *
     * @return array Array containing the status of the request and the banklist
     */
    public function fetchBankList(): array
    {
        $url = $this->_environment === 'sandbox'
            ? sprintf('%s/stores/payment-methods', self::MONTONIO_PAYMENTS_SANDBOX_APPLICATION_URL)
            : sprintf('%s/stores/payment-methods', self::MONTONIO_PAYMENTS_APPLICATION_URL);

        $options = array(
            'http' => array(
                'header' => "Content-Type: application/json\r\n" .
                "Authorization: Bearer " . self::getBearerToken(
                    $this->_accessKey,
                    $this->_secretKey
                ) . "\r\n",
                'method' => 'GET',
            ),
        );
        return $this->_apiRequest($url, $options);
    }
}
