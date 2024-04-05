<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240324215501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE books (id_liv INT AUTO_INCREMENT NOT NULL, nom_liv VARCHAR(255) NOT NULL, disponibilite_liv VARCHAR(255) NOT NULL, categorie_liv VARCHAR(255) NOT NULL, prix_liv NUMERIC(10, 2) NOT NULL, imagepath VARCHAR(255) DEFAULT NULL, pdfpath LONGBLOB DEFAULT NULL, PRIMARY KEY(id_liv)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, niveau VARCHAR(255) NOT NULL, imagepath VARCHAR(255) DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discussion (user_id INT DEFAULT NULL, id_Discussion INT AUTO_INCREMENT NOT NULL, Titre_DISCUSSION VARCHAR(255) DEFAULT NULL, Message LONGTEXT DEFAULT NULL, date_Post DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, id_Cours INT DEFAULT NULL, INDEX IDX_C0B9F90FA76ED395 (user_id), INDEX IDX_C0B9F90FD28EE2A8 (id_Cours), PRIMARY KEY(id_Discussion)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE events (user_id INT DEFAULT NULL, EVENT_ID INT AUTO_INCREMENT NOT NULL, NOM VARCHAR(255) DEFAULT NULL, DESCRIPTION VARCHAR(255) DEFAULT NULL, Typee VARCHAR(255) DEFAULT NULL, DATEe DATE DEFAULT NULL, STATUS VARCHAR(255) DEFAULT NULL, image_url VARCHAR(255) DEFAULT NULL, INDEX IDX_5387574AA76ED395 (user_id), PRIMARY KEY(EVENT_ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feedback (user_id INT DEFAULT NULL, ID INT AUTO_INCREMENT NOT NULL, EVENT_ID INT NOT NULL, REPONSE VARCHAR(1000) NOT NULL, DATE DATE NOT NULL, INDEX IDX_D2294458A76ED395 (user_id), PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id_panier INT AUTO_INCREMENT NOT NULL, id_liv INT DEFAULT NULL, total_price NUMERIC(10, 2) NOT NULL, nom_liv VARCHAR(255) DEFAULT NULL, imagePath VARCHAR(255) DEFAULT NULL, pdfPath LONGBLOB DEFAULT NULL, INDEX IDX_24CC0DF22D7107EB (id_liv), PRIMARY KEY(id_panier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id_quest INT AUTO_INCREMENT NOT NULL, quiz_id INT DEFAULT NULL, quest VARCHAR(255) DEFAULT NULL, rep1 VARCHAR(255) NOT NULL, rep2 VARCHAR(255) NOT NULL, rep3 VARCHAR(255) NOT NULL, rep4 VARCHAR(255) NOT NULL, repc VARCHAR(255) NOT NULL, INDEX IDX_B6F7494E853CD175 (quiz_id), PRIMARY KEY(id_quest)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_reponse (question_reponse INT AUTO_INCREMENT NOT NULL, id_Questiont INT DEFAULT NULL, id_Reponse INT DEFAULT NULL, INDEX IDX_516A0BDA167CFFF2 (id_Questiont), INDEX IDX_516A0BDA4E964E2B (id_Reponse), PRIMARY KEY(question_reponse)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questiont (id_Questiont INT AUTO_INCREMENT NOT NULL, text LONGTEXT NOT NULL, PRIMARY KEY(id_Questiont)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (quiz_id INT AUTO_INCREMENT NOT NULL, decrp VARCHAR(255) DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, nb_quest INT DEFAULT NULL, categorie VARCHAR(255) DEFAULT NULL, user_id INT DEFAULT NULL, image_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(quiz_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id_Reponse INT AUTO_INCREMENT NOT NULL, is_correct TINYINT(1) NOT NULL, reponse VARCHAR(255) NOT NULL, PRIMARY KEY(id_Reponse)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE score (id_score INT AUTO_INCREMENT NOT NULL, quiz_id INT DEFAULT NULL, score INT DEFAULT NULL, datesc DATE DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_32993751853CD175 (quiz_id), PRIMARY KEY(id_score)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test (id_Test INT AUTO_INCREMENT NOT NULL, nom_Test VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, temp_pris DATETIME NOT NULL, status VARCHAR(255) DEFAULT NULL, categorie VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id_Test)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test_question (id_test_question INT AUTO_INCREMENT NOT NULL, id_Test INT DEFAULT NULL, id_Questiont INT DEFAULT NULL, INDEX IDX_23944218F36DCD30 (id_Test), INDEX IDX_23944218167CFFF2 (id_Questiont), PRIMARY KEY(id_test_question)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (user_id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, datenes DATE NOT NULL, mail VARCHAR(50) NOT NULL, pswd VARCHAR(255) NOT NULL, role INT NOT NULL, image VARCHAR(50) NOT NULL, actif INT DEFAULT NULL, PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FA76ED395 FOREIGN KEY (user_id) REFERENCES user (user_id)');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FD28EE2A8 FOREIGN KEY (id_Cours) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574AA76ED395 FOREIGN KEY (user_id) REFERENCES user (user_id)');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D2294458A76ED395 FOREIGN KEY (user_id) REFERENCES user (user_id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF22D7107EB FOREIGN KEY (id_liv) REFERENCES books (id_liv)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (quiz_id)');
        $this->addSql('ALTER TABLE question_reponse ADD CONSTRAINT FK_516A0BDA167CFFF2 FOREIGN KEY (id_Questiont) REFERENCES questiont (id_Questiont)');
        $this->addSql('ALTER TABLE question_reponse ADD CONSTRAINT FK_516A0BDA4E964E2B FOREIGN KEY (id_Reponse) REFERENCES reponse (id_Reponse)');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_32993751853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (quiz_id)');
        $this->addSql('ALTER TABLE test_question ADD CONSTRAINT FK_23944218F36DCD30 FOREIGN KEY (id_Test) REFERENCES test (id_Test)');
        $this->addSql('ALTER TABLE test_question ADD CONSTRAINT FK_23944218167CFFF2 FOREIGN KEY (id_Questiont) REFERENCES questiont (id_Questiont)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90FA76ED395');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90FD28EE2A8');
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574AA76ED395');
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D2294458A76ED395');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF22D7107EB');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E853CD175');
        $this->addSql('ALTER TABLE question_reponse DROP FOREIGN KEY FK_516A0BDA167CFFF2');
        $this->addSql('ALTER TABLE question_reponse DROP FOREIGN KEY FK_516A0BDA4E964E2B');
        $this->addSql('ALTER TABLE score DROP FOREIGN KEY FK_32993751853CD175');
        $this->addSql('ALTER TABLE test_question DROP FOREIGN KEY FK_23944218F36DCD30');
        $this->addSql('ALTER TABLE test_question DROP FOREIGN KEY FK_23944218167CFFF2');
        $this->addSql('DROP TABLE books');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE discussion');
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE question_reponse');
        $this->addSql('DROP TABLE questiont');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE score');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE test_question');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
