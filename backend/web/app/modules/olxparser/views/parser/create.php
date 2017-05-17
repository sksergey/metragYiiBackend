<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\olxparser\models\Parser */

$this->title = Yii::t('app', 'Create Parser');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parsers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parser-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
