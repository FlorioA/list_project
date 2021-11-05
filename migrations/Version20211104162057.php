<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211104162057 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artwork (id INT AUTO_INCREMENT NOT NULL, media_id INT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, validated DATETIME DEFAULT NULL, INDEX IDX_881FC576EA9FDD75 (media_id), INDEX IDX_881FC576A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, validated DATETIME DEFAULT NULL, INDEX IDX_BDAFD8C8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE author_artwork (author_id INT NOT NULL, artwork_id INT NOT NULL, INDEX IDX_CD255A35F675F31B (author_id), INDEX IDX_CD255A35DB8FFA4 (artwork_id), PRIMARY KEY(author_id, artwork_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE listed_artwork (id INT AUTO_INCREMENT NOT NULL, artwork_id INT NOT NULL, user_id INT NOT NULL, seen TINYINT(1) NOT NULL, note INT DEFAULT NULL, INDEX IDX_4CEE21FEDB8FFA4 (artwork_id), INDEX IDX_4CEE21FEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artwork ADD CONSTRAINT FK_881FC576EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE artwork ADD CONSTRAINT FK_881FC576A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE author ADD CONSTRAINT FK_BDAFD8C8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE author_artwork ADD CONSTRAINT FK_CD255A35F675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE author_artwork ADD CONSTRAINT FK_CD255A35DB8FFA4 FOREIGN KEY (artwork_id) REFERENCES artwork (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE listed_artwork ADD CONSTRAINT FK_4CEE21FEDB8FFA4 FOREIGN KEY (artwork_id) REFERENCES artwork (id)');
        $this->addSql('ALTER TABLE listed_artwork ADD CONSTRAINT FK_4CEE21FEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author_artwork DROP FOREIGN KEY FK_CD255A35DB8FFA4');
        $this->addSql('ALTER TABLE listed_artwork DROP FOREIGN KEY FK_4CEE21FEDB8FFA4');
        $this->addSql('ALTER TABLE author_artwork DROP FOREIGN KEY FK_CD255A35F675F31B');
        $this->addSql('ALTER TABLE artwork DROP FOREIGN KEY FK_881FC576EA9FDD75');
        $this->addSql('ALTER TABLE artwork DROP FOREIGN KEY FK_881FC576A76ED395');
        $this->addSql('ALTER TABLE author DROP FOREIGN KEY FK_BDAFD8C8A76ED395');
        $this->addSql('ALTER TABLE listed_artwork DROP FOREIGN KEY FK_4CEE21FEA76ED395');
        $this->addSql('DROP TABLE artwork');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE author_artwork');
        $this->addSql('DROP TABLE listed_artwork');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE user');
    }
}
