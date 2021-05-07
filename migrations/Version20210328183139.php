<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210328183139 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, link LONGTEXT NOT NULL, creation_date DATE NOT NULL, edition_date DATE DEFAULT NULL, post_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE post ADD video TINYINT(1) NOT NULL, ADD category VARCHAR(100) NOT NULL, DROP img_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE video');
        $this->addSql('ALTER TABLE image DROP status');
        $this->addSql('ALTER TABLE post ADD img_id INT NOT NULL, DROP video, DROP category');
    }
}
