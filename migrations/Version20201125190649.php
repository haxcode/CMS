<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20201125190649
 *
 * @package          DoctrineMigrations
 * @createDate       2020-11-25
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
final class Version20201125190649 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'UUID in tokens';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE user_auth_token_id_seq CASCADE');
        $this->addSql('ALTER TABLE user_auth_token ALTER id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_auth_token ALTER id DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE user_auth_token_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE "user_auth_token" ALTER id TYPE INT');
        $this->addSql('ALTER TABLE "user_auth_token" ALTER id DROP DEFAULT');
    }
}
