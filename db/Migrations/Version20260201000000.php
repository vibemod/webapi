<?php declare(strict_types = 1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260201000000 extends AbstractMigration
{

	public function getDescription(): string
	{
		return 'Create user table and drop webhook table';
	}

	public function up(Schema $schema): void
	{
		$this->addSql(<<<'SQL'
			CREATE TABLE user (id CHAR(36) NOT NULL, email VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, state SMALLINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id))
		SQL);
		$this->addSql(<<<'SQL'
			CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)
		SQL);
		$this->addSql(<<<'SQL'
			DROP TABLE IF EXISTS webhook
		SQL);
		$this->addSql(<<<'SQL'
			DROP TABLE IF EXISTS webhook_log
		SQL);
	}

	public function down(Schema $schema): void
	{
		$this->addSql(<<<'SQL'
			DROP TABLE user
		SQL);
		$this->addSql(<<<'SQL'
			CREATE TABLE webhook (id CHAR(36) NOT NULL, dsn VARCHAR(255) NOT NULL, state SMALLINT NOT NULL, listen JSON NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id))
		SQL);
	}

}
