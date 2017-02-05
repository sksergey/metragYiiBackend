<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Apartment;

class ApartmentFind extends Apartment
{
    public $idFrom;
    public $idTo;
    public $count_roomFrom;
    public $count_roomTo;
    public $priceFrom;
    public $priceTo;
    public $floorFrom;
    public $floorTo;
    public $floor_allFrom;
    public $floor_allTo;
    public $total_areaFrom;
    public $total_areaTo;
    public $floor_areaFrom;
    public $floor_areaTo;
    public $kitchen_areaFrom;
    public $kitchen_areaTo;

    public $city_or_region = '1';
    public $enabled = '1';
    public $image;
    public $imageFiles;
    public $file;
    public $del_img;
    
}

?>