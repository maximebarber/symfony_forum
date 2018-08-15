<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180815150754 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__message AS SELECT id, created_at_message, number_message, modified_at_message FROM message');
        $this->addSql('DROP TABLE message');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, message_id INTEGER DEFAULT NULL, created_at_message DATETIME NOT NULL, number_message INTEGER NOT NULL, modified_at_message DATETIME DEFAULT NULL, CONSTRAINT FK_B6BD307F537A1329 FOREIGN KEY (message_id) REFERENCES visitor (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO message (id, created_at_message, number_message, modified_at_message) SELECT id, created_at_message, number_message, modified_at_message FROM __temp__message');
        $this->addSql('DROP TABLE __temp__message');
        $this->addSql('CREATE INDEX IDX_B6BD307F537A1329 ON message (message_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__subject AS SELECT id, title_subject, created_at_subject, number_subject, modified_at_subject FROM subject');
        $this->addSql('DROP TABLE subject');
        $this->addSql('CREATE TABLE subject (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, visitor_id INTEGER DEFAULT NULL, title_subject VARCHAR(255) NOT NULL COLLATE BINARY, created_at_subject DATETIME NOT NULL, number_subject INTEGER NOT NULL, modified_at_subject DATETIME DEFAULT NULL, CONSTRAINT FK_FBCE3E7A70BEE6D FOREIGN KEY (visitor_id) REFERENCES visitor (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO subject (id, title_subject, created_at_subject, number_subject, modified_at_subject) SELECT id, title_subject, created_at_subject, number_subject, modified_at_subject FROM __temp__subject');
        $this->addSql('DROP TABLE __temp__subject');
        $this->addSql('CREATE INDEX IDX_FBCE3E7A70BEE6D ON subject (visitor_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_B6BD307F537A1329');
        $this->addSql('CREATE TEMPORARY TABLE __temp__message AS SELECT id, created_at_message, number_message, modified_at_message FROM message');
        $this->addSql('DROP TABLE message');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_at_message DATETIME NOT NULL, number_message INTEGER NOT NULL, modified_at_message DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO message (id, created_at_message, number_message, modified_at_message) SELECT id, created_at_message, number_message, modified_at_message FROM __temp__message');
        $this->addSql('DROP TABLE __temp__message');
        $this->addSql('DROP INDEX IDX_FBCE3E7A70BEE6D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__subject AS SELECT id, title_subject, created_at_subject, number_subject, modified_at_subject FROM subject');
        $this->addSql('DROP TABLE subject');
        $this->addSql('CREATE TABLE subject (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title_subject VARCHAR(255) NOT NULL, created_at_subject DATETIME NOT NULL, number_subject INTEGER NOT NULL, modified_at_subject DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO subject (id, title_subject, created_at_subject, number_subject, modified_at_subject) SELECT id, title_subject, created_at_subject, number_subject, modified_at_subject FROM __temp__subject');
        $this->addSql('DROP TABLE __temp__subject');
    }
}
