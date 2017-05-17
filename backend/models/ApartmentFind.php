<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Apartment;

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

    public function rules()
    {
        return [
            [['id', 'type_object_id', 'count_room', 'layout_id', 'floor', 'floor_all', 'city_or_region',  'locality_id', 'course_id', 'region_id', 'region_kharkiv_id', 'street_id', 'exchange', 'condit_id', 'source_info_id', 'mediator_id', 'metro_id', 'wc_id', 'wall_material_id', 'count_balcony', 'count_balcony_glazed', 'exclusive_user_id', 'phone_line', 'bath', 'author_id', 'update_author_id', 'update_photo_user_id', 'enabled'], 'integer'],
            [['number_building', 'corps', 'number_apartment', 'exchange_formula', 'landmark', 'phone', 'comment', 'note', 'notesite', 'date_added', 'date_modified', 'date_modified_photo'], 'safe'],
            [['price', 'total_area', 'floor_area', 'kitchen_area'], 'number'],
        ];
    }
    
}

?>