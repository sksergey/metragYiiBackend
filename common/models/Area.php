<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "area".
 *
 * @property integer $id
 * @property integer $type_object_id
 * @property integer $partsite_id
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
 * @property integer $source_info_id
 * @property string $price
 * @property integer $mediator_id
 * @property string $phone
 * @property integer $water_id
 * @property string $total_area
 * @property integer $sewage_id
 * @property integer $purpose_id
 * @property integer $gas_id
 * @property integer $house_demolition
 * @property integer $exclusive_user_id
 * @property integer $phone_line
 * @property integer $state_act
 * @property integer $electric
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
class Area extends \yii\db\ActiveRecord
{
    public $imageFiles;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_object_id', 'partsite_id', 'city_or_region', 'street_id', 'source_info_id', 'price', 'water_id', 'total_area', 'sewage_id', 'gas_id', 'enabled'], 'required'],
            [['type_object_id', 'partsite_id', 'city_or_region', 'region_kharkiv_admin_id', 'locality_id', 'course_id', 'region_id', 'region_kharkiv_id', 'street_id', 'exchange', 'source_info_id', 'mediator_id', 'water_id', 'sewage_id', 'purpose_id', 'gas_id', 'house_demolition', 'exclusive_user_id', 'phone_line', 'state_act', 'electric', 'author_id', 'update_author_id', 'update_photo_user_id', 'enabled'], 'integer'],
            [['price', 'total_area'], 'number'],
            [['comment', 'note', 'notesite'], 'string'],
            [['date_added', 'date_modified', 'date_modified_photo'], 'safe'],
            [['number_building', 'exchange_formula', 'landmark', 'phone'], 'string', 'max' => 255],
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
            'partsite_id' => Yii::t('app', 'Partsite'),
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
            'source_info_id' => Yii::t('app', 'Source Info'),
            'price' => Yii::t('app', 'Price'),
            'mediator_id' => Yii::t('app', 'Mediator'),
            'phone' => Yii::t('app', 'Phone'),
            'water_id' => Yii::t('app', 'Water'),
            'total_area' => Yii::t('app', 'Total Area'),
            'sewage_id' => Yii::t('app', 'Sewage'),
            'purpose_id' => Yii::t('app', 'Purpose'),
            'gas_id' => Yii::t('app', 'Gas'),
            'house_demolition' => Yii::t('app', 'House Demolition'),
            'exclusive_user_id' => Yii::t('app', 'Exclusive User'),
            'phone_line' => Yii::t('app', 'Phone Line'),
            'state_act' => Yii::t('app', 'State Act'),
            'electric' => Yii::t('app', 'Electric'),
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
}
