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
	public $date_addedFrom;
    public $date_addedTo;

    public $city_or_region = '1';
    
    public $image;
    public $imageFiles;
    public $file;
    public $del_img;

    public $middle_floor = '2';
    public $no_mediators = '2';
    public $exchange = '2';
    public $enabled = '1';
    public $note = '2';
    public $phone;

    
}

?>