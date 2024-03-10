<?php

namespace App\Abstract;

abstract class AbstractProduct
{
    // Déclarer les méthodes abstraites
    abstract public function getId();
    abstract public function getName();
    abstract public function getPhotos();
    abstract public function getPrice();
    abstract public function getDescription();
    abstract public function getQuantity();
    abstract public function getCreatedAt();
    abstract public function getUpdatedAt();
    abstract public function getCategory_id();
    
    // Vous pouvez également déclarer d'autres méthodes abstraites si nécessaire
}