<?php

namespace Montonio\Payments\Model;

class PaymentData
{
    public float $amount;
    public string $currency;
    public string $merchant_reference;
    public string $merchant_return_url;
    public string $checkout_email;
    public string $checkout_first_name;
    public string $checkout_last_name;
    public string $checkout_phone_number;

    // Optional
    public ?string $merchant_notification_url = null;
    public ?string $preselected_aspsp = null;
    public ?string $preselected_locale = null;
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
