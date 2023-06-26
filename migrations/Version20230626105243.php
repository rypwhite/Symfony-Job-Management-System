<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230626105243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F85A6D2235');
        $this->addSql('DROP INDEX IDX_FBD8E0F85A6D2235 ON job');
        $this->addSql('ALTER TABLE job CHANGE posted_by_id posted_by INT NOT NULL');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8AE36D154 FOREIGN KEY (posted_by) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_FBD8E0F8AE36D154 ON job (posted_by)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8AE36D154');
        $this->addSql('DROP INDEX IDX_FBD8E0F8AE36D154 ON job');
        $this->addSql('ALTER TABLE job CHANGE posted_by posted_by_id INT NOT NULL');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F85A6D2235 FOREIGN KEY (posted_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_FBD8E0F85A6D2235 ON job (posted_by_id)');
    }
}
