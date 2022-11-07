<?php

namespace Montonio\Payments\Model;

/**
 * Data transfer object for response from Montonio's.
 * @see https://docs.montonio.com/api/payments/#validating-the-payment
 */
class ReturnData
{
    public const STATUS_FINALIZED = 'finalized';

    /**
     * Payment amount (up to 2 decimal places).
     * @var float
     */
    public float $amount;
    /**
     * Your Access Key obtained from the Partner System.
     * @var string
     */
    public string $access_key;
    /**
     * The order reference number you provided in the initial payment token.
     * @var string
     */
    public string $merchant_reference;
    /**
     * Payment status. Only consider finalized as the correct status for a completed payment.
     * @var string
     */
    public string $status;
    /**
     * The payment's UUID in Montonio.
     * @var string
     */
    public string $payment_uuid;
    /**
     * The customer's IBAN.
     * If the payment has not been finalized or if it was a card payment, the value will be null. The value will also be null if the customer has paid with their Revolut account.
     * @var string|null
     */
    public ?string $customer_iban;
    /**
     * Friendly name of the payment method used.
     * @var string
     */
    public string $payment_method_name;
    /**
     * Expiration time of the token in Unix time.
     * @var int
     */
    public int $exp;
    /**
     * Issuing time of the token in Unix time.
     * @var int
     */
    public int $iat;

    public static function fromToken(\stdClass $token): ReturnData
    {
        $self = new static;
        foreach ($token as $key => $value) {
            $self->{$key} = $value;
        }

        return $self;
    }

}
