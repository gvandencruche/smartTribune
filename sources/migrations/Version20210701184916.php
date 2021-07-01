<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210701184916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE historic_faq (id INT AUTO_INCREMENT NOT NULL, faq_id INT NOT NULL, title VARCHAR(100) NOT NULL, status VARCHAR(25) NOT NULL, INDEX IDX_C9A64B5681BEC8C2 (faq_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historic_faq ADD CONSTRAINT FK_C9A64B5681BEC8C2 FOREIGN KEY (faq_id) REFERENCES faq (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE historic_faq');
    }
}
