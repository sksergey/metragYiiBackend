<style>
	div.required label.control-label:after {
    content: " *";
    color: red;
	}
	label.required:after {
	    content: " *";
	    color: red;
	}
	.divider-horizontal
	{
		height: 1px;
		margin: 20px 0px 20px 0px;
		background-color: #9d9d9d;
	}
	.thumb-image
	{
		float:left;width:100px;position:relative;padding:5px;
	}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("button").click(function(){
        //$(this).hide();
        console.log("click!");
    });
});
</script>
<?php
//use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

use app\models\Apartment;
use app\models\RegionKharkivAdmin;
use app\models\TypeObject;
use app\models\Locality;
use app\models\Layout;
use app\models\RegionKharkiv;
use app\models\Region;
use app\models\Street;
use app\models\Course;
use app\models\WallMaterial;
use app\models\Condit;
use app\models\Wc;
use app\models\Users;
use app\models\Mediator;
use app\models\Metro;
use app\models\SourceInfo;

use kartik\file\FileInput;
use yii\helpers\Url;
?>
<?= $model->id; ?>
<?= 'apartment edit'; ?>

<?= $apartment->id; ?>
<?php $form = ActiveForm::begin([
          'method' => 'post',
          'action' => ['apartment/add'],
          //'options' => ['class' => 'form-inline'],
          'options' => ['enctype' => 'multipart/form-data'],
      ]); ?>


	<div class="col-xs-12 col-sm-3 col-md-3 ">
		<?= $form->field($model,'id')->textInput(['readonly' => 'true'])->label('ID'); ?>
		<?= $form->field($model, 'type_object_id')->dropdownList(
    		TypeObject::find()->select(['name', 'type_object_id'])->where(['type_realty_id'=>'2'])->indexBy('type_object_id')->column())->label('Тип объекта',['class'=>'required']); ?>
		<?= $form->field($model,'count_room')->textInput()->label('Кол. комнат',['class'=>'required']); ?>
		<?= $form->field($model, 'layout_id')->dropdownList(
    		Layout::find()->select(['name', 'layout_id'])->orderby('name')->indexBy('layout_id')->column(),['prompt'=>'Выберите тип...'])->label('Тип планировки'); ?>
    	<?= $form->field($model,'floor')->textInput()->label('Этаж'); ?>
		<?= $form->field($model,'floor_all')->textInput()->label('Этажность',['class'=>'required']); ?>

		<?= $form->field($model,'city_or_region',['inline' => true, 'template' => '{input}'])->radiolist(['0' => 'Харьков', '1' => 'Пригород'])->label(false); ?>

		<?= $form->field($model, 'region_kharkiv_admin_id')->dropdownList(RegionKharkivAdmin::find()->select(['name', 'region_kharkiv_admin_id'])->orderby('name')->indexBy('region_kharkiv_admin_id')->column(),['prompt'=>'Выберите район...'])->label('РайонАдмин/Харьков',['class'=>'required']); ?>
		<?= $form->field($model, 'region_kharkiv_id')->dropdownList(
    		RegionKharkiv::find()->select(['name', 'region_kharkiv_id'])->orderby('name')->indexBy('region_kharkiv_id')->column(),['prompt'=>'Выберите район...'])->label('Район/Харьков',['class'=>'required']); ?>
		<?= $form->field($model, 'metro_id')->dropdownList(
    		Metro::find()->select(['name', 'metro_id'])->orderby('name')->indexBy('metro_id')->column(),['prompt'=>'Выберите станцию метро...'])->label('Метро'); ?>
		
		<?= $form->field($model, 'locality_id')->dropdownList(
			Locality::find()->select(['name', 'locality_id'])->orderby('name')->indexBy('locality_id')->column(),['prompt'=>'Выберите населенный пункт...'])->label('Населенный пункт',['class'=>'required']); ?>
		<?= $form->field($model, 'course_id')->dropdownList(
    		Course::find()->select(['name', 'course_id'])->orderby('name')->indexBy('course_id')->column(),['prompt'=>'Выберите направление...'])->label('Направление',['class'=>'required']); ?>
		<?= $form->field($model, 'region_id')->dropdownList(Region::find()->select(['name', 'region_id'])->orderby('name')->indexBy('region_id')->column(),['prompt'=>'Выберите район...'])->label('Район/Область',['class'=>'required']); ?>
    	
		<?= $form->field($model, 'street_id')->dropdownList(
    		Street::find()->select(['name', 'street_id'])->orderby('name')->indexBy('street_id')->column(),['prompt'=>'Выберите улицу...'])->label('Улица',['class'=>'required']); ?>
		<?= $form->field($model,'number_building')->textInput()->label('Номер дома',['class'=>'required']); ?>
		<?= $form->field($model,'corps')->textInput()->label('Корпус',['class'=>'required']); ?>
		<?= $form->field($model,'number_apartment')->textInput()->label('Номер квартиры',['class'=>'required']); ?>
	</div>
	<div class="col-xs-12 col-sm-3 col-md-3 ">
		<?= $form->field($model,'price')->textInput()->label('Цена',['class'=>'required']); ?>
		<?= $form->field($model, 'exclusive_user_id')->dropdownList(
    		Users::find()->select(['name', 'id'])->orderby('name')->indexBy('id')->column(),['prompt'=>'Выберите пользователя...'])->label('Экслюзив'); ?>
    	<?= $form->field($model, 'mediator_id')->dropdownList(
    		Mediator::find()->select(['name', 'mediator_id'])->orderby('name')->indexBy('mediator_id')->column(),['prompt'=>'Выберите посредника...'])->label('Посредник'); ?>
		<?= $form->field($model,'landmark')->textInput()->label('Ориентир'); ?>
		<?= $form->field($model,'comment')->textInput()->label('Причина удаления/восстановления'); ?>
		<?= $form->field($model,'exchange')->checkbox()->label('Обмен'); ?>
		<?= $form->field($model,'exchange_formula')->textInput()->label('Формула обмена'); ?>
		<?= $form->field($model, 'condit_id')->dropdownList(
    		Condit::find()->select(['name', 'condit_id'])->orderby('name')->indexBy('condit_id')->column(),['prompt'=>'Выберите состояние...'])->label('Состояние',['class'=>'required']); ?>
		<?= $form->field($model, 'source_info_id')->dropdownList(
    		SourceInfo::find()->select(['name', 'source_info_id'])->orderby('name')->indexBy('source_info_id')->column(),['prompt'=>'Выберите источник...'])->label('Источник информации',['class'=>'required']); ?>
		<?= $form->field($model, 'wc_id')->dropdownList(
    		Wc::find()->select(['name', 'wc_id'])->orderby('name')->indexBy('wc_id')->column(),['prompt'=>'Выберите тип сан.узла...'])->label('Сан. узел',['class'=>'required']); ?>
		<?= $form->field($model, 'wall_material_id')->dropdownList(
    		WallMaterial::find()->select(['name', 'wall_material_id'])->orderby('name')->indexBy('wall_material_id')->column(),['prompt'=>'Выберите материал стен...'])->label('Стены',['class'=>'required']); ?>
    	<?= $form->field($model,'date_added')->textInput(['readonly' => 'true'])->label('Дата добавления'); ?>
		<?= $form->field($model,'date_modified')->textInput(['readonly' => 'true'])->label('Дата изменения'); ?>
	</div>
	<div class="col-xs-12 col-sm-3 col-md-3 ">
		<?= $form->field($model,'total_area')->textInput()->label('Площадь общая',['class'=>'required']); ?>
		<?= $form->field($model,'floor_area')->textInput()->label('Площадь жилая',['class'=>'required']); ?>
		<?= $form->field($model,'kitchen_area')->textInput()->label('Площадь кухни',['class'=>'required']); ?>
		<?= $form->field($model,'phone_line')->checkbox()->label('Телефонная линия'); ?>
		<?= $form->field($model,'bath')->checkbox()->label('Ванна'); ?>
		<?= $form->field($model,'count_balcony')->textInput()->label('Количество балконов',['class'=>'required']); ?>
		<?= $form->field($model,'count_balcony_glazed')->textInput()->label('Застекленных балконов',['class'=>'required']); ?>
		<?= $form->field($model, 'author_id')->dropdownList(
    		Users::find()->select(['name', 'id'])->where(['id'=> $model->author_id])->column(),['disabled' => 'true'])->label('Автор'); ?>
		<?//= $form->field($model, 'author_id')->textInput(['readonly' => 'true'])->label('Автор'); ?>
		<?= $form->field($model, 'update_author_id')->dropdownList(
    		Users::find()->select(['name', 'id'])->where(['id'=> $model->update_author_id])->column(),['disabled' => 'true'])->label('Изменил дпи'); ?>
    	<?//= $form->field($model, 'update_author_id')->textInput(['readonly' => 'true'])->label('Изменил дпи'); ?>
    	<?= $form->field($model, 'update_photo_user_id')->dropdownList(
    		Users::find()->select(['name', 'id'])->where(['id'=> $model->update_photo_user_id])->column(),['disabled' => 'true'])->label('Кто обновил фото'); ?>
		<?//= $form->field($model, 'update_photo_user_id')->textInput(['readonly' => 'true'])->label('Кто обновил фото'); ?>
	</div>
	<div class="col-xs-12 col-sm-3 col-md-3 ">
		<?= $form->field($model, 'note')->textarea(['rows'=>6])->label('Заметки'); ?>
		<?= $form->field($model, 'notesite')->textarea(['rows'=>6])->label('Информация для показа на сайте'); ?>
		<?= $form->field($model, 'phone')->listBox(
			Apartment::getPhonesArr($model->phone))->label('Телефоны',['class'=>'required']); ?>
		<?//= Html::button('Добавить', ['class' => 'btn btn-primary']) ?>
		<?//= Html::button('Удалить', ['class' => 'btn btn-primary']) ?>
		
		<?//= Html::a(Yii::t('app', 'Add'), ['test'], ['class' => 'btn btn-primary']) ?>
        <?//= Html::a(Yii::t('app', 'Delete'), ['test', 'id' => $model->course_id], [
          //  'class' => 'btn btn-danger',
          //  'data' => [
          //      'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
          //      'method' => 'post',
          //  ],
        //]) ?>





		<?= $form->field($model,'enabled')->checkbox()->label('Активное') ?>

	</div> 

	<div class="col-xs-12 col-sm-12 col-md-12">

	<? $images = $model->getImages();
	        	$img = [];
	        	$keys = [];
	        	
					foreach ($images as $image){
						if($image){
						//$img[] = Yii::getAlias('@webroot').'/'.$image->getPathToOrigin();
							$img[] = 'http://metrag.dev.itgo-solutions.com/frontend/web/'.$image->getPathToOrigin();
							$keys[] = ['key' => $image->id];
						 }
					}	
	?>
	
	<?= $form->field($model, 'imageFiles[]')->widget(FileInput::classname(), [
    'options' => ['multiple' => true, 'accept' => 'image/*'],
    'pluginOptions' => [
    
    'initialPreview' => $img,
    'initialPreviewAsData'=>true,
        
    'initialPreviewConfig'=> $keys,
   
    'deleteUrl' => "file-delete",
    'overwriteInitial' => false,
    
    //'browseOnZoneClick' => true,
    'initialPreviewShowDelete' => true,
    'initialPreviewShowUpload' => false,
    //'showCaption' => true,
    'showRemove' => false,
    'showUpload' => false,

    //'previewFileType' => 'image',
    
    //'uploadUrl' => Url::to(['apartment/add']),
    'uploadUrl' => 'app',
        
    //'maxFileCount' => 10,
    //'initialPreview'=> $img ,
     
    ]
		]); ?>
	
	</div>

	<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']);?>

<?php ActiveForm::end(); ?>


<?
    $this->registerJs(
    '$(document).ready(function () {
    change_location();
    }); 
    function change_location(){ 
        var selectVal = $(\'#apartment-city_or_region\').val();
        if (selectVal == \'0\') { 
            $(\'#apartment-region_kharkiv_admin_id\').show();
            $(\'#apartment-region_kharkiv_id\').show();
            $(\'#apartment-metro_id\').show();
            $(\'#apartment-locality_id\').hide(); 
            $(\'#apartment-course_id\').hide(); 
            $(\'#apartment-region_id\').hide(); 
        } 
        else if (selectVal == \'1\'){
          	$(\'#apartment-region_kharkiv_admin_id\').hide();
            $(\'#apartment-region_kharkiv_id\').hide();
            $(\'#apartment-metro_id\').hide();
            $(\'#apartment-locality_id\').show(); 
            $(\'#apartment-course_id\').show(); 
            $(\'#apartment-region_id\').show(); 
        } 
    }

    $(\'#apartment-city_or_region\').change(change_location);'
    );
?>
