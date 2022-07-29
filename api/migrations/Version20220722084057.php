<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220722084057 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE info_news_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE info_news (id INT NOT NULL, id_info_news UUID NOT NULL, description TEXT NOT NULL, date_validite TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, lien_text VARCHAR(255) DEFAULT NULL, lien_url TEXT DEFAULT NULL, lien_is_target_blank BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_44B84BDEC48DF7F9 ON info_news (id_info_news)');
        $this->addSql('COMMENT ON COLUMN info_news.id_info_news IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE info_news_id_seq CASCADE');
        $this->addSql('DROP TABLE info_news');
    }
}
