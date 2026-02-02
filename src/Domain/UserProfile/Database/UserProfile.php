<?php declare(strict_types = 1);

namespace App\Domain\UserProfile\Database;

use App\Domain\User\Database\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\Table(name: 'user_profile')]
#[ORM\HasLifecycleCallbacks]
class UserProfile
{

	#[ORM\Id]
	#[ORM\Column(type: 'uuid', unique: true)]
	public UuidInterface | string $id;

	#[ORM\OneToOne(targetEntity: User::class)]
	#[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false, unique: true)]
	public User $user;

	#[ORM\Column(length: 255)]
	public string $firstName;

	#[ORM\Column(length: 255)]
	public string $lastName;

	#[ORM\Column(length: 50, nullable: true)]
	public string | null $phone = null;

	#[ORM\Column(length: 512, nullable: true)]
	public string | null $avatar = null;

	#[ORM\Column(type: 'text', nullable: true)]
	public string | null $bio = null;

	#[ORM\Column(type: 'date', nullable: true)]
	public DateTime | null $dateOfBirth = null;

	#[ORM\Column(length: 20, nullable: true)]
	public string | null $gender = null;

	#[ORM\Column(length: 10, nullable: true)]
	public string | null $locale = null;

	#[ORM\Column(type: 'datetime')]
	public DateTime $createdAt;

	#[ORM\Column(type: 'datetime')]
	public DateTime $updatedAt;

	public function __construct(
		UuidInterface | string $id,
		User $user,
		string $firstName,
		string $lastName,
		string | null $phone = null,
		string | null $avatar = null,
		string | null $bio = null,
		DateTime | null $dateOfBirth = null,
		string | null $gender = null,
		string | null $locale = null,
	)
	{
		$this->id = $id;
		$this->user = $user;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->phone = $phone;
		$this->avatar = $avatar;
		$this->bio = $bio;
		$this->dateOfBirth = $dateOfBirth;
		$this->gender = $gender;
		$this->locale = $locale;
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
