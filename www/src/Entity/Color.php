<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Wandi\ColorPickerBundle\Validator\Constraints as WandiAssert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ColorRepository")
 */
class Color
{
    /**
     * @var ?int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var ?string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var ?string
     *
     * @ORM\Column(name="color", type="string", length=9)
     * @WandiAssert\HexColor()
     * @Assert\NotBlank(message="You must choose a color.")
     */
    private $color;

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getColor(): ?string
    {
        return substr((string) $this->color, 0, 7);
    }

    public function setColor(?string $color): self
    {
        $this->color = substr((string) $color, 0, 7);

        return $this;
    }
}
