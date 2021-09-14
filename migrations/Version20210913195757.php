<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210913195757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE cart_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE inventory_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_group_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE store_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cart (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE inventory (id INT NOT NULL, store_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B12D4A36B092A811 ON inventory (store_id)');
        $this->addSql('CREATE INDEX IDX_B12D4A364584665A ON inventory (product_id)');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, sdk INT NOT NULL, sku VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE product_group (id INT NOT NULL, cart_id INT NOT NULL, product_id INT NOT NULL, product_count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CC9C3F991AD5CDBF ON product_group (cart_id)');
        $this->addSql('CREATE INDEX IDX_CC9C3F994584665A ON product_group (product_id)');
        $this->addSql('CREATE TABLE store (id INT NOT NULL, name VARCHAR(255) NOT NULL, priority INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36B092A811 FOREIGN KEY (store_id) REFERENCES store (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A364584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_group ADD CONSTRAINT FK_CC9C3F991AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_group ADD CONSTRAINT FK_CC9C3F994584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE product_group DROP CONSTRAINT FK_CC9C3F991AD5CDBF');
        $this->addSql('ALTER TABLE inventory DROP CONSTRAINT FK_B12D4A364584665A');
        $this->addSql('ALTER TABLE product_group DROP CONSTRAINT FK_CC9C3F994584665A');
        $this->addSql('ALTER TABLE inventory DROP CONSTRAINT FK_B12D4A36B092A811');
        $this->addSql('DROP SEQUENCE cart_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE inventory_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_group_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE store_id_seq CASCADE');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE inventory');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_group');
        $this->addSql('DROP TABLE store');
    }
}
