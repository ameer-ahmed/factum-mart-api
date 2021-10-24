<?php

namespace FactumMart\API\Controllers;

use FactumMart\API\LIB\API;
use FactumMart\API\Models\ImagesModel;

class MediaController extends AbstractController {

    public function defaultAction() {
        API::response(\false, 'Access denied.');
    }

    public function imageAction() {
        $imageUniqueName = isset($this->_params[0]) ? $this->_params[0] : '';
        if(!empty($imageUniqueName)) {
            $images = new ImagesModel();
            $fetchData = $images->getByCustom('unique_name = :unique_name', ['unique_name' => $imageUniqueName]);
            $fetchData = (array)$fetchData[0];
            if(\count($fetchData) > 0) {
                \header('Content-type: image/jpeg');
                \readfile(\IMAGES_PATH . DS . $fetchData['real_name'] . '.jpg');
            } else {
                API::response(\false, 'Access denied.');
            }
        }
        
    }

    public function assetsAction() {
        $expectedParams = ['image' => 'icons'];
        if(
            isset($this->_params[0]) && 
            \in_array($this->_params[0], $expectedParams) &&
            isset($this->_params[1])
        ) { 
            $path = \ASSETS_PATH . DS . $this->_params[0] . DS . $this->_params[1];
            if(\file_exists($path)) {
                $extension = \explode('.', $path);
                $extension = \end($extension);
                $type = \array_search($this->_params[0], $expectedParams);
                \header('Content-type: '. $type .'/' . $extension);
                \readfile($path);
            } else {
                API::response(\false, 'Access denied.');
            }
        } else {
            API::response(\false, 'Access denied.');
        }
    }

}