<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220501185245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE greeting_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE info_news_id_info_news_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE info_news (id_info_news INT NOT NULL, description VARCHAR(255) NOT NULL, date_validite TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, lien_text VARCHAR(255) NOT NULL, lien_url VARCHAR(255) NOT NULL, lien_is_target_blank BOOLEAN NOT NULL, PRIMARY KEY(id_info_news))');
        $this->addSql('COMMENT ON COLUMN info_news.date_validite IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('DROP TABLE greeting');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE info_news_id_info_news_seq CASCADE');
        $this->addSql('CREATE SEQUENCE greeting_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE greeting (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE info_news');
    }
}
