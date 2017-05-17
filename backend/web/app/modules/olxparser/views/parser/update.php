<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\olxparser\models\Parser */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Parser',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parsers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="parser-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
