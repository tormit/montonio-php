<?php

namespace Montonio\Payments\Model;

/**
 * Data transfer object for payment request.
 * @see https://docs.montonio.com/api/payments/#initiating-a-payment
 */
class PaymentData
{
    /**
     * Payment amount (up to 2 decimal places).
     * @var float
     */
    public float $amount;
    /**
     * Payment currency. Currently EUR and PLN are supported.
     * @var string
     */
    public string $currency;
    /**
     * The order reference in the merchant's system (e.g. the order ID).
     * @var string
     */
    public string $merchant_reference;
    /**
     * The URL where the customer will be redirected back to after completing or cancelling a payment.
     * @var string
     */
    public string $merchant_return_url;
    /**
     * The customer's e-mail address. Use this to identify customers more easily in Montonio's Partner System.
     * @var string
     */
    public string $checkout_email;
    /**
     * The customer's first name. Use this to identify customers more easily in Montonio's Partner System.
     * @var string
     */
    public string $checkout_first_name;
    /**
     * The customer's last name. Use this to identify customers more easily in Montonio's Partner System.
     * @var string
     */
    public string $checkout_last_name;
    /**
     * The customer's phone number. Use this to identify customers more easily in Montonio's Partner System.
     * @var string
     */
    public string $checkout_phone_number;

    // Optional
    /**
     * The URL to send a webhook notification when a payment is completed.
     * @var string|null
     */
    public ?string $merchant_notification_url = null;
    /**
     * The bank that the customer chose for this payment if you allow them to select their bank of choice in your checkout.
     * Leave this blank to let the customer choose their bank in our interface.
     * @var string|null
     */
    public ?string $preselected_aspsp = null;
    /**
     * The preferred language of the payment gateway. Defaults to the merchant country's official language.
     * Available values are en_US, et, lt, ru, pl, fi, lv.
     * @var string|null
     */
    public ?string $preselected_locale = null;
    /**
     * The preferred country for the methods list of the payment gateway. Defaults to the merchant's country.
     * Available values are EE, LV, LT, FI, PL.
     * @var string|null
     */
    public ?string $preselected_country = null;


    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency,
            'merchant_reference' => $this->merchant_reference,
            'merchant_return_url' => $this->merchant_return_url,
            'checkout_email' => $this->checkout_email,
            'checkout_first_name' => $this->checkout_first_name,
            'checkout_last_name' => $this->checkout_last_name,
            'checkout_phone_number' => $this->checkout_phone_number,
            'merchant_notification_url' => $this->merchant_notification_url,
            'preselected_aspsp' => $this->preselected_aspsp,
            'preselected_locale' => $this->preselected_locale,
            'preselected_country' => $this->preselected_country,
        ];
    }

}
