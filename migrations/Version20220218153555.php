<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220218153555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('ALTER TABLE lodging DROP photos');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lodging ADD photos LONGTEXT NOT NULL COLLATE `utf8_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE lodging_description lodging_description LONGTEXT NOT NULL COLLATE `utf8_unicode_ci`, CHANGE adress adress LONGTEXT NOT NULL COLLATE `utf8_unicode_ci`');
    }
}
