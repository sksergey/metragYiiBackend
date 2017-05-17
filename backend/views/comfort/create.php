<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Comfort */

$this->title = Yii::t('app', 'Create Comfort');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comforts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comfort-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
