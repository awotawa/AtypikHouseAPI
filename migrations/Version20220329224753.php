<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220329224753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('ALTER TABLE user ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, CHANGE roles roles JSON NOT NULL, CHANGE photo photo VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE type type VARCHAR(30) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE lodging CHANGE name name VARCHAR(50) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE lodging_description lodging_description TINYTEXT NOT NULL COLLATE `utf8_unicode_ci`, CHANGE adress adress TINYTEXT NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE lodging_value CHANGE value value VARCHAR(10) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE media CHANGE media_type media_type VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE link link VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE message CHANGE message_content message_content VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE property CHANGE new_field new_field VARCHAR(30) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE default_value default_value VARCHAR(30) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE review CHANGE review_title review_title TINYTEXT NOT NULL COLLATE `utf8_unicode_ci`, CHANGE review_description review_description TINYTEXT NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE user DROP created_at, DROP updated_at, CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE first_name first_name VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE last_name last_name VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE photo photo VARCHAR(255) DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`');
    }
}
