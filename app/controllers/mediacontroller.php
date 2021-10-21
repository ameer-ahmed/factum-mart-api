<?php

namespace FactumMart\API\Controllers;

use FactumMart\API\Models\ImagesModel;

class MediaController extends AbstractController {

    public function defaultAction() {
        echo 'Access denied.';
    }
    public function imageAction() {
        @$imageUniqueName = $this->_params[0];
        $images = new ImagesModel();
        $fetchData = @$images->getByCustom('name = :name', ['name' => $imageUniqueName]);
        @$fetchData = (array)$fetchData[0];
        if(\count($fetchData) > 0) {
            \header('Content-type: image/jpeg');
            \readfile(\IMAGES_PATH . DS . $fetchData['real_name'] . '.jpg');
        } else {
            echo 'Access denied.';
        }
    }

}