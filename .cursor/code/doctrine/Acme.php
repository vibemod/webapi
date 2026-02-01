<?php

declare(strict_types = 1);

namespace App\Domain\Acme\Database;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\Table(name: 'acme')]
#[ORM\HasLifecycleCallbacks]
class Acme
{

    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true, options: ["collation" => "utf8mb4_bin"])]
    public UuidInterface|string $id;

    #[ORM\Column(length: 255)]
    public string $url;

    #[ORM\Column(type: 'datetime')]
    public DateTime $createdAt;

    #[ORM\Column(type: 'datetime')]
    public DateTime $updatedAt;

    public function __construct(
        UuidInterface|string $id,
        string $url,
    ) {
        $this->id = $id;
        $this->url = $url;
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updatedAt = new DateTime();
    }

    /**
     * @return array{
     *  id: string,
     *  url: string
     * }
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'url' => $this->url,
        ];
    }

}