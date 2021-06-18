<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210617160117 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budget_gaz CHANGE abonnement_par_an abonnement_par_an NUMERIC(10, 2) DEFAULT NULL, CHANGE terme_proportionnelpar_an terme_proportionnelpar_an NUMERIC(10, 2) DEFAULT NULL, CHANGE termededistributionpar_an termededistributionpar_an NUMERIC(10, 2) DEFAULT NULL, CHANGE total_taxeshors_tvapar_an total_taxeshors_tvapar_an NUMERIC(10, 2) DEFAULT NULL, CHANGE ctaparan ctaparan NUMERIC(10, 2) DEFAULT NULL, CHANGE ticgnparan ticgnparan NUMERIC(10, 2) DEFAULT NULL, CHANGE ceeparan ceeparan NUMERIC(10, 2) DEFAULT NULL, CHANGE totalbudgetannuelttcou_ctrs totalbudgetannuelttcou_ctrs NUMERIC(10, 2) DEFAULT NULL, CHANGE totalsurladureducontrat totalsurladureducontrat NUMERIC(10, 2) DEFAULT NULL, CHANGE total_taxeshors_tvapar_an_ttc total_taxeshors_tvapar_an_ttc NUMERIC(10, 2) DEFAULT NULL, CHANGE budget_ttc budget_ttc NUMERIC(10, 2) DEFAULT NULL, CHANGE totalsurladureducontraten_ttc totalsurladureducontraten_ttc NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE objectif CHANGE valeur valeur NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE perimetre_electricite CHANGE pte pte NUMERIC(10, 2) DEFAULT NULL, CHANGE hph hph NUMERIC(10, 2) DEFAULT NULL, CHANGE hch hch NUMERIC(10, 2) DEFAULT NULL, CHANGE hpe hpe NUMERIC(10, 2) DEFAULT NULL, CHANGE hce hce NUMERIC(10, 2) DEFAULT NULL, CHANGE total total NUMERIC(10, 2) DEFAULT NULL, CHANGE ps_hph ps_hph NUMERIC(10, 2) DEFAULT NULL, CHANGE ps_hch ps_hch NUMERIC(10, 2) DEFAULT NULL, CHANGE ps_hpe ps_hpe NUMERIC(10, 2) DEFAULT NULL, CHANGE ps_hce ps_hce NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE permetre_gaz CHANGE car car NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE prix_for_perimetre_elec CHANGE comp_comptage comp_comptage NUMERIC(10, 2) DEFAULT NULL, CHANGE comp_gestion comp_gestion NUMERIC(10, 2) DEFAULT NULL, CHANGE part_fixe part_fixe NUMERIC(10, 2) DEFAULT NULL, CHANGE part_variable part_variable NUMERIC(10, 2) DEFAULT NULL, CHANGE total_ht total_ht NUMERIC(10, 2) DEFAULT NULL, CHANGE cspe cspe NUMERIC(10, 2) DEFAULT NULL, CHANGE cta cta NUMERIC(10, 2) DEFAULT NULL, CHANGE tcfe tcfe NUMERIC(10, 2) DEFAULT NULL, CHANGE total_htva total_htva NUMERIC(10, 2) DEFAULT NULL, CHANGE budget_htt budget_htt NUMERIC(10, 2) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budget_gaz CHANGE abonnement_par_an abonnement_par_an DOUBLE PRECISION DEFAULT NULL, CHANGE terme_proportionnelpar_an terme_proportionnelpar_an DOUBLE PRECISION DEFAULT NULL, CHANGE termededistributionpar_an termededistributionpar_an DOUBLE PRECISION DEFAULT NULL, CHANGE total_taxeshors_tvapar_an total_taxeshors_tvapar_an DOUBLE PRECISION DEFAULT NULL, CHANGE ctaparan ctaparan DOUBLE PRECISION DEFAULT NULL, CHANGE ticgnparan ticgnparan DOUBLE PRECISION DEFAULT NULL, CHANGE ceeparan ceeparan DOUBLE PRECISION DEFAULT NULL, CHANGE totalbudgetannuelttcou_ctrs totalbudgetannuelttcou_ctrs DOUBLE PRECISION DEFAULT NULL, CHANGE totalsurladureducontrat totalsurladureducontrat DOUBLE PRECISION DEFAULT NULL, CHANGE total_taxeshors_tvapar_an_ttc total_taxeshors_tvapar_an_ttc DOUBLE PRECISION DEFAULT NULL, CHANGE budget_ttc budget_ttc DOUBLE PRECISION DEFAULT NULL, CHANGE totalsurladureducontraten_ttc totalsurladureducontraten_ttc DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE objectif CHANGE valeur valeur DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE perimetre_electricite CHANGE pte pte DOUBLE PRECISION NOT NULL, CHANGE hph hph DOUBLE PRECISION NOT NULL, CHANGE hch hch DOUBLE PRECISION NOT NULL, CHANGE hpe hpe DOUBLE PRECISION NOT NULL, CHANGE hce hce DOUBLE PRECISION NOT NULL, CHANGE total total DOUBLE PRECISION NOT NULL, CHANGE ps_hph ps_hph DOUBLE PRECISION NOT NULL, CHANGE ps_hch ps_hch DOUBLE PRECISION NOT NULL, CHANGE ps_hpe ps_hpe DOUBLE PRECISION NOT NULL, CHANGE ps_hce ps_hce DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE permetre_gaz CHANGE car car DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE prix_for_perimetre_elec CHANGE comp_comptage comp_comptage DOUBLE PRECISION NOT NULL, CHANGE comp_gestion comp_gestion DOUBLE PRECISION NOT NULL, CHANGE part_fixe part_fixe DOUBLE PRECISION NOT NULL, CHANGE part_variable part_variable DOUBLE PRECISION NOT NULL, CHANGE total_ht total_ht DOUBLE PRECISION NOT NULL, CHANGE cspe cspe DOUBLE PRECISION NOT NULL, CHANGE cta cta DOUBLE PRECISION NOT NULL, CHANGE tcfe tcfe DOUBLE PRECISION NOT NULL, CHANGE total_htva total_htva DOUBLE PRECISION NOT NULL, CHANGE budget_htt budget_htt DOUBLE PRECISION NOT NULL');
    }
}
