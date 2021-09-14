<?php

namespace App\Siren\Domain\Model;

class Company
{
    private string $siren;
    private string $nic;
    private string $siret;
    private ?string $name;
    private ?string $brand;
    private ?string $category;
    private CompanyAddress $address;

    public function __construct(string $siren, string $nic)
    {
        $this->siren = $siren;
        $this->nic = $nic;
        $this->siret = $siren . $nic;
    }

    public function getSiren(): string
    {
        return $this->siren;
    }

    public function setSiren(string $siren): void
    {
        $this->siren = $siren;
    }

    public function getNic(): string
    {
        return $this->nic;
    }

    public function setNic(string $nic): void
    {
        $this->nic = $nic;
    }

    public function getSiret(): string
    {
        return $this->siret;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): void
    {
        $this->brand = $brand;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }

    public function getAddress(): CompanyAddress
    {
        return $this->address;
    }

    public function setAddress(CompanyAddress $address): void
    {
        $this->address = $address;
    }

}