<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class SpecialOffer
{
    public const SPECIAL_OFFER = "special_offer";
    public const SALES = "sales";
    public const FLASH_SALES = "flash_sales";

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $type = null;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?\DateTime $startDate = null;

    public function __construct(?string $type)
    {
        $this->type = $type;
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
}
