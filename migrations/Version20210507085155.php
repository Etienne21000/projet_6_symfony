<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210507085155 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media DROP ressource_id');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F4544EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_939F4544EA9FDD75 ON ressource (media_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media ADD ressource_id INT NOT NULL');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F4544EA9FDD75');
        $this->addSql('DROP INDEX UNIQ_939F4544EA9FDD75 ON ressource');
    }
}
