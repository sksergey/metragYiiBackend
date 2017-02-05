<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Condit */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Condit',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Condits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->condit_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="condit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
