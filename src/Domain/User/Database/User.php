<?php declare(strict_types = 1);

namespace App\Domain\User\Database;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\Table(name: 'user')]
#[ORM\HasLifecycleCallbacks]
class User
{

	public const STATE_ACTIVE = 0;
	public const STATE_INACTIVE = 1;

	#[ORM\Id]
	#[ORM\Column(type: 'uuid', unique: true)]
	public UuidInterface | string $id;

	#[ORM\Column(length: 255, unique: true)]
	public string $email;

	#[ORM\Column(length: 255)]
	public string $name;

	#[ORM\Column(type: 'smallint', length: 2)]
	public int $state;

	#[ORM\Column(type: 'datetime')]
	public DateTime $createdAt;

	#[ORM\Column(type: 'datetime')]
	public DateTime $updatedAt;

	public function __construct(
		UuidInterface | string $id,
		string $email,
		string $name,
		int $state = self::STATE_ACTIVE
	)
	{
		$this->id = $id;
		$this->email = $email;
		$this->name = $name;
		$this->state = $state;
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

}
