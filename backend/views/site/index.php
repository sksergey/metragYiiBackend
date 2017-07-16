<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
?>
<?php

/* @var $this yii\web\View */

$this->title = Yii::t('yii', 'Metrag Admin');
?>
<div class="site-index" style="width: 30%">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    echo $form->field($model, 'type_realty')->dropDownList(
        \backend\models\TypeRealty::find()->select(['name', 'name_table'])->indexBy('name_table')->column())->label(false);
    ?>
    <?= $form->field($model, 'id')->label('ID'); ?>
    <?= $form->field($model, 'phone')->label(Yii::t('app', 'Phone')); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
