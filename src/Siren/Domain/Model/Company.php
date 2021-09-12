<?php

namespace App\Siren\Domain\Model;

class Company
{
    private int $siren;
    private int $nic;
    private string $name;
    private ?string $brand;
    private ?string $category;
    private CompanyAddress $address;

    public function getSiren(): int
    {
        return $this->siren;
    }

    public function setSiren(int $siren): void
    {
        $this->siren = $siren;
    }

    public function getNic(): int
    {
        return $this->nic;
    }

    public function setNic(int $nic): void
    {
        $this->nic = $nic;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
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