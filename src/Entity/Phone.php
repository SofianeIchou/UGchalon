<?php

namespace App\Entity;

use App\Repository\PhoneRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhoneRepository::class)
 */
class Phone
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Licensed::class, inversedBy="phones")
     * @ORM\JoinColumn(nullable=false)
     */
    private $licensed;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $number;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLicensed(): ?Licensed
    {
        return $this->licensed;
    }

    public function setLicensed(?Licensed $licensed): self
    {
        $this->licensed = $licensed;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }
}
