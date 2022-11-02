<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221020070013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE brand_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE shoe_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE brand (id INT NOT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, isnew VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE shoe (id INT NOT NULL, name VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, brand VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL, isfav VARCHAR(255) NOT NULL, isnew VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE brand_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE shoe_id_seq CASCADE');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE shoe');
    }
}
