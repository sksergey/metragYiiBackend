<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "source_info".
 *
 * @property integer $source_info_id
 * @property string $name
 */
class SourceInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'source_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'source_info_id' => Yii::t('app', 'Source Info ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
