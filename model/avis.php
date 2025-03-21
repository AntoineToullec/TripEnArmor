<?php
require_once dirname($_SERVER['DOCUMENT_ROOT']) . "/model/bdd.php";

class Avis extends BDD
{
    static private $nom_table = "sae_db._avis";

    static function getAvisById($id)
    {
        self::initBDD();
        $query = "SELECT * FROM " . self::$nom_table . " WHERE id_avis = ?";
        $statement = self::$db->prepare($query);
        $statement->bindParam(1, $id);

        if ($statement->execute()) {
            return $statement->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "ERREUR: Impossible d'obtenir cet avis";
            return false;
        }
    }

    static function getAvisByIdPro($id_pro): array|bool
    {
        self::initBDD();
        // Obtenir l'ensembre des offres du professionnel identifié
        $stmt = self::$db->prepare("SELECT id_offre FROM sae_db._offre JOIN sae_db._professionnel ON sae_db._offre.id_pro = sae_db._professionnel.id_compte WHERE id_compte = :id_pro");
        $stmt->bindParam(':id_pro', $id_pro);
        $stmt->execute();
        $toutesMesOffres = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $tousMesAvis = [];
        foreach ($toutesMesOffres as $offre) {
            $tousMesAvis = array_merge($tousMesAvis, self::getAvisByIdOffre($offre['id_offre']));
        }

        if ($tousMesAvis) {
            return $tousMesAvis;
        } else {
            return false;
        }
    }

    static function getAvisNonVusByIdPro($id_pro)
    {
        self::initBDD();
        // Obtenir l'ensembre des offres du professionnel identifié
        $stmt = self::$db->prepare("SELECT id_offre FROM sae_db._offre JOIN sae_db._professionnel ON sae_db._offre.id_pro = sae_db._professionnel.id_compte WHERE id_compte = :id_pro");
        $stmt->bindParam(':id_pro', $id_pro);
        $stmt->execute();
        $toutesMesOffres = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $tousMesAvis = [];
        foreach ($toutesMesOffres as $offre) {
            $tousMesAvis = array_merge($tousMesAvis, self::getAvisNonVusByIdOffre($offre['id_offre']));
        }

        if ($tousMesAvis) {
            return $tousMesAvis;
        } else {
            return false;
        }
    }

    static function marquerTousLesAvisCommeLus($id_pro)
    {
        self::initBDD();
        // Obtenir l'ensembre des offres du professionnel identifié
        $stmt = self::$db->prepare("SELECT id_offre FROM sae_db._offre JOIN sae_db._professionnel ON sae_db._offre.id_pro = sae_db._professionnel.id_compte WHERE id_compte = :id_pro");
        $stmt->bindParam(':id_pro', $id_pro);
        $stmt->execute();
        $toutesMesOffres = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $tousMesAvis = [];
        foreach ($toutesMesOffres as $offre) {
            $tousMesAvis = array_merge($tousMesAvis, self::getAvisNonVusByIdOffre($offre['id_offre']));
        }

        if ($tousMesAvis) {
            foreach ($tousMesAvis as $avi) {
                $query = "UPDATE " . self::$nom_table . " SET est_lu = true WHERE id_avis = ?";
                $statement = self::$db->prepare($query);
                $statement->bindParam(1, $avi['id_avis']);
                $statement->execute();
            }
            return true;
        } else {
            return false;
        }
    }

    static function getAvisByIdOffre($idOffre)
    {
        self::initBDD();
        $query = "SELECT * FROM " . self::$nom_table . " WHERE id_offre = ?";
        $statement = self::$db->prepare($query);
        $statement->bindParam(1, $idOffre);

        if ($statement->execute()) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "ERREUR: Impossible d'obtenir cet avis";
            return false;
        }
    }

    static function getAvisNonVusByIdOffre($idOffre)
    {
        self::initBDD();
        $query = "SELECT * FROM " . self::$nom_table . " WHERE id_offre = ? AND est_lu = false";
        $statement = self::$db->prepare($query);
        $statement->bindParam(1, $idOffre);

        if ($statement->execute()) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "ERREUR: Impossible d'obtenir cet avis";
            return false;
        }
    }

    static function getAvisByIdMembre($idMembre)
    {
        self::initBDD();
        $query = "SELECT * FROM " . self::$nom_table . " WHERE id_membre = ?";
        $statement = self::$db->prepare($query);
        $statement->bindParam(1, $idMembre);

        if ($statement->execute()) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "ERREUR: Impossible d'obtenir cet avis";
            return false;
        }
    }

    static function getAvisByIdMembreEtOffre($idMembre, $idOffre)
    {
        self::initBDD();
        $query = "SELECT * FROM " . self::$nom_table . " WHERE id_membre = ? AND id_offre = ?";
        $statement = self::$db->prepare($query);
        $statement->bindParam(1, $idMembre);
        $statement->bindParam(2, $idOffre);

        if ($statement->execute()) {
            return $statement->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "ERREUR: Impossible d'obtenir cet avis";
            return false;
        }
    }

    static function createAvis($titre, $date_experience, $id_membre, $id_offre, $note, $contexte_passage, $commentaire = null)
    {
        self::initBDD();
        $query = "INSERT INTO " . self::$nom_table . " (titre, date_experience, id_membre, id_offre, note, contexte_passage, commentaire) VALUES (?, ?, ?, ?, ?, ?, ?) RETURNING id_avis";

        $statement = self::$db->prepare($query);
        $statement->bindParam(1, $titre);
        $statement->bindParam(2, $date_experience);
        $statement->bindParam(3, $id_membre);
        $statement->bindParam(4, $id_offre);
        $statement->bindParam(5, $note);
        $statement->bindParam(6, $contexte_passage);
        $statement->bindParam(7, $commentaire);

        if ($statement->execute()) {
            return $statement->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "ERREUR: Impossible de créer cet avis";
            return false;
        }


    }

    static function updateAvis($id_avis, $titre, $commentaire, $date_experience, $id_membre, $id_offre)
    {
        self::initBDD();
        $query = "UPDATE " . self::$nom_table . " SET titre = ?, commentaire = ?, date_experience = ?, id_membre = ?, id_offre = ? WHERE id_avis = ? RETURNING id_avis";
        $statement = self::$db->prepare($query);
        $statement->bindParam(1, $titre);
        $statement->bindParam(2, $commentaire);
        $statement->bindParam(3, $date_experience);
        $statement->bindParam(4, $id_membre);
        $statement->bindParam(5, $id_offre);
        $statement->bindParam(6, $id_avis);

        if ($statement->execute()) {
            return $statement->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "ERREUR: Impossible de mettre à jour cet avis";
            return false;
        }
    }

    static function deleteAvis($id_avis)
    {
        self::initBDD();
        $query = "DELETE FROM " . self::$nom_table . " WHERE id_avis = ?";
        $statement = self::$db->prepare($query);
        $statement->bindParam(1, $id_avis);

        return $statement->execute();
    }

}
