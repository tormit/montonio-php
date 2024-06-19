<?php

namespace Montonio\Payments\Model;

class Address
{
    /**
     * The customer's first name.
     *
     * @var string|null
     */
    public ?string $firstName;

    /**
     * The customer's last name.
     *
     * @var string|null
     */
    public ?string $lastName;

    /**
     * The customer's email address.
     *
     * @var string|null
     */
    public ?string $email;

    /**
     * The customer's phone number.
     *
     * @var string|null
     */
    public ?string $phoneNumber;

    /**
     * The customer's phone country code. (e.g 372)
     *
     * @var string|null
     */
    public ?string $phoneCountry;

    /**
     * The customer's address line 1. (e.g Some Street 8-40)
     *
     * @var string|null
     */
    public ?string $addressLine1;

    /**
     * The customer's address line 2.
     *
     * @var string|null
     */
    public ?string $addressLine2;

    /**
     * The customer's city or town.
     *
     * @var string|null
     */
    public ?string $locality;

    /**
     * The customer's state or province.
     *
     * @var string|null
     */
    public ?string $region;

    /**
     * The customer's postal code.
     *
     * @var string|null
     */
    public ?string $postalCode;

    /**
     * The customer's country. ISO 3166-2
     *
     * @var string|null
     */
    public ?string $country;

    /**
     * Address constructor.
     *
     * @param string|null $firstName The customer's first name.
     * @param string|null $lastName The customer's last name.
     * @param string|null $email The customer's email address.
     * @param string|null $phoneNumber The customer's phone number.
     * @param string|null $phoneCountry The customer's phone country code. (e.g 372)
     * @param string|null $addressLine1 The customer's address line 1. (e.g Some Street 8-40)
     * @param string|null $addressLine2 The customer's address line 2.
     * @param string|null $locality The customer's city or town.
     * @param string|null $region The customer's state or province.
     * @param string|null $postalCode The customer's postal code.
     * @param string|null $country The customer's country.
     */
    public function __construct(
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $email = null,
        ?string $phoneNumber = null,
        ?string $phoneCountry = null,
        ?string $addressLine1 = null,
        ?string $addressLine2 = null,
        ?string $locality = null,
        ?string $region = null,
        ?string $postalCode = null,
        ?string $country = null
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->phoneCountry = $phoneCountry;
        $this->addressLine1 = $addressLine1;
        $this->addressLine2 = $addressLine2;
        $this->locality = $locality;
        $this->region = $region;
        $this->postalCode = $postalCode;
        $this->country = $country;
    }

    /**
     * Convert the address to an associative array.
     *
     * @return array The address data as an associative array.
     */
    public function toArray(): array
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'phoneNumber' => $this->phoneNumber,
            'phoneCountry' => $this->phoneCountry,
            'addressLine1' => $this->addressLine1,
            'addressLine2' => $this->addressLine2,
            'locality' => $this->locality,
            'region' => $this->region,
            'postalCode' => $this->postalCode,
            'country' => $this->country,
        ];
    }
}
