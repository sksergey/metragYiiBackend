<?php

namespace common\models;

use backend\models\Condit;
use backend\models\Layout;
use backend\models\Mediator;
use backend\models\RegionKharkiv;
use backend\models\RegionKharkivAdmin;
use backend\models\Street;
use backend\models\TypeObject;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Apartment;

/**
 * ApartmentSearch represents the model behind the search form about `common\models\Apartment`.
 */
class ApartmentSearch extends Apartment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'count_room', 'floor', 'floor_all', 'city_or_region', 'locality_id', 'course_id', 'region_id', 'exchange', 'source_info_id', 'metro_id', 'wc_id', 'count_balcony', 'count_balcony_glazed', 'exclusive_user_id', 'phone_line', 'bath', 'update_photo_user_id', 'enabled'], 'integer'],
            [['condit_id', 'mediator_id', 'wall_material_id', 'author_id', 'layout_id', 'region_kharkiv_id', 'street_id', 'update_author_id', 'region_kharkiv_admin_id', 'type_object_id', 'number_building', 'corps', 'number_apartment', 'exchange_formula', 'landmark', 'phone', 'comment', 'note', 'notesite', 'date_added', 'date_modified', 'date_modified_photo'], 'safe'],
            [['price', 'total_area', 'floor_area', 'kitchen_area'], 'number'],
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
        $query = Apartment::find();

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
        //'condit_id', 'mediator_id', 'wall_material_id', 'author_id', 'layout_id', 'region_kharkiv_id', 'street_id',
        // grid filtering conditions

        if(!empty($this->type_object_id)){
            $type_object_id = TypeObject::find()->where(['like', 'name', $this->type_object_id])->one()->type_object_id;
        }
        //if(!empty($this->region_kharkiv_admin_id)){
        //    $region_kharkiv_admin_id = RegionKharkivAdmin::find()->where(['like', 'name', $this->region_kharkiv_admin_id])->one()->region_kharkiv_admin_id;
        //}
        //if(!empty($this->update_author_id)){
        //    $update_author_id = User::find()->where(['like', 'username', $this->update_author_id])->one()->id;
        //}
        if(!empty($this->condit_id)){
            $condit_id = Condit::find()->where(['like', 'name', $this->condit_id])->one()->condit_id;
        }
        if(!empty($this->mediator_id)){
            $mediator_id = Mediator::find()->where(['like', 'name', $this->mediator_id])->one()->mediator_id;
        }
        if(!empty($this->wall_material_id)){
            $wall_material_id = WallMaterial::find()->where(['like', 'name', $this->wall_material_id])->one()->wall_material_id;
        }
        if(!empty($this->author_id)){
            $author_id = User::find()->where(['like', 'username', $this->author_id])->one()->id;
        }
        if(!empty($this->layout_id)){
            $layout_id = Layout::find()->where(['like', 'name', $this->layout_id])->one()->layout_id;
        }
        if(!empty($this->region_kharkiv_id)){
            $region_kharkiv_id = RegionKharkiv::find()->where(['like', 'name', $this->region_kharkiv_id])->one()->region_kharkiv_id;
        }
        if(!empty($this->street_id)){
            $street_id = Street::find()->where(['like', 'name', $this->street_id])->one()->street_id;
        }



        $query->andFilterWhere([
            'id' => $this->id,
            //'type_object_id' => $this->type_object_id,
            'type_object_id' => $type_object_id,
            'count_room' => $this->count_room,
            'layout_id' => $layout_id,
            'floor' => $this->floor,
            'floor_all' => $this->floor_all,
            'city_or_region' => $this->city_or_region,
            //'region_kharkiv_admin_id' => $this->region_kharkiv_admin_id,
            //'region_kharkiv_admin_id' => $region_kharkiv_admin_id,
            'locality_id' => $this->locality_id,
            'course_id' => $this->course_id,
            'region_id' => $this->region_id,
            'region_kharkiv_id' => $region_kharkiv_id,
            'street_id' => $street_id,
            'exchange' => $this->exchange,
            'condit_id' => $condit_id,
            'source_info_id' => $this->source_info_id,
            'price' => $this->price,
            'mediator_id' => $mediator_id,
            'metro_id' => $this->metro_id,
            'total_area' => $this->total_area,
            'floor_area' => $this->floor_area,
            'kitchen_area' => $this->kitchen_area,
            'wc_id' => $this->wc_id,
            'wall_material_id' => $wall_material_id,
            'count_balcony' => $this->count_balcony,
            'count_balcony_glazed' => $this->count_balcony_glazed,
            'exclusive_user_id' => $this->exclusive_user_id,
            'phone_line' => $this->phone_line,
            'bath' => $this->bath,
            'date_added' => $this->date_added,
            'date_modified' => $this->date_modified,
            'date_modified_photo' => $this->date_modified_photo,
            'author_id' => $author_id,
            //'update_author_id' => $this->update_author_id,
            //'update_author_id' => $update_author_id,
            'update_photo_user_id' => $this->update_photo_user_id,
            'enabled' => $this->enabled,
        ]);

        $query->andFilterWhere(['like', 'number_building', $this->number_building])
            ->andFilterWhere(['like', 'corps', $this->corps])
            ->andFilterWhere(['like', 'number_apartment', $this->number_apartment])
            ->andFilterWhere(['like', 'exchange_formula', $this->exchange_formula])
            ->andFilterWhere(['like', 'landmark', $this->landmark])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'notesite', $this->notesite]);

        $query->orderBy(['id' => SORT_DESC]);

        return $dataProvider;
    }
}
