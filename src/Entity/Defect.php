<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DefectRepository")
 */
class Defect
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $SubType;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $ReportingDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $GeoPoint;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): self
    {
        $this->Type = $Type;

        return $this;
    }

    public function getSubType(): ?string
    {
        return $this->SubType;
    }

    public function setSubType(?string $SubType): self
    {
        $this->SubType = $SubType;

        return $this;
    }

    public function getReportingDate(): ?\DateTimeInterface
    {
        return $this->ReportingDate;
    }

    public function setReportingDate(\DateTimeInterface $ReportingDate): self
    {
        $this->ReportingDate = $ReportingDate;

        return $this;
    }

    public function getGeoPoint(): ?string
    {
        return $this->GeoPoint;
    }

    public function setGeoPoint(string $GeoPoint): self
    {
        $this->GeoPoint = $GeoPoint;

        return $this;
    }
}
