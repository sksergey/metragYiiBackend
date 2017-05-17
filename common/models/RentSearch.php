<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Rent;

/**
 * RentSearch represents the model behind the search form about `common\models\Rent`.
 */
class RentSearch extends Rent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_object_id', 'count_room', 'count_room_rent', 'floor', 'floor_all', 'city_or_region', 'region_kharkiv_admin_id', 'locality_id', 'course_id', 'region_id', 'region_kharkiv_id', 'street_id', 'condit_id', 'source_info_id', 'comfort_id', 'metro_id', 'exclusive_user_id', 'tv', 'refrigerator', 'entry', 'washer', 'furniture', 'conditioner', 'garage', 'phone_line', 'author_id', 'update_author_id', 'update_photo_user_id', 'enabled'], 'integer'],
            [['number_building', 'corps', 'number_apartment', 'landmark', 'price_note', 'phone', 'phone_site', 'email_site', 'comment', 'note', 'notesite', 'date_added', 'date_modified', 'date_modified_photo'], 'safe'],
            [['price'], 'number'],
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
        $query = Rent::find();

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
            'count_room_rent' => $this->count_room_rent,
            'floor' => $this->floor,
            'floor_all' => $this->floor_all,
            'city_or_region' => $this->city_or_region,
            'region_kharkiv_admin_id' => $this->region_kharkiv_admin_id,
            'locality_id' => $this->locality_id,
            'course_id' => $this->course_id,
            'region_id' => $this->region_id,
            'region_kharkiv_id' => $this->region_kharkiv_id,
            'street_id' => $this->street_id,
            'condit_id' => $this->condit_id,
            'source_info_id' => $this->source_info_id,
            'price' => $this->price,
            'comfort_id' => $this->comfort_id,
            'metro_id' => $this->metro_id,
            'exclusive_user_id' => $this->exclusive_user_id,
            'tv' => $this->tv,
            'refrigerator' => $this->refrigerator,
            'entry' => $this->entry,
            'washer' => $this->washer,
            'furniture' => $this->furniture,
            'conditioner' => $this->conditioner,
            'garage' => $this->garage,
            'phone_line' => $this->phone_line,
            'date_added' => $this->date_added,
            'date_modified' => $this->date_modified,
            'date_modified_photo' => $this->date_modified_photo,
            'author_id' => $this->author_id,
            'update_author_id' => $this->update_author_id,
            'update_photo_user_id' => $this->update_photo_user_id,
            'enabled' => $this->enabled,
        ]);

        $query->andFilterWhere(['like', 'number_building', $this->number_building])
            ->andFilterWhere(['like', 'corps', $this->corps])
            ->andFilterWhere(['like', 'number_apartment', $this->number_apartment])
            ->andFilterWhere(['like', 'landmark', $this->landmark])
            ->andFilterWhere(['like', 'price_note', $this->price_note])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'phone_site', $this->phone_site])
            ->andFilterWhere(['like', 'email_site', $this->email_site])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'notesite', $this->notesite]);

        return $dataProvider;
    }
}
