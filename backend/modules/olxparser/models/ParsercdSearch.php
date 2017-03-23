<?php
namespace app\modules\olxparser\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ParsercdSearch extends Parsercd
{

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Parsercd::find()->orderBy('id DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }
}
