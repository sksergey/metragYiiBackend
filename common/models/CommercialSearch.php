<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Commercial;

/**
 * CommercialSearch represents the model behind the search form about `common\models\Commercial`.
 */
class CommercialSearch extends Commercial
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_object_id', 'count_room', 'ownership_id', 'floor', 'floor_all', 'city_or_region', 'region_kharkiv_admin_id', 'locality_id', 'course_id', 'region_id', 'region_kharkiv_id', 'street_id', 'exchange', 'condit_id', 'source_info_id', 'mediator_id', 'metro_id', 'communication_id', 'exclusive_user_id', 'housing', 'detached_building', 'documents', 'rent', 'topicality', 'avtorampa', 'red_line', 'infinite_period', 'separate_entrance', 'delivered', 'phone_line', 'author_id', 'update_author_id', 'update_photo_user_id', 'enabled'], 'integer'],
            [['number_office', 'corps', 'exchange_formula', 'landmark', 'phone', 'comment', 'note', 'notesite', 'date_added', 'date_modified', 'date_modified_photo'], 'safe'],
            [['price', 'price_square_meter', 'total_area_house', 'total_area'], 'number'],
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
        $query = Commercial::find();

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
            'count_room' => $this->count_room,
            'ownership_id' => $this->ownership_id,
            'floor' => $this->floor,
            'floor_all' => $this->floor_all,
            'city_or_region' => $this->city_or_region,
            'region_kharkiv_admin_id' => $this->region_kharkiv_admin_id,
            'locality_id' => $this->locality_id,
            'course_id' => $this->course_id,
            'region_id' => $this->region_id,
            'region_kharkiv_id' => $this->region_kharkiv_id,
            'street_id' => $this->street_id,
            'exchange' => $this->exchange,
            'condit_id' => $this->condit_id,
            'source_info_id' => $this->source_info_id,
            'price' => $this->price,
            'price_square_meter' => $this->price_square_meter,
            'mediator_id' => $this->mediator_id,
            'metro_id' => $this->metro_id,
            'total_area_house' => $this->total_area_house,
            'total_area' => $this->total_area,
            'communication_id' => $this->communication_id,
            'exclusive_user_id' => $this->exclusive_user_id,
            'housing' => $this->housing,
            'detached_building' => $this->detached_building,
            'documents' => $this->documents,
            'rent' => $this->rent,
            'topicality' => $this->topicality,
            'avtorampa' => $this->avtorampa,
            'red_line' => $this->red_line,
            'infinite_period' => $this->infinite_period,
            'separate_entrance' => $this->separate_entrance,
            'delivered' => $this->delivered,
            'phone_line' => $this->phone_line,
            'date_added' => $this->date_added,
            'date_modified' => $this->date_modified,
            'date_modified_photo' => $this->date_modified_photo,
            'author_id' => $this->author_id,
            'update_author_id' => $this->update_author_id,
            'update_photo_user_id' => $this->update_photo_user_id,
            'enabled' => $this->enabled,
        ]);

        $query->andFilterWhere(['like', 'number_office', $this->number_office])
            ->andFilterWhere(['like', 'corps', $this->corps])
            ->andFilterWhere(['like', 'exchange_formula', $this->exchange_formula])
            ->andFilterWhere(['like', 'landmark', $this->landmark])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'notesite', $this->notesite]);

        return $dataProvider;
    }
}
