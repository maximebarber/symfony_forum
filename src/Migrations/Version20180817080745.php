<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180817080745 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_B6BD307F70BEE6D');
        $this->addSql('DROP INDEX IDX_B6BD307F23EDC87');
        $this->addSql('CREATE TEMPORARY TABLE __temp__message AS SELECT id, visitor_id, subject_id, created_at_message, modified_at_message FROM message');
        $this->addSql('DROP TABLE message');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, subject_id INTEGER NOT NULL, visitor_id INTEGER DEFAULT NULL, created_at_message DATETIME NOT NULL, modified_at_message DATETIME DEFAULT NULL, content CLOB NOT NULL, CONSTRAINT FK_B6BD307F70BEE6D FOREIGN KEY (visitor_id) REFERENCES visitor (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B6BD307F23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO message (id, visitor_id, subject_id, created_at_message, modified_at_message) SELECT id, visitor_id, subject_id, created_at_message, modified_at_message FROM __temp__message');
        $this->addSql('DROP TABLE __temp__message');
        $this->addSql('CREATE INDEX IDX_B6BD307F70BEE6D ON message (visitor_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F23EDC87 ON message (subject_id)');
        $this->addSql('DROP INDEX IDX_FBCE3E7A70BEE6D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__subject AS SELECT id, visitor_id, title_subject, created_at_subject, modified_at_subject FROM subject');
        $this->addSql('DROP TABLE subject');
        $this->addSql('CREATE TABLE subject (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, visitor_id INTEGER DEFAULT NULL, title_subject VARCHAR(255) NOT NULL COLLATE BINARY, created_at_subject DATETIME NOT NULL, modified_at_subject DATETIME DEFAULT NULL, CONSTRAINT FK_FBCE3E7A70BEE6D FOREIGN KEY (visitor_id) REFERENCES visitor (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO subject (id, visitor_id, title_subject, created_at_subject, modified_at_subject) SELECT id, visitor_id, title_subject, created_at_subject, modified_at_subject FROM __temp__subject');
        $this->addSql('DROP TABLE __temp__subject');
        $this->addSql('CREATE INDEX IDX_FBCE3E7A70BEE6D ON subject (visitor_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_B6BD307F70BEE6D');
        $this->addSql('DROP INDEX IDX_B6BD307F23EDC87');
        $this->addSql('CREATE TEMPORARY TABLE __temp__message AS SELECT id, visitor_id, subject_id, created_at_message, modified_at_message FROM message');
        $this->addSql('DROP TABLE message');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, subject_id INTEGER NOT NULL, created_at_message DATETIME NOT NULL, modified_at_message DATETIME DEFAULT NULL, visitor_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO message (id, visitor_id, subject_id, created_at_message, modified_at_message) SELECT id, visitor_id, subject_id, created_at_message, modified_at_message FROM __temp__message');
        $this->addSql('DROP TABLE __temp__message');
        $this->addSql('CREATE INDEX IDX_B6BD307F70BEE6D ON message (visitor_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F23EDC87 ON message (subject_id)');
        $this->addSql('DROP INDEX IDX_FBCE3E7A70BEE6D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__subject AS SELECT id, visitor_id, title_subject, created_at_subject, modified_at_subject FROM subject');
        $this->addSql('DROP TABLE subject');
        $this->addSql('CREATE TABLE subject (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title_subject VARCHAR(255) NOT NULL, created_at_subject DATETIME NOT NULL, modified_at_subject DATETIME DEFAULT NULL, visitor_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO subject (id, visitor_id, title_subject, created_at_subject, modified_at_subject) SELECT id, visitor_id, title_subject, created_at_subject, modified_at_subject FROM __temp__subject');
        $this->addSql('DROP TABLE __temp__subject');
        $this->addSql('CREATE INDEX IDX_FBCE3E7A70BEE6D ON subject (visitor_id)');
    }
}
