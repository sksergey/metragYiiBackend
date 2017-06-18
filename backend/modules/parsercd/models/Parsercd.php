<?php

namespace app\modules\parsercd\models;

use backend\models\Metro;
use backend\models\RegionKharkiv;
use backend\models\Street;
use Yii;

/**
 * This is the model class for table "parsercd".
 *
 * @property integer $id
 * @property integer $region_kharkiv_id
 * @property integer $street_id
 * @property integer $metro_id
 * @property string $link1
 * @property string $link2
 * @property string $date
 * @property integer $type_object_id
 * @property integer $count_room
 * @property integer $floor
 * @property integer $floor_all
 * @property integer $total_area
 * @property integer $floor_area
 * @property integer $kitchen_area
 * @property integer $price
 * @property string $phone
 * @property string $status
 * @property string $note
 * @property integer $kolfoto
 * @property string $image
 * @property string $view
 */
class Parsercd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parsercd';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_kharkiv_id', 'street_id', 'metro_id', 'type_object_id', 'count_room', 'floor', 'floor_all', 'total_area', 'floor_area', 'kitchen_area', 'price', 'kolfoto'], 'integer'],
            [['link1', 'link2', 'phone', 'status', 'note', 'image', 'view'], 'string'],
            [['date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'region_kharkiv_id' => Yii::t('app', 'Region Kharkiv ID'),
            'street_id' => Yii::t('app', 'Street ID'),
            'metro_id' => Yii::t('app', 'Metro ID'),
            'link1' => Yii::t('app', 'Link1'),
            'link2' => Yii::t('app', 'Link2'),
            'date' => Yii::t('app', 'Date'),
            'type_object_id' => Yii::t('app', 'Type Object ID'),
            'count_room' => Yii::t('app', 'Count Room'),
            'floor' => Yii::t('app', 'Floor'),
            'floor_all' => Yii::t('app', 'Floor All'),
            'total_area' => Yii::t('app', 'Total Area'),
            'floor_area' => Yii::t('app', 'Floor Area'),
            'kitchen_area' => Yii::t('app', 'Kitchen Area'),
            'price' => Yii::t('app', 'Price'),
            'phone' => Yii::t('app', 'Phone'),
            'status' => Yii::t('app', 'Status'),
            'note' => Yii::t('app', 'Note'),
            'kolfoto' => Yii::t('app', 'Kolfoto'),
            'image' => Yii::t('app', 'Image'),
            'view' => Yii::t('app', 'View'),
        ];
    }

    /*
    public function saveFromParser($obj){
        $result = false;
        if(!empty($obj)){
            $this->link = $obj['Ссылка'];
            $this->path = $obj['Ссылка'];
            $this->date = $obj['Дата'];
            $this->type_object_id = '12';
            $this->count_room = $obj['Кол.комн.'];
            $this->floor = $obj['Эт'];
            $this->floor_all = $obj['Этажн'];
            $this->total_area = $obj['Общ'];
            $this->floor_area = $obj['Жил'];
            $this->kitchen_area = $obj['Кух'];
            $this->price = $obj['Цена'];
            $this->phone = $obj['Тел'];
            $this->status = '1';
            $this->note = $obj['Текст'];
            $this->kolfoto = null;
            $this->image = null;
            $this->view = 'no';
            $result = $this->save();
        }
        return $result;
    }
*/
    public function saveFromParser($obj){
        $result = false;
        if(!empty($obj)){
            if(!empty($obj['L'])){
                //$this->link = RegionKharkiv::$obj['L'];}
                //$street = explode('ул.,пр. ');
                $this->region_kharkiv_id = RegionKharkiv::findOne('like', ['name' => trim($obj['L'])])->region_kharkiv_id;
            }
            if(!empty($obj['M'])){
                //$this->link = Street::$obj['M'];}
                $this->street_id = Street::findOne('like', ['name' => trim($obj['M'])])->street_id;
            }
            if(!empty($obj['N'])){
                //$this->link = Metro::$obj['N'];}
                $this->metro_id = Metro::findOne('like', ['name' => trim($obj['N'])])->metro_id;
            }
            $this->link1 = $obj['Z'];
            $this->link2 = $obj['AA'];
            $this->date = $obj['D'];
            $this->type_object_id = '12';
            $this->count_room = $obj['O'];
            $this->floor = $obj['P'];
            $this->floor_all = $obj['Q'];
            $this->total_area = $obj['R'];
            $this->floor_area = $obj['S'];
            $this->kitchen_area = $obj['T'];
            $this->price = $obj['U'];
            $this->phone = trim($obj['V']);
            if(trim($obj['W']) != ''){
                $this->phone .= ', '.trim($obj['W']);
            }
            if(trim($obj['X']) != ''){
                $this->phone .= ', '.trim($obj['X']);
            }
            $this->status = 'wait';
            $this->note = $obj['AB'];
            $this->kolfoto = null;
            $this->image = null;
            $this->view = 'no';
            $result = $this->save();
        }
        return $result;
    }
}
