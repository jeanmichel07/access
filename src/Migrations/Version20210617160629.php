<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210617160629 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail_offre_elec CHANGE pr_abonnement_par_an pr_abonnement_par_an NUMERIC(10, 2) DEFAULT NULL, CHANGE pr_pte pr_pte NUMERIC(10, 2) DEFAULT NULL, CHANGE pr_hph pr_hph NUMERIC(10, 2) DEFAULT NULL, CHANGE pr_hch pr_hch NUMERIC(10, 2) DEFAULT NULL, CHANGE pr_hpe pr_hpe NUMERIC(10, 2) DEFAULT NULL, CHANGE pr_hce pr_hce NUMERIC(10, 2) DEFAULT NULL, CHANGE budget_htt budget_htt NUMERIC(10, 2) DEFAULT NULL, CHANGE total_ht total_ht NUMERIC(10, 2) DEFAULT NULL, CHANGE total_htva total_htva NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE detaille_offre_gaz CHANGE pr_abonn_par_mois pr_abonn_par_mois NUMERIC(10, 2) DEFAULT NULL, CHANGE pr_gaz pr_gaz NUMERIC(10, 2) DEFAULT NULL, CHANGE tqa tqa NUMERIC(10, 2) DEFAULT NULL, CHANGE cee cee NUMERIC(10, 2) DEFAULT NULL, CHANGE cta cta NUMERIC(10, 2) DEFAULT NULL, CHANGE budget_ttc budget_ttc NUMERIC(10, 2) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail_offre_elec CHANGE pr_abonnement_par_an pr_abonnement_par_an DOUBLE PRECISION NOT NULL, CHANGE pr_pte pr_pte DOUBLE PRECISION NOT NULL, CHANGE pr_hph pr_hph DOUBLE PRECISION NOT NULL, CHANGE pr_hch pr_hch DOUBLE PRECISION NOT NULL, CHANGE pr_hpe pr_hpe DOUBLE PRECISION NOT NULL, CHANGE pr_hce pr_hce DOUBLE PRECISION NOT NULL, CHANGE budget_htt budget_htt DOUBLE PRECISION NOT NULL, CHANGE total_ht total_ht DOUBLE PRECISION NOT NULL, CHANGE total_htva total_htva DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE detaille_offre_gaz CHANGE pr_abonn_par_mois pr_abonn_par_mois DOUBLE PRECISION DEFAULT NULL, CHANGE pr_gaz pr_gaz DOUBLE PRECISION DEFAULT NULL, CHANGE tqa tqa DOUBLE PRECISION DEFAULT NULL, CHANGE cee cee DOUBLE PRECISION DEFAULT NULL, CHANGE cta cta DOUBLE PRECISION DEFAULT NULL, CHANGE budget_ttc budget_ttc DOUBLE PRECISION DEFAULT NULL');
    }
}
