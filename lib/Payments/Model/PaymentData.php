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
     * The URL to send a webhook notification when a payment is completed.
     * @var string
     */
    public string $merchant_notification_url;

    /**
     * The payment method to use.
     *
     * @var \Montonio\Payments\Model\Payment|null
     */
    public ?\Montonio\Payments\Model\Payment $payment = null;
    /**
     * The preferred language of the payment gateway. Defaults to the merchant country's official language.
     * Available values are en_US, et, lt, ru, pl, fi, lv.
     * @var string|null
     */
    public ?string $preselected_locale = null;

    public \Montonio\Payments\Model\Address|null $billing_address = null;
    public \Montonio\Payments\Model\Address|null $shipping_address = null;

    /**
     * @var \Montonio\Payments\Model\LineItem[]
     */
    public array $lines = [];
}
