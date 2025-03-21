<?php

class ImageController
{
    private $uploadDir;
    public function __construct()
    {
        $this->uploadDir = dirname($_SERVER['DOCUMENT_ROOT']) . '/html/public/images/';
    }

    public function getImagesOfOffre($id_offre)
    {
        $result = [
            "carte" => false,
            "plan" => false,
            "photo-resto" => false,
            "details" => false
        ];
        $allImages = scandir($this->uploadDir . "offres/");

        if ($allImages) {
            foreach ($allImages as $image) {
                $name = explode(".", $image)[0];
                $subparts = explode("_", $name);

                if ($subparts[0] == $id_offre) {
                    if ($subparts[1] == "carte") {
                        $result["carte"] = $image;
                    } else if ($subparts[1] == "plan") {
                        $result["plan"] = $image;
                    } else if ($subparts[1] == "photo-resto") {
                        $result["carte-resto"] = $image;
                    } else {
                        if ($result["details"] === false) {
                            $result["details"] = [];
                        }
                        $result["details"][] = $image;
                    }
                }
            }
        }

        return $result;
    }

    public function uploadImage($id, $champ, $actual_path, $extension, $nom_objet = "offres")
    {
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
        $result = move_uploaded_file($actual_path, $this->uploadDir . $nom_objet . "/" . $id . "_" . $champ . '.' . $extension);
        return $result;
    }

    public function uploadImageAvis($id, $champ, $actual_path, $extension)
    {
        $this->uploadImage($id, $champ, $actual_path, $extension, "avis");
    }

    public function getImagesAvis($id_avis)
    {
        $allImages = scandir($this->uploadDir . "avis/");
        $result = [];

        if ($allImages) {
            foreach ($allImages as $image) {
                $name = explode(".", $image)[0];
                $subparts = explode("_", $name);

                if ($subparts[0] == $id_avis) {
                    $result[] = $image;
                }
            }
        }

        return $result;
    }
}