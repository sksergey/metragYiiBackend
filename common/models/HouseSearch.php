<?php

namespace common\models;

use backend\models\Parthouse;
use backend\models\Partsite;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\House;
use backend\models\RegionKharkivAdmin;
use backend\models\TypeObject;
/**
 * HouseSearch represents the model behind the search form about `common\models\House`.
 */
class HouseSearch extends House
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'count_room', 'floor_all', 'city_or_region', 'locality_id', 'course_id', 'region_id', 'region_kharkiv_id', 'street_id', 'exchange', 'condit_id', 'source_info_id', 'mediator_id', 'metro_id', 'building_year', 'sewage_id', 'wall_material_id', 'gas_id', 'water_id', 'comfort_id', 'exclusive_user_id', 'phone_line', 'state_act', 'author_id', 'update_photo_user_id', 'enabled'], 'integer'],
            [['region_kharkiv_admin_id', 'update_author_id', 'partsite_id', 'parthouse_id', 'type_object_id', 'number_building', 'exchange_formula', 'landmark', 'phone', 'comment', 'note', 'notesite', 'date_added', 'date_modified', 'date_modified_photo'], 'safe'],
            [['price', 'total_area_house', 'total_area'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = House::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        if(!empty($this->type_object_id)){
            $type_object_id = TypeObject::find()->where(['like', 'name', $this->type_object_id])->one()->type_object_id;
        }
        if(!empty($this->region_kharkiv_admin_id)){
            $region_kharkiv_admin_id = RegionKharkivAdmin::find()->where(['like', 'name', $this->region_kharkiv_admin_id])->one()->region_kharkiv_admin_id;
        }
        if(!empty($this->update_author_id)){
            $update_author_id = User::find()->where(['like', 'username', $this->update_author_id])->one()->id;
        }
        if(!empty($this->partsite_id)){
            $partsite_id = Partsite::find()->where(['like', 'name', $this->partsite_id])->one()->partsite_id;
        }
        if(!empty($this->parthouse_id)){
            $parthouse_id = Parthouse::find()->where(['like', 'name', $this->parthouse_id])->one()->parthouse_id;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'type_object_id' => $type_object_id,
            'count_room' => $this->count_room,
            'partsite_id' => $partsite_id,
            'parthouse_id' => $parthouse_id,
            'floor_all' => $this->floor_all,
            'city_or_region' => $this->city_or_region,
            'region_kharkiv_admin_id' => $region_kharkiv_admin_id,
            'locality_id' => $this->locality_id,
            'course_id' => $this->course_id,
            'region_id' => $this->region_id,
            'region_kharkiv_id' => $this->region_kharkiv_id,
            'street_id' => $this->street_id,
            'exchange' => $this->exchange,
            'condit_id' => $this->condit_id,
            'source_info_id' => $this->source_info_id,
            'price' => $this->price,
            'mediator_id' => $this->mediator_id,
            'metro_id' => $this->metro_id,
            'total_area_house' => $this->total_area_house,
            'total_area' => $this->total_area,
            'building_year' => $this->building_year,
            'sewage_id' => $this->sewage_id,
            'wall_material_id' => $this->wall_material_id,
            'gas_id' => $this->gas_id,
            'water_id' => $this->water_id,
            'comfort_id' => $this->comfort_id,
            'exclusive_user_id' => $this->exclusive_user_id,
            'phone_line' => $this->phone_line,
            'state_act' => $this->state_act,
            'date_added' => $this->date_added,
            'date_modified' => $this->date_modified,
            'date_modified_photo' => $this->date_modified_photo,
            'author_id' => $this->author_id,
            'update_author_id' => $update_author_id,
            'update_photo_user_id' => $this->update_photo_user_id,
            'enabled' => $this->enabled,
        ]);

        $query->andFilterWhere(['like', 'number_building', $this->number_building])
            ->andFilterWhere(['like', 'exchange_formula', $this->exchange_formula])
            ->andFilterWhere(['like', 'landmark', $this->landmark])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'notesite', $this->notesite]);

        return $dataProvider;
    }
}
