<style>
	.scroolbox
	{
		height: 200px; 
		overflow-y: scroll;
		width: 80%;
		margin: 0px 0px 20px 0px;
	}
	.divider-horizontal
	{
		height: 1px;
		margin: 20px 0px 20px 0px;
		background-color: #9d9d9d;
	}
</style>
<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

use app\models\Apartment;
use app\models\ApartmentFind;
use app\models\RegionKharkivAdmin;
use app\models\TypeObject;
use app\models\Locality;
use app\models\RegionKharkiv;
use app\models\Region;
use app\models\Street;
use app\models\Course;
use app\models\WallMaterial;
use app\models\Condit;
use app\models\Wc;
use app\models\Users;
use app\models\UserType;

?>
<?php $form = ActiveForm::begin([
          'method' => 'get',
          'action' => ['apartment/searchresult'],
      ]); ?>

<div class="col-xs-12 col-sm-12 col-md-12">
  	<div class="container">
		<div class="col-xs-6 col-sm-3 col-md-1 ">
		<label for="">ID</label>	
		<?= $form->field($model['ApartmentFind'],'idFrom')->textInput()->label(\Yii::t('yii','from')); ?>
		<?= $form->field($model['ApartmentFind'],'idTo')->textInput()->label(\Yii::t('yii','to')); ?>
		</div>
		<div class="col-xs-6 col-sm-3 col-md-1 ">
		<label for="">Комнат</label>	
		<?= $form->field($model['ApartmentFind'],'count_roomFrom')->textInput()->label(\Yii::t('yii','from')); ?>
		<?= $form->field($model['ApartmentFind'],'count_roomTo')->textInput()->label(\Yii::t('yii','to')); ?>
		</div>
		<div class="col-xs-6 col-sm-3 col-md-1 ">
		<label for="">Цена</label>	
		<?= $form->field($model['ApartmentFind'],'priceFrom')->textInput()->label(\Yii::t('yii','from')); ?>
		<?= $form->field($model['ApartmentFind'],'priceTo')->textInput()->label(\Yii::t('yii','to')); ?>
		</div>
		<div class="col-xs-6 col-sm-3 col-md-1 ">
		<label for="">Этаж</label>	
		<?= $form->field($model['ApartmentFind'],'floorFrom')->textInput()->label(\Yii::t('yii','from')); ?>
		<?= $form->field($model['ApartmentFind'],'floorTo')->textInput()->label(\Yii::t('yii','to')); ?>
		</div>
		<div class="col-xs-6 col-sm-3 col-md-1 ">
		<label for="">Этажность</label>	
		<?= $form->field($model['ApartmentFind'],'floor_allFrom')->textInput()->label(\Yii::t('yii','from')); ?>
		<?= $form->field($model['ApartmentFind'],'floor_allTo')->textInput()->label(\Yii::t('yii','to')); ?>
		</div>
		<div class="col-xs-6 col-sm-3 col-md-1 ">
		<label for="">Пл общ</label>	
		<?= $form->field($model['ApartmentFind'],'total_areaFrom')->textInput()->label(\Yii::t('yii','from')); ?>
		<?= $form->field($model['ApartmentFind'],'total_areaTo')->textInput()->label(\Yii::t('yii','to')); ?>
		</div>
		<div class="col-xs-6 col-sm-3 col-md-1 ">
		<label for="">Пл жил</label>	
		<?= $form->field($model['ApartmentFind'],'floor_areaFrom')->textInput()->label(\Yii::t('yii','from')); ?>
		<?= $form->field($model['ApartmentFind'],'floor_areaTo')->textInput()->label(\Yii::t('yii','to')); ?>
		</div>
		<div class="col-xs-6 col-sm-3 col-md-1 ">
		<label for="">Пл кухни</label>	
		<?= $form->field($model['ApartmentFind'],'kitchen_areaFrom')->textInput()->label(\Yii::t('yii','from')); ?>
		<?= $form->field($model['ApartmentFind'],'kitchen_areaFrom')->textInput()->label(\Yii::t('yii','to')); ?>
		</div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 divider-horizontal"></div>

<?
    echo $form->field($model['TypeObject'], 'type_object_id',[
        'template' => "<div class=\"col-xs-6 col-sm-4 col-md-3 \">{label}\n<div class=\"scroolbox\">{input}</div></div>"])->checkboxList(
    TypeObject::find()->select(['name', 'type_object_id'])->where(['type_realty_id'=>'2'])->indexBy('type_object_id')->column(),
    ['prompt'=>'Select type'])->label('Тип объекта');
?>
	
<?
    echo $form->field($model['RegionKharkivAdmin'], 'region_kharkiv_admin_id',[
        'template' => "<div class=\"col-xs-6 col-sm-4 col-md-3 \">{label}\n<div class=\"scroolbox\">{input}</div></div>"])->checkboxList(
    RegionKharkivAdmin::find()->select(['name', 'region_kharkiv_admin_id'])->orderby('name')->indexBy('region_kharkiv_admin_id')->column(),
    ['prompt'=>'Select region'])->label('РайонАдмин/Харьков');
?>
	
<?
    echo $form->field($model['RegionKharkiv'], 'region_kharkiv_id',[
        'template' => "<div class=\"col-xs-6 col-sm-4 col-md-3 \">{label}\n<div class=\"scroolbox\">{input}</div></div>"])->checkboxList(
    RegionKharkiv::find()->select(['name', 'region_kharkiv_id'])->orderby('name')->indexBy('region_kharkiv_id')->column(),
    ['prompt'=>'Select region'])->label('Район/Харьков');
?>

<?
    echo $form->field($model['Region'], 'region_id',[
        'template' => "<div class=\"col-xs-6 col-sm-4 col-md-3 \">{label}\n<div class=\"scroolbox\">{input}</div></div>"])->checkboxList(
    Region::find()->select(['name', 'region_id'])->orderby('name')->indexBy('region_id')->column(),
    ['prompt'=>'Select region'])->label('Район/Область');
?>

<div class="col-xs-12 col-sm-12 col-md-12 divider-horizontal"></div>
	
<?
    echo $form->field($model['Locality'], 'locality_id',[
        'template' => "<div class=\"col-xs-6 col-sm-4 col-md-3 \">{label}\n<div class=\"scroolbox\">{input}</div></div>"])->checkboxList(
    Locality::find()->select(['name', 'locality_id'])->orderby('name')->indexBy('locality_id')->column())->label('Населенный пункт');
?>
	
<?
    echo $form->field($model['Course'], 'course_id',[
        'template' => "<div class=\"col-xs-6 col-sm-4 col-md-3 \">{label}\n<div class=\"scroolbox\">{input}</div></div>"])->checkboxList(
    Course::find()->select(['name', 'course_id'])->orderby('name')->indexBy('course_id')->column())->label('Направление');
?>

<?
    echo $form->field($model['Street'], 'street_id',[
        'template' => "<div class=\"col-xs-6 col-sm-4 col-md-3 \">{label}\n<div class=\"scroolbox\">{input}</div></div>"])->checkboxList(
    Street::find()->select(['name', 'street_id'])->orderby('name')->indexBy('street_id')->column())->label('Улица');
?>
	
<?
    echo $form->field($model['WallMaterial'], 'wall_material_id',[
        'template' => "<div class=\"col-xs-6 col-sm-4 col-md-3 \">{label}\n<div class=\"scroolbox\">{input}</div></div>"])->checkboxList(
    WallMaterial::find()->select(['name', 'wall_material_id'])->orderby('name')->indexBy('wall_material_id')->column())->label('Стены');
?>
	
<div class="col-xs-12 col-sm-12 col-md-12 divider-horizontal"></div>

<?
    echo $form->field($model['Condit'], 'condit_id',[
        'template' => "<div class=\"col-xs-6 col-sm-4 col-md-3 \">{label}\n<div class=\"scroolbox\">{input}</div></div>"])->checkboxList(
    Condit::find()->select(['name', 'condit_id'])->orderby('name')->indexBy('condit_id')->column())->label('Состояние');
?>

<?
    echo $form->field($model['Wc'], 'wc_id',[
        'template' => "<div class=\"col-xs-6 col-sm-4 col-md-3 \">{label}\n<div class=\"scroolbox\">{input}</div></div>"])->checkboxList(
    Wc::find()->select(['name', 'wc_id'])->orderby('name')->indexBy('wc_id')->column())->label('Сан. узел');
?>
	
<?
    echo $form->field($model['UserType'], 'author_id',[
        'template' => "<div class=\"col-xs-6 col-sm-4 col-md-3 \">{label}\n<div class=\"scroolbox\">{input}</div></div>"])->checkboxList(
    Users::find()->select(['name', 'id'])->orderby('name')->indexBy('id')->column())->label('Автор');
?>

<?
    echo $form->field($model['UserType'], 'update_author_id',[
        'template' => "<div class=\"col-xs-6 col-sm-4 col-md-3 \">{label}\n<div class=\"scroolbox\">{input}</div></div>"])->checkboxList(
    Users::find()->select(['name', 'id'])->orderby('name')->indexBy('id')->column())->label('Изменил дпи');
?>

<div class="col-xs-12 col-sm-12 col-md-12 divider-horizontal"></div>
	
<?
    echo $form->field($model['UserType'], 'update_photo_user_id',[
        'template' => "<div class=\"col-xs-6 col-sm-4 col-md-3 \">{label}\n<div class=\"scroolbox\">{input}</div></div>"])->checkboxList(
    Users::find()->select(['name', 'id'])->orderby('name')->indexBy('id')->column())->label('Кто обновил фото');
?>
	
<?
    echo $form->field($model['UserType'], 'exclusive_user_id',[
        'template' => "<div class=\"col-xs-6 col-sm-4 col-md-3 \">{label}\n<div class=\"scroolbox\">{input}</div></div>"])->checkboxList(
    Users::find()->select(['name', 'id'])->orderby('name')->indexBy('id')->column())->label('Экслюзив');
?>

<div class="col-xs-12 col-sm-12 col-md-12 divider-horizontal"></div>	

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>