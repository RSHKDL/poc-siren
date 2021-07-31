<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="integer")
     */
    private int $price;

    /**
     * @ORM\Column(type="integer")
     */
    private int $stock;

    /**
     * @ORM\Embedded(class="SpecialOffer")
     */
    private SpecialOffer $specialOffer;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $weighting;

    public function __construct(string $name, int $price, int $stock)
    {
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
        $this->specialOffer = new SpecialOffer(null);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getSpecialOffer(): SpecialOffer
    {
        return $this->specialOffer;
    }

    public function setSpecialOffer(SpecialOffer $specialOffer): self
    {
        $this->specialOffer = $specialOffer;

        return $this;
    }

    public function getWeighting(): ?int
    {
        return $this->weighting;
    }

    public function setWeighting(?int $weighting): self
    {
        $this->weighting = $weighting;

        return $this;
    }
}
