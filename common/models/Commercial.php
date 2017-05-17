<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "commercial".
 *
 * @property integer $id
 * @property integer $type_object_id
 * @property integer $count_room
 * @property integer $ownership_id
 * @property integer $floor
 * @property integer $floor_all
 * @property integer $city_or_region
 * @property integer $region_kharkiv_admin_id
 * @property integer $locality_id
 * @property integer $course_id
 * @property integer $region_id
 * @property integer $region_kharkiv_id
 * @property integer $street_id
 * @property string $number_office
 * @property string $corps
 * @property integer $exchange
 * @property string $exchange_formula
 * @property string $landmark
 * @property integer $condit_id
 * @property integer $source_info_id
 * @property string $price
 * @property string $price_square_meter
 * @property integer $mediator_id
 * @property integer $metro_id
 * @property string $phone
 * @property string $total_area_house
 * @property string $total_area
 * @property integer $communication_id
 * @property integer $exclusive_user_id
 * @property integer $housing
 * @property integer $detached_building
 * @property integer $documents
 * @property integer $rent
 * @property integer $topicality
 * @property integer $avtorampa
 * @property integer $red_line
 * @property integer $infinite_period
 * @property integer $separate_entrance
 * @property integer $delivered
 * @property integer $phone_line
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
class Commercial extends \yii\db\ActiveRecord
{
    public $imageFiles;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'commercial';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_object_id', 'count_room', 'floor', 'floor_all', 'city_or_region', 'street_id', 'condit_id', 'source_info_id', 'price', 'total_area_house', 'total_area', 'enabled'], 'required'],
            [['type_object_id', 'count_room', 'ownership_id', 'floor', 'floor_all', 'city_or_region', 'region_kharkiv_admin_id', 'locality_id', 'course_id', 'region_id', 'region_kharkiv_id', 'street_id', 'exchange', 'condit_id', 'source_info_id', 'mediator_id', 'metro_id', 'communication_id', 'exclusive_user_id', 'housing', 'detached_building', 'documents', 'rent', 'topicality', 'avtorampa', 'red_line', 'infinite_period', 'separate_entrance', 'delivered', 'phone_line', 'author_id', 'update_author_id', 'update_photo_user_id', 'enabled'], 'integer'],
            [['price', 'price_square_meter', 'total_area_house', 'total_area'], 'number'],
            [['comment', 'note', 'notesite'], 'string'],
            [['date_added', 'date_modified', 'date_modified_photo'], 'safe'],
            [['number_office', 'corps', 'exchange_formula', 'landmark', 'phone'], 'string', 'max' => 255],
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
            'ownership_id' => Yii::t('app', 'Ownership ID'),
            'floor' => Yii::t('app', 'Floor'),
            'floor_all' => Yii::t('app', 'Floor All'),
            'city_or_region' => Yii::t('app', 'City Or Region'),
            'region_kharkiv_admin_id' => Yii::t('app', 'Region Kharkiv Admin ID'),
            'locality_id' => Yii::t('app', 'Locality ID'),
            'course_id' => Yii::t('app', 'Course ID'),
            'region_id' => Yii::t('app', 'Region ID'),
            'region_kharkiv_id' => Yii::t('app', 'Region Kharkiv ID'),
            'street_id' => Yii::t('app', 'Street ID'),
            'number_office' => Yii::t('app', 'Number Office'),
            'corps' => Yii::t('app', 'Corps'),
            'exchange' => Yii::t('app', 'Exchange'),
            'exchange_formula' => Yii::t('app', 'Exchange Formula'),
            'landmark' => Yii::t('app', 'Landmark'),
            'condit_id' => Yii::t('app', 'Condit ID'),
            'source_info_id' => Yii::t('app', 'Source Info ID'),
            'price' => Yii::t('app', 'Price'),
            'price_square_meter' => Yii::t('app', 'Price Square Meter'),
            'mediator_id' => Yii::t('app', 'Mediator ID'),
            'metro_id' => Yii::t('app', 'Metro ID'),
            'phone' => Yii::t('app', 'Phone'),
            'total_area_house' => Yii::t('app', 'Total Area House'),
            'total_area' => Yii::t('app', 'Total Area'),
            'communication_id' => Yii::t('app', 'Communication ID'),
            'exclusive_user_id' => Yii::t('app', 'Exclusive User ID'),
            'housing' => Yii::t('app', 'Housing'),
            'detached_building' => Yii::t('app', 'Detached Building'),
            'documents' => Yii::t('app', 'Documents'),
            'rent' => Yii::t('app', 'Rent'),
            'topicality' => Yii::t('app', 'Topicality'),
            'avtorampa' => Yii::t('app', 'Avtorampa'),
            'red_line' => Yii::t('app', 'Red Line'),
            'infinite_period' => Yii::t('app', 'Infinite Period'),
            'separate_entrance' => Yii::t('app', 'Separate Entrance'),
            'delivered' => Yii::t('app', 'Delivered'),
            'phone_line' => Yii::t('app', 'Phone Line'),
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
            ],
            'realty' => [
                'class' => 'common\behaviors\RealtyBehave',
            ]
        ];
    }
}
