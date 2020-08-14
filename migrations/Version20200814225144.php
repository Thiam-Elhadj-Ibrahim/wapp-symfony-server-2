<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200814225144 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chat (id INT AUTO_INCREMENT NOT NULL, conversation_id INT DEFAULT NULL, message VARCHAR(255) NOT NULL, source VARCHAR(10) NOT NULL, type VARCHAR(30) NOT NULL, created_at INT DEFAULT NULL, deleted_at INT DEFAULT NULL, INDEX IDX_659DF2AA9AC0396 (conversation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, user_from_id INT DEFAULT NULL, user_to_id INT DEFAULT NULL, created_at INT DEFAULT NULL, deleted_at INT DEFAULT NULL, INDEX IDX_8A8E26E920C3C701 (user_from_id), INDEX IDX_8A8E26E9D2F7B13D (user_to_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, url LONGTEXT NOT NULL, created_at INT DEFAULT NULL, deleted_at INT DEFAULT NULL, INDEX IDX_C53D045FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE keyword (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, value VARCHAR(30) NOT NULL, created_at INT DEFAULT NULL, deleted_at INT DEFAULT NULL, INDEX IDX_5A93713BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, display_name VARCHAR(100) NOT NULL, area TINYTEXT DEFAULT NULL, area_visibility TINYINT(1) DEFAULT NULL, bio VARCHAR(100) DEFAULT NULL, email_visibility TINYINT(1) DEFAULT NULL, gender VARCHAR(15) DEFAULT NULL, phone VARCHAR(15) DEFAULT NULL, phone_visibility TINYINT(1) DEFAULT NULL, profile VARCHAR(30) NOT NULL, url VARCHAR(255) DEFAULT NULL, keyword_count INT DEFAULT NULL, image_count INT DEFAULT NULL, web_site VARCHAR(255) DEFAULT NULL, created_at INT DEFAULT NULL, deleted_at INT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AA9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E920C3C701 FOREIGN KEY (user_from_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9D2F7B13D FOREIGN KEY (user_to_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE keyword ADD CONSTRAINT FK_5A93713BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AA9AC0396');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E920C3C701');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9D2F7B13D');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FA76ED395');
        $this->addSql('ALTER TABLE keyword DROP FOREIGN KEY FK_5A93713BA76ED395');
        $this->addSql('DROP TABLE chat');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE keyword');
        $this->addSql('DROP TABLE user');
    }
}
