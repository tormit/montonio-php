<?php

namespace Montonio\Payments\Model;

/**
 * Class LineItem
 *
 * Represents an item in an order.
 */
class LineItem
{
    /**
     * The line item's name.
     *
     * @var string
     */
    public string $name;

    /**
     * Quantity of the product.
     *
     * @var int
     */
    public int $quantity;

    /**
     * The product's sale price (tax included).
     *
     * @var float
     */
    public float $finalPrice;

    /**
     * LineItem constructor.
     *
     * @param string $name The line item's name.
     * @param int $quantity Quantity of the product.
     * @param float $finalPrice The product's sale price (tax included).
     */
    public function __construct(
        string $name,
        int $quantity,
        float $finalPrice
    ) {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->finalPrice = $finalPrice;
    }

    /**
     * Convert the line item to an associative array.
     *
     * @return array The line item data as an associative array.
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'quantity' => $this->quantity,
            'finalPrice' => $this->finalPrice,
        ];
    }
}
