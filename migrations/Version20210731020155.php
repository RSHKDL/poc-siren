<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210731020155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'REL-1 Add Product and SpecialOffer entities';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, special_offer_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, stock INT NOT NULL, UNIQUE INDEX UNIQ_D34A04ADD37B1F79 (special_offer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE special_offer (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, start_date DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADD37B1F79 FOREIGN KEY (special_offer_id) REFERENCES special_offer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADD37B1F79');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE special_offer');
    }
}
