<?php

namespace App\Entity;

use App\Repository\SpecialOfferRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SpecialOfferRepository::class)
 */
class SpecialOffer
{
    public const SPECIAL_OFFER = "special_offer";
    public const SALES = "sales";
    public const FLASH_SALES = "flash_sales";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $type;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?\DateTime $startDate = null;

    /**
     * @ORM\OneToOne(targetEntity=Product::class, mappedBy="specialOffer", cascade={"persist", "remove"})
     */
    private ?Product $product;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        // unset the owning side of the relation if necessary
        if ($product === null && $this->product !== null) {
            $this->product->setSpecialOffer(null);
        }

        // set the owning side of the relation if necessary
        if ($product !== null && $product->getSpecialOffer() !== $this) {
            $product->setSpecialOffer($this);
        }

        $this->product = $product;

        return $this;
    }
}
