<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210701083339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answers_faq (id INT AUTO_INCREMENT NOT NULL, f_aq_id INT NOT NULL, channel ENUM(\'faq\', \'bot\') NOT NULL COMMENT \'(DC2Type:AnswersChannelFAQType)\', body VARCHAR(500) NOT NULL, INDEX IDX_FF8E4DF3660399A5 (f_aq_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faq (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, promoted TINYINT(1) NOT NULL, status ENUM(\'draft\', \'published\') NOT NULL COMMENT \'(DC2Type:StatusFAQType)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answers_faq ADD CONSTRAINT FK_FF8E4DF3660399A5 FOREIGN KEY (f_aq_id) REFERENCES faq (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answers_faq DROP FOREIGN KEY FK_FF8E4DF3660399A5');
        $this->addSql('DROP TABLE answers_faq');
        $this->addSql('DROP TABLE faq');
    }
}
