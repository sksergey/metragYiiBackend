<?php

namespace common\models;

use backend\models\Image;
use backend\models\Course;
use backend\models\Locality;
use backend\models\Region;
use Yii;
/**
 * This is the model class for table "house".
 *
 * @property integer $id
 * @property integer $type_object_id
 * @property integer $count_room
 * @property integer $partsite_id
 * @property integer $parthouse_id
 * @property integer $floor_all
 * @property integer $city_or_region
 * @property integer $region_kharkiv_admin_id
 * @property integer $locality_id
 * @property integer $course_id
 * @property integer $region_id
 * @property integer $region_kharkiv_id
 * @property integer $street_id
 * @property string $number_building
 * @property integer $exchange
 * @property string $exchange_formula
 * @property string $landmark
 * @property integer $condit_id
 * @property integer $source_info_id
 * @property string $price
 * @property integer $mediator_id
 * @property integer $metro_id
 * @property string $phone
 * @property string $total_area_house
 * @property string $total_area
 * @property integer $building_year
 * @property integer $sewage_id
 * @property integer $wall_material_id
 * @property integer $gas_id
 * @property integer $water_id
 * @property integer $comfort_id
 * @property integer $exclusive_user_id
 * @property integer $phone_line
 * @property integer $state_act
 * @property string $comment
 * @property string $note
 * @property string $notesite
 * @property string $date_added
 * @property string $date_modified
 * @property string $date_modified_photo
 * @property integer $author_id
 * @property integer $update_author_id
 * @property integer $update_photo_user_id
 * @property integer $enabled
 */
class House extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_object_id', 'count_room', 'partsite_id', 'parthouse_id', 'floor_all', 'city_or_region', 'street_id', 'price', 'condit_id', 'source_info_id',
                'sewage_id', 'wall_material_id', 'water_id', 'total_area_house', 'total_area', 'building_year', 'gas_id', 'phone', 'enabled'], 'required'],
            [['type_object_id', 'count_room', 'partsite_id', 'parthouse_id', 'floor_all', 'city_or_region', 'region_kharkiv_admin_id', 'locality_id', 'course_id', 'region_id', 'region_kharkiv_id', 'street_id', 'exchange', 'condit_id', 'source_info_id', 'mediator_id', 'metro_id', 'building_year', 'sewage_id', 'wall_material_id', 'gas_id', 'water_id', 'comfort_id', 'exclusive_user_id', 'phone_line', 'state_act', 'author_id', 'update_author_id', 'update_photo_user_id', 'enabled'], 'integer'],
            [['price', 'total_area_house', 'total_area'], 'number'],
            [['comment', 'note', 'notesite'], 'string'],
            [['date_added', 'date_modified', 'date_modified_photo'], 'safe'],
            [['number_building', 'exchange_formula', 'landmark', 'phone'], 'string', 'max' => 255],
            [['region_kharkiv_admin_id', 'region_kharkiv_id'], 'required', 'when' => function ($model) {
                return $model->city_or_region == 0;
            }, 'whenClient' => "function(attribute, value) {
                console.log($(\"input[name='House[city_or_region]']:checked\").val());
                return $(\"input[name='House[city_or_region]']:checked\").val() == 0;
            }"],
            [['locality_id', 'course_id', 'region_id'], 'required', 'when' => function ($model) {
                return $model->city_or_region == 1;
            }, 'whenClient' => "function(attribute, value) {
                    console.log($(\"input[name='House[city_or_region]']:checked\").val());
                    return $(\"input[name='House[city_or_region]']:checked\").val() == 1;
                }"],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type_object_id' => Yii::t('app', 'Type Object'),
            'count_room' => Yii::t('app', 'Count Room'),
            'partsite_id' => Yii::t('app', 'Partsite'),
            'parthouse_id' => Yii::t('app', 'Parthouse'),
            'floor_all' => Yii::t('app', 'Floor All'),
            'city_or_region' => Yii::t('app', 'City Or Region'),
            'region_kharkiv_admin_id' => Yii::t('app', 'Region Kharkiv Admin'),
            'locality_id' => Yii::t('app', 'Locality'),
            'course_id' => Yii::t('app', 'Course'),
            'region_id' => Yii::t('app', 'Region'),
            'region_kharkiv_id' => Yii::t('app', 'Region Kharkiv'),
            'street_id' => Yii::t('app', 'Street'),
            'number_building' => Yii::t('app', 'Number Building'),
            'exchange' => Yii::t('app', 'Exchange'),
            'exchange_formula' => Yii::t('app', 'Exchange Formula'),
            'landmark' => Yii::t('app', 'Landmark'),
            'condit_id' => Yii::t('app', 'Condit'),
            'source_info_id' => Yii::t('app', 'Source Info'),
            'price' => Yii::t('app', 'Price'),
            'mediator_id' => Yii::t('app', 'Mediator'),
            'metro_id' => Yii::t('app', 'Metro'),
            'phone' => Yii::t('app', 'Phone'),
            'total_area_house' => Yii::t('app', 'Total Area House'),
            'total_area' => Yii::t('app', 'Total Area'),
            'building_year' => Yii::t('app', 'Building Year'),
            'sewage_id' => Yii::t('app', 'Sewage'),
            'wall_material_id' => Yii::t('app', 'Wall Material'),
            'gas_id' => Yii::t('app', 'Gas'),
            'water_id' => Yii::t('app', 'Water'),
            'comfort_id' => Yii::t('app', 'Comfort'),
            'exclusive_user_id' => Yii::t('app', 'Exclusive User'),
            'phone_line' => Yii::t('app', 'Phone Line'),
            'state_act' => Yii::t('app', 'State Act'),
            'comment' => Yii::t('app', 'Comment'),
            'note' => Yii::t('app', 'Note'),
            'notesite' => Yii::t('app', 'Notesite'),
            'date_added' => Yii::t('app', 'Date Added'),
            'date_modified' => Yii::t('app', 'Date Modified'),
            'date_modified_photo' => Yii::t('app', 'Date Modified Photo'),
            'author_id' => Yii::t('app', 'Author'),
            'update_author_id' => Yii::t('app', 'Update Author'),
            'update_photo_user_id' => Yii::t('app', 'Update Photo User'),
            'enabled' => Yii::t('app', 'Enabled'),
        ];
    }

    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ],
            'realty' => [
                'class' => 'common\behaviors\RealtyBehave',
            ]
        ];
    }

    public static function deleteImage($id)
    {
        $image = Image::findOne($id);
        $model = Apartment::findOne($image->itemId);
        $images = $model->getImages();
        foreach ($images as $img)
        {
            if ($img->id == $id)
                $model->removeImage($img);
        }
    }

    public function getLocalitystring($model)
    {
        $locality = '';
        if($model['city_or_region'] == '0') {
            $locality .= Yii::t('app', 'Kharkiv');
        }else {
            if ($model['locality_id']) $locality .= Locality::findOne($model['locality_id'])->name . ', ';
            if ($model['course_id']) $locality .= Course::findOne($model['course_id'])->name . ', ';
            if ($model['region_id']) $locality .= Region::findOne($model['region_id'])->name;
        }
        if($model['region_kharkiv_id'] != '0'){
            $locality .= ', ';
            $locality .= RegionKharkiv::findOne($model['region_kharkiv_id'])->name;
        }
        if($model['street_id'] != '0'){
            $locality .= ', ';
            $locality .= Street::findOne($model['street_id'])->name;
        }
        return $locality;
    }

    public function getTypeObject($model = null)
    {
        if($model == null)
            return TypeObject::findOne($this->type_object_id);
        else
            return TypeObject::findOne($model['type_object_id'])->name;

    }

    public function getRegionKharkiv($model = null)
    {
        if($model == null)
            return RegionKharkiv::findOne($this->region_kharkiv_id);
        else
            return RegionKharkiv::findOne($model['region_kharkiv_id'])->name;

    }
}
