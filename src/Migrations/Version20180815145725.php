<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180815145725 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_at_message DATETIME NOT NULL, number_message INTEGER NOT NULL, modified_at_message DATETIME DEFAULT NULL)');
        $this->addSql('CREATE TABLE subject (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title_subject VARCHAR(255) NOT NULL, created_at_subject DATETIME NOT NULL, number_subject INTEGER NOT NULL, modified_at_subject DATETIME DEFAULT NULL)');
        $this->addSql('CREATE TABLE visitor (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, number_visitor INTEGER NOT NULL, pseudo_visitor VARCHAR(255) NOT NULL, pwd_visitor VARCHAR(255) NOT NULL, created_at_visitor DATETIME NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE subject');
        $this->addSql('DROP TABLE visitor');
    }
}
