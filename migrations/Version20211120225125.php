<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211120225125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task ADD issue_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB255E7AA58C FOREIGN KEY (issue_id) REFERENCES issue (id)');
        $this->addSql('CREATE INDEX IDX_527EDB255E7AA58C ON task (issue_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB255E7AA58C');
        $this->addSql('DROP INDEX IDX_527EDB255E7AA58C ON task');
        $this->addSql('ALTER TABLE task DROP issue_id');
    }
}
