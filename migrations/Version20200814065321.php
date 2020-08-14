<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200814065321 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE area_visibility area_visibility TINYINT(1) DEFAULT NULL, CHANGE email_visibility email_visibility TINYINT(1) DEFAULT NULL, CHANGE gender gender VARCHAR(15) DEFAULT NULL, CHANGE phone_visibility phone_visibility TINYINT(1) DEFAULT NULL, CHANGE profile profile VARCHAR(30) NOT NULL, CHANGE keyword_count keyword_count INT DEFAULT NULL, CHANGE image_count image_count INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE area_visibility area_visibility TINYINT(1) DEFAULT \'1\', CHANGE email_visibility email_visibility TINYINT(1) DEFAULT \'1\', CHANGE gender gender VARCHAR(15) CHARACTER SET utf8mb4 DEFAULT \'Male\' COLLATE `utf8mb4_unicode_ci`, CHANGE phone_visibility phone_visibility TINYINT(1) DEFAULT \'1\', CHANGE profile profile VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT \'Particular\' NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE keyword_count keyword_count INT DEFAULT 4, CHANGE image_count image_count INT DEFAULT 4');
    }
}
