<?php

class TarifPublic extends BDD {

    private $nom_table = "sae_db._tarif_public";

    static function getTarifPublicById($id){

        $query = "SELECT * FROM " . self::$nom_table ." WHERE id_tarif = ?";

        $stmt = self::$db->prepare($query);
        $stmt->bindParam(1, $id);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "ERREUR : Impossible d'obtenir ce tarif public";
            return -1;
        }

    }

    static function createTarifPublic($titre_tarif, $prix, $id_offre){

        $query = "INSERT INTO " . self::$nom_table . "(titre_tarif, prix, id_offre) VALUES (?, ?, ?) RETURNING type_repas_id";
        $id_offre = self::$db->lastInsertId();
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(1, $titre_tarif);
        $stmt->bindParam(2, $prix);
        $stmt->bindParam(3, $id_offre);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "ERREUR : Impossible de créer le tarif public";
            return -1;
        }

    }

    static function updateTarifPublic($titre_tarif, $prix, $id_offre) {
        $query = "UPDATE " . self::$nom_table ." SET titre_tarif = ?, prix = ?, id_offre = ? RETURNING type_repas_id";
        
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(1, $titre_tarif);
        $stmt->bindParam(2, $prix);
        $stmt->bindParam(3, $id_offre);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "ERREUR : Impossible de mettre à jour le tarif public";
            return -1;
        }
    }

    static function deleteTarifPublic($id) {
        $query = "DELETE FROM " . self::$nom_table ." WHERE id_tarif = ?";
        
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(1, $id);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "ERREUR : Impossible de supprimer le id_tarif";
            return -1;
        }
    }


}