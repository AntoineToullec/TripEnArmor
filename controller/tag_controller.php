<?php

require_once dirname($_SERVER['DOCUMENT_ROOT']) . "/model/tag.php";

class TagController
{

    private $model;

    function __construct()
    {
        $this->model = 'Tag';
    }

    public function getInfosTag($id)
    {
        $tag = $this->model::getTagById($id);

        $result = [
            "id_tag" => $tag["id_tag"],
            "nom" => $tag["nom"]
        ];

        return $result;
    }

    public function getTagsByName($nom)
    {
        $tags = $this->model::getTagsByName($nom);
        
        if (count($tags) == 0) {
            return false;
        }

        return $tags;
    }

    public function createTag($nom)
    {
        return $this->model::createTag($nom);
    }
}