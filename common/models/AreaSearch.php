<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Area;

/**
 * AreaSearch represents the model behind the search form about `common\models\Area`.
 */
class AreaSearch extends Area
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_object_id', 'partsite_id', 'city_or_region', 'region_kharkiv_admin_id', 'locality_id', 'course_id', 'region_id', 'region_kharkiv_id', 'street_id', 'exchange', 'source_info_id', 'mediator_id', 'water_id', 'sewage_id', 'purpose_id', 'gas_id', 'house_demolition', 'exclusive_user_id', 'phone_line', 'state_act', 'electric', 'author_id', 'update_author_id', 'update_photo_user_id', 'enabled'], 'integer'],
            [['number_building', 'exchange_formula', 'landmark', 'phone', 'comment', 'note', 'notesite', 'date_added', 'date_modified', 'date_modified_photo'], 'safe'],
            [['price', 'total_area'], 'number'],
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
        $query = Area::find();

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
        $query->andFilterWhere([
            'id' => $this->id,
            'type_object_id' => $this->type_object_id,
            'partsite_id' => $this->partsite_id,
            'city_or_region' => $this->city_or_region,
            'region_kharkiv_admin_id' => $this->region_kharkiv_admin_id,
            'locality_id' => $this->locality_id,
            'course_id' => $this->course_id,
            'region_id' => $this->region_id,
            'region_kharkiv_id' => $this->region_kharkiv_id,
            'street_id' => $this->street_id,
            'exchange' => $this->exchange,
            'source_info_id' => $this->source_info_id,
            'price' => $this->price,
            'mediator_id' => $this->mediator_id,
            'water_id' => $this->water_id,
            'total_area' => $this->total_area,
            'sewage_id' => $this->sewage_id,
            'purpose_id' => $this->purpose_id,
            'gas_id' => $this->gas_id,
            'house_demolition' => $this->house_demolition,
            'exclusive_user_id' => $this->exclusive_user_id,
            'phone_line' => $this->phone_line,
            'state_act' => $this->state_act,
            'electric' => $this->electric,
            'date_added' => $this->date_added,
            'date_modified' => $this->date_modified,
            'date_modified_photo' => $this->date_modified_photo,
            'author_id' => $this->author_id,
            'update_author_id' => $this->update_author_id,
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
