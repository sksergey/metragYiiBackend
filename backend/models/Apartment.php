<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "apartment".
 *
 * @property integer $id
 * @property integer $type_object_id
 * @property integer $count_room
 * @property integer $layout_id
 * @property integer $floor
 * @property integer $floor_all
 * @property integer $city_or_region
 * @property integer $region_kharkiv_admin_id
 * @property integer $locality_id
 * @property integer $course_id
 * @property integer $region_id
 * @property integer $region_kharkiv_id
 * @property integer $street_id
 * @property string $number_building
 * @property string $corps
 * @property string $number_apartment
 * @property integer $exchange
 * @property string $exchange_formula
 * @property string $landmark
 * @property integer $condit_id
 * @property integer $source_info_id
 * @property string $price
 * @property integer $mediator_id
 * @property integer $metro_id
 * @property string $phone
 * @property string $total_area
 * @property string $floor_area
 * @property string $kitchen_area
 * @property integer $wc_id
 * @property integer $wall_material_id
 * @property integer $count_balcony
 * @property integer $count_balcony_glazed
 * @property integer $exclusive_user_id
 * @property integer $phone_line
 * @property integer $bath
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
class Apartment extends \yii\db\ActiveRecord
{
    public $imageFiles;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'apartment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /*[['type_object_id', 'count_room', 'layout_id', 'floor', 'floor_all', 'city_or_region', 'region_kharkiv_admin_id', 'locality_id', 'course_id', 'region_id', 'region_kharkiv_id', 'street_id', 'number_building', 'corps', 'number_apartment', 'exchange', 'exchange_formula', 'landmark', 'condit_id', 'source_info_id', 'price', 'mediator_id', 'metro_id', 'phone', 'total_area', 'floor_area', 'kitchen_area', 'wc_id', 'wall_material_id', 'count_balcony', 'count_balcony_glazed', 'exclusive_user_id', 'phone_line', 'bath', 'comment', 'note', 'notesite', 'author_id', 'update_author_id', 'update_photo_user_id', 'enabled'], 'required'],*/
            [['type_object_id', 'count_room', 'floor', 'floor_all', 'region_kharkiv_admin_id', 'region_kharkiv_id', 'street_id', 'number_building', 'corps', 'number_apartment', 'price', 'condit_id', 'source_info_id', 'wc_id', 'wall_material_id', 'total_area'], 'required'],
            [['type_object_id', 'count_room', 'layout_id', 'floor', 'floor_all', 'city_or_region', 'region_kharkiv_admin_id', 'locality_id', 'course_id', 'region_id', 'region_kharkiv_id', 'street_id', 'exchange', 'condit_id', 'source_info_id', 'mediator_id', 'metro_id', 'wc_id', 'wall_material_id', 'count_balcony', 'count_balcony_glazed', 'exclusive_user_id', 'phone_line', 'bath', 'author_id', 'update_author_id', 'update_photo_user_id', 'enabled'], 'integer'],
            [['price', 'total_area', 'floor_area', 'kitchen_area'], 'number'],
            [['comment', 'note', 'notesite'], 'string'],
            [['date_added', 'date_modified', 'date_modified_photo'], 'safe'],
            [['number_building', 'corps', 'number_apartment', 'exchange_formula', 'landmark', 'phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type_object_id' => Yii::t('app', 'Type Object ID'),
            'count_room' => Yii::t('app', 'Count Room'),
            'layout_id' => Yii::t('app', 'Layout ID'),
            'floor' => Yii::t('app', 'Floor'),
            'floor_all' => Yii::t('app', 'Floor All'),
            'city_or_region' => Yii::t('app', 'City Or Region'),
            'region_kharkiv_admin_id' => Yii::t('app', 'Region Kharkiv Admin ID'),
            'locality_id' => Yii::t('app', 'Locality ID'),
            'course_id' => Yii::t('app', 'Course ID'),
            'region_id' => Yii::t('app', 'Region ID'),
            'region_kharkiv_id' => Yii::t('app', 'Region Kharkiv ID'),
            'street_id' => Yii::t('app', 'Street ID'),
            'number_building' => Yii::t('app', 'Number Building'),
            'corps' => Yii::t('app', 'Corps'),
            'number_apartment' => Yii::t('app', 'Number Apartment'),
            'exchange' => Yii::t('app', 'Exchange'),
            'exchange_formula' => Yii::t('app', 'Exchange Formula'),
            'landmark' => Yii::t('app', 'Landmark'),
            'condit_id' => Yii::t('app', 'Condit ID'),
            'source_info_id' => Yii::t('app', 'Source Info ID'),
            'price' => Yii::t('app', 'Price'),
            'mediator_id' => Yii::t('app', 'Mediator ID'),
            'metro_id' => Yii::t('app', 'Metro ID'),
            'phone' => Yii::t('app', 'Phone'),
            'total_area' => Yii::t('app', 'Total Area'),
            'floor_area' => Yii::t('app', 'Floor Area'),
            'kitchen_area' => Yii::t('app', 'Kitchen Area'),
            'wc_id' => Yii::t('app', 'Wc ID'),
            'wall_material_id' => Yii::t('app', 'Wall Material ID'),
            'count_balcony' => Yii::t('app', 'Count Balcony'),
            'count_balcony_glazed' => Yii::t('app', 'Count Balcony Glazed'),
            'exclusive_user_id' => Yii::t('app', 'Exclusive User ID'),
            'phone_line' => Yii::t('app', 'Phone Line'),
            'bath' => Yii::t('app', 'Bath'),
            'comment' => Yii::t('app', 'Comment'),
            'note' => Yii::t('app', 'Note'),
            'notesite' => Yii::t('app', 'Notesite'),
            'date_added' => Yii::t('app', 'Date Added'),
            'date_modified' => Yii::t('app', 'Date Modified'),
            'date_modified_photo' => Yii::t('app', 'Date Modified Photo'),
            'author_id' => Yii::t('app', 'Author ID'),
            'update_author_id' => Yii::t('app', 'Update Author ID'),
            'update_photo_user_id' => Yii::t('app', 'Update Photo User ID'),
            'enabled' => Yii::t('app', 'Enabled'),
        ];
    }

    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }

    public function getTypeObject()
    {
        return TypeObject::findOne($this->type_object_id);
    }
    
    public function getLayout()
    {
        return Layout::findOne($this->layout_id);
    }

    public function getPhonesArr($phone)
    {
        return $phones = explode(",", $phone);
    }

    public function upload()
    {
        if($this->validate()) { 
            foreach ($this->imageFiles as $file) {
                $path = Yii::getAlias('@webroot/upload/files/') . $file->name;
                //echo "path-".$path;
                //die;
                $file->saveAs($path);
                $this->attachImage($path);
                //die;
            }
            return true;
        } else {
            return false;
        }
    }
}
