<?php declare(strict_types = 1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260202000000 extends AbstractMigration
{

	public function getDescription(): string
	{
		return 'Create user_profile table';
	}

	public function up(Schema $schema): void
	{
		$this->addSql(<<<'SQL'
			CREATE TABLE user_profile (id CHAR(36) NOT NULL, user_id CHAR(36) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(50) DEFAULT NULL, avatar VARCHAR(512) DEFAULT NULL, bio TEXT DEFAULT NULL, date_of_birth DATE DEFAULT NULL, gender VARCHAR(20) DEFAULT NULL, locale VARCHAR(10) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id))
		SQL);
		$this->addSql(<<<'SQL'
			CREATE UNIQUE INDEX UNIQ_D95AB405A76ED395 ON user_profile (user_id)
		SQL);
	}

	public function down(Schema $schema): void
	{
		$this->addSql(<<<'SQL'
			DROP TABLE user_profile
		SQL);
	}

}
