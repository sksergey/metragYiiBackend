<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TypeRealty */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Type Realty',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Type Realties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->type_realty_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="type-realty-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>