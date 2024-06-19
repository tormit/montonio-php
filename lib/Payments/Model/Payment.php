<?php

namespace Montonio\Payments\Model;

class Payment
{
    /**
     * The amount to charge. This is the total amount of the order, including tax and shipping.
     *
     * @var float
     */
    public float $amount;

    /**
     * The currency of the order. This is a 3-letter ISO currency code.
     *
     * @var string
     */
    public string $currency;

    /**
     * The Identifier of the Montonio Payment Method.
     *
     * @var string
     */
    public string $method;

    /**
     * The Payment Method's title as is shown to the customer at checkout.
     *
     * @var string|null
     */
    public ?string $methodDisplay;

    /**
     * Additional options for the payment method.
     *
     * @var array|null
     */
    public ?array $methodOptions;

    /**
     * Payment constructor.
     *
     * @param float $amount The amount to charge. This is the total amount of the order, including tax and shipping.
     * @param string $currency The currency of the order. This is a 3-letter ISO currency code.
     * @param string $method The Identifier of the Montonio Payment Method.
     * @param string|null $methodDisplay The Payment Method's title as is shown to the customer at checkout.
     * @param array|null $methodOptions Additional options for the payment method.
     */
    public function __construct(
        float $amount,
        string $currency,
        string $method,
        ?string $methodDisplay = null,
        ?array $methodOptions = null
    ) {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->method = $method;
        $this->methodDisplay = $methodDisplay;
        $this->methodOptions = $methodOptions;
    }

    /**
     * Convert the payment to an associative array.
     *
     * @return array The payment data as an associative array.
     */
    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency,
            'method' => $this->method,
            'methodDisplay' => $this->methodDisplay,
            'methodOptions' => $this->methodOptions,
        ];
    }
}
