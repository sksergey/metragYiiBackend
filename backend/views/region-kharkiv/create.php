<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RegionKharkiv */

$this->title = Yii::t('app', 'Create Region Kharkiv');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Region Kharkivs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-kharkiv-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
