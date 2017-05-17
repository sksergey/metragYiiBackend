<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\olxparser\models\Parser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parser-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'advert_id')->textInput() ?>

    <?= $form->field($model, 'link')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'path')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type_object_id')->textInput() ?>

    <?= $form->field($model, 'advert_from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type_flat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'count_room')->textInput() ?>

    <?= $form->field($model, 'floor')->textInput() ?>

    <?= $form->field($model, 'floor_all')->textInput() ?>

    <?= $form->field($model, 'total_area')->textInput() ?>

    <?= $form->field($model, 'floor_area')->textInput() ?>

    <?= $form->field($model, 'kitchen_area')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'kolfoto')->textInput() ?>

    <?= $form->field($model, 'image')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'view')->dropDownList([ 'neprov' => 'Neprov', 'no' => 'No', 'yes' => 'Yes', 'tel' => 'Tel', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
