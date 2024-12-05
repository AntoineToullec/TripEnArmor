<?php
require_once dirname($_SERVER['DOCUMENT_ROOT']) . "/model/tag_restaurant.php";

class TagRestaurantController {
    private $model;

    public function __construct() {
        $this->model = "TagRestaurant";
    }

    public function getInfosTagRestaurant($id) {
        $tag = $this->model::getTagRestaurantById($id);

        return $tag;
    }

    public function getTagsRestaurantByName( $name ) {
        $tags = $this->model::getTagsRestaurantByName($name);

        if (count($tags) == 0) {
            return false;
        }

        return $tags;
    }

    public function createTag($name) {
        return $this->model::createTagRestaurant($name)[0]['id_tag_restaurant'];
    }
}