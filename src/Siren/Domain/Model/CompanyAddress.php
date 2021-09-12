<?php

namespace App\Siren\Domain\Model;

/**
 * Class CompanyAddress
 * @see https://schema.org/PostalAddress
 */
class CompanyAddress
{
    private string $streetAddress;
    private $postalCode;
    private string $addressLocality;
    private string $addressRegion;
    private string $addressCountry;

    public function getStreetAddress(): string
    {
        return $this->streetAddress;
    }

    public function setStreetAddress(string $streetAddress): void
    {
        $this->streetAddress = $streetAddress;
    }

    /**
     * @return int|string|null
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    public function setPostalCode($postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    public function getAddressLocality(): string
    {
        return $this->addressLocality;
    }

    public function setAddressLocality(string $addressLocality): void
    {
        $this->addressLocality = $addressLocality;
    }

    public function getAddressRegion(): string
    {
        return $this->addressRegion;
    }

    public function setAddressRegion(string $addressRegion): void
    {
        $this->addressRegion = $addressRegion;
    }

    public function getAddressCountry(): string
    {
        return $this->addressCountry;
    }

    public function setAddressCountry(string $addressCountry): void
    {
        $this->addressCountry = $addressCountry;
    }
}