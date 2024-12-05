<?php

require_once dirname($_SERVER['DOCUMENT_ROOT']) . "/model/type_repas.php";

class TypeRepasController
{

    private $model;

    function __construct()
    {
        $this->model = 'TypeRepas';
    }

    public function getInfoTypeRepas($id)
    {
        $typeRepas = $this->model::getTypeRepasById($id);

        $result = [
            "id_type_repas" => $typeRepas["id_type_repas"],
            "nom_type_repas" => $typeRepas["nom_type_repas"],
        ];

        return $result;
    }

    public function getTypeRepasByName($name)
    {
        $typeRepas = $this->model::getTypesRepasByName($name);

        if (count($typeRepas) == 0) {
            return false;
        }

        $result = [
            "id_type_repas" => $typeRepas[0]["id_type_repas"],
            "nom_type_repas" => $typeRepas[0]["nom"],
        ];

        return $result;
    }

    public function createTypeRepas($nom_type_repas)
    {
        $typeRepasID = $this->model::createTypeRepas($nom_type_repas)[0]['id_type_repas'];

        var_dump($typeRepasID);
        
        return $typeRepasID;
    }

    public function updateTypeRepas($id, $nom_type_repas = false)
    {
        if ($nom_type_repas === false) {
            echo "ERREUR: Aucun champ à modifier";
            return -1;
        } else {
            $typeRepas = $this->model::getTypeRepasById($id);

            $updatedTypeRepasId = $this->model::updateTypeRepas(
                $id,
                $nom_type_repas !== false ? $nom_type_repas : $typeRepas["nom_type_repas"]
            );
            return $updatedTypeRepasId;
        }
    }
}