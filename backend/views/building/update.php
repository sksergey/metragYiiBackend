<?php
//use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

use common\models\Building;
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
use app\models\Addsite;
use app\models\Developer;


use kartik\file\FileInput;
use yii\helpers\Url;
?>

<?php $form = ActiveForm::begin([
          'method' => 'post',
          'action' => ['building/add'],
          //'options' => ['class' => 'form-inline'],
          'options' => ['enctype' => 'multipart/form-data'],
      ]); ?>


	<div class="col-xs-12 col-sm-3 col-md-3 ">

		<?= $form->field($model,'id')->textInput(['readonly' => 'true'])->label('ID'); ?>
		<?= $form->field($model, 'type_object_id')->dropdownList(
    		TypeObject::find()->select(['name', 'type_object_id'])->where(['type_realty_id'=>'3'])->indexBy('type_object_id')->column())->label('Тип объекта'); ?>
		<?= $form->field($model,'count_room')->textInput()->label('Кол. комнат'); ?>
		<?= $form->field($model, 'layout_id')->dropdownList(
    		Layout::find()->select(['name', 'layout_id'])->orderby('name')->indexBy('layout_id')->column(),['prompt'=>'Выберите тип...'])->label('Тип планировки'); ?>
    	<?= $form->field($model,'floor')->textInput()->label('Этаж'); ?>
		<?= $form->field($model,'floor_all')->textInput()->label('Этажность'); ?>
        
        <? if($model->id == null) $model->city_or_region = 0; ?>
		<?= $form->field($model,'city_or_region',['inline' => true, 'template' => '{input}'])->radiolist(['0' => Yii::t('app', 'Kharkiv'), '1' => Yii::t('app', 'Region')])->label(false); ?>

		<?= $form->field($model, 'region_kharkiv_admin_id')->dropdownList(RegionKharkivAdmin::find()->select(['name', 'region_kharkiv_admin_id'])->orderby('name')->indexBy('region_kharkiv_admin_id')->column(),['prompt'=>'Выберите район...'])->label('РайонАдмин/Харьков'); ?>
		<?= $form->field($model, 'region_kharkiv_id')->dropdownList(
    		RegionKharkiv::find()->select(['name', 'region_kharkiv_id'])->orderby('name')->indexBy('region_kharkiv_id')->column(),['prompt'=>'Выберите район...'])->label('Район/Харьков'); ?>
		<?= $form->field($model, 'metro_id')->dropdownList(
    		Metro::find()->select(['name', 'metro_id'])->orderby('name')->indexBy('metro_id')->column(),['prompt'=>'Выберите станцию метро...'])->label('Метро'); ?>
		
		<?= $form->field($model, 'locality_id')->dropdownList(
			Locality::find()->select(['name', 'locality_id'])->orderby('name')->indexBy('locality_id')->column(),['prompt'=>'Выберите населенный пункт...'])->label('Населенный пункт'); ?>
		<?= $form->field($model, 'course_id')->dropdownList(
    		Course::find()->select(['name', 'course_id'])->orderby('name')->indexBy('course_id')->column(),['prompt'=>'Выберите направление...'])->label('Направление'); ?>
		<?= $form->field($model, 'region_id')->dropdownList(Region::find()->select(['name', 'region_id'])->orderby('name')->indexBy('region_id')->column(),['prompt'=>'Выберите район...'])->label('Район/Область'); ?>
    	
		<?= $form->field($model, 'street_id')->dropdownList(
    		Street::find()->select(['name', 'street_id'])->orderby('name')->indexBy('street_id')->column(),['prompt'=>'Выберите улицу...'])->label('Улица'); ?>
		<?= $form->field($model,'number_building')->textInput()->label('Номер дома'); ?>
		<?= $form->field($model,'corps')->textInput()->label('Корпус'); ?>
		<?= $form->field($model,'number_apartment')->textInput()->label('Номер квартиры'); ?>
	</div>
	<div class="col-xs-12 col-sm-3 col-md-3 ">
		<?= $form->field($model,'price')->textInput()->label('Цена'); ?>
		<?= $form->field($model, 'exclusive_user_id')->dropdownList(
    		Users::find()->select(['name', 'id'])->orderby('name')->indexBy('id')->column(),['prompt'=>'Выберите пользователя...'])->label('Экслюзив'); ?>
    	<?= $form->field($model, 'mediator_id')->dropdownList(
    		Mediator::find()->select(['name', 'mediator_id'])->orderby('name')->indexBy('mediator_id')->column(),['prompt'=>'Выберите посредника...'])->label('Посредник'); ?>
		<?= $form->field($model,'landmark')->textInput()->label('Ориентир'); ?>
		<?= $form->field($model,'comment')->textInput()->label('Причина удаления/восстановления'); ?>
		<?= $form->field($model,'exchange')->checkbox()->label('Обмен'); ?>
		<?= $form->field($model,'exchange_formula')->textInput()->label('Формула обмена'); ?>
		<?= $form->field($model, 'condit_id')->dropdownList(
    		Condit::find()->select(['name', 'condit_id'])->orderby('name')->indexBy('condit_id')->column(),['prompt'=>'Выберите состояние...'])->label('Состояние'); ?>
		<?= $form->field($model, 'source_info_id')->dropdownList(
    		SourceInfo::find()->select(['name', 'source_info_id'])->orderby('name')->indexBy('source_info_id')->column(),['prompt'=>'Выберите источник...'])->label('Источник информации'); ?>
		<?= $form->field($model, 'wc_id')->dropdownList(
    		Wc::find()->select(['name', 'wc_id'])->orderby('name')->indexBy('wc_id')->column(),['prompt'=>'Выберите тип сан.узла...'])->label('Сан. узел'); ?>
		<?= $form->field($model, 'wall_material_id')->dropdownList(
    		WallMaterial::find()->select(['name', 'wall_material_id'])->orderby('name')->indexBy('wall_material_id')->column(),['prompt'=>'Выберите материал стен...'])->label('Стены'); ?>
    	<?= $form->field($model,'date_added')->textInput(['readonly' => 'true'])->label('Дата добавления'); ?>
		<?= $form->field($model,'date_modified')->textInput(['readonly' => 'true'])->label('Дата изменения'); ?>
	</div>
	<div class="col-xs-12 col-sm-3 col-md-3 ">
        <?= $form->field($model,'price_square_meter')->textInput()->label('Цена за кв. м.'); ?>
		<?= $form->field($model,'total_area')->textInput()->label('Площадь общая'); ?>
		<?= $form->field($model,'floor_area')->textInput()->label('Площадь жилая'); ?>
		<?= $form->field($model,'kitchen_area')->textInput()->label('Площадь кухни'); ?>
        <?= $form->field($model, 'developer_id')->dropdownList(
            Developer::find()->select(['name', 'developer_id'])->orderby('name')->indexBy('developer_id')->column(),['prompt'=>'Выберите застройщика...'])->label('Застройщик'); ?>
		<?= $form->field($model,'phone_line')->checkbox()->label('Телефонная линия'); ?>
		<? if($model->id == null) $model->bath = 1;?>
        <?= $form->field($model,'bath')->checkbox()->label('Ванна'); ?>
		<?= $form->field($model,'count_balcony')->textInput()->label('Количество балконов'); ?>
		<?= $form->field($model,'count_balcony_glazed')->textInput()->label('Застекленных балконов'); ?>
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
        <?//= $form->field($model, 'phone')->listBox(Apartment::getPhonesArr($model->phone))->label('Телефоны'); ?>
        <?= Html::button(Yii::t('app', 'Add'), ['id' => 'add_phone']) ?>
        <?= Html::button(Yii::t('app', 'Edit'), ['id' => 'edit_phone']) ?>
        <?= Html::button(Yii::t('app', 'Delete'), ['id' => 'delete_phone']) ?>
       	
        <div id="div_phone" style="display: none;">
        <input type="text" id="input_phone" class="span12" />
        
        <?= Html::button(Yii::t('app', 'OK'), ['id' => 'ok_phone']) ?>
        <?= Html::button(Yii::t('app', 'Cancel'), ['id' => 'cancel_phone']) ?>
        
        </div>
        <select size="5" class="span12" id="select_phone" style="width: 100%">
                                        <?php
                                        $phones = explode(",", $model['phone']);
										?>
                                        <?php foreach($phones as $phone) { ?>
                                            <?php if($phone) { ?>
                                                <option><?php echo $phone; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
        <?= $form->field($model,'phone')->hiddenInput(); ?>                              
        <? $model->enabled = 1; ?>
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
    <?= Html::resetButton('Сбросить', ['class' => 'btn btn-default']) ?>
    <?
        if($model->id != '')
        {
            if(Addsite::findOne(['idbase' => $model->id]))
            {
                echo Html::button(Yii::t('app', 'Delete from site'), ['id' => 'del_from_site','class' => 'btn btn-danger']);
                echo Html::button(Yii::t('app', 'Add site'), ['id' => 'add_site','class' => 'btn btn-primary','style' => 'display: none;']);
            }
            else
            {
                echo Html::button(Yii::t('app', 'Delete from site'), ['id' => 'del_from_site','class' => 'btn btn-danger','style' => 'display: none;']);
                echo Html::button(Yii::t('app', 'Add site'), ['id' => 'add_site','class' => 'btn btn-primary']);
            }
        }
    ?>
    
<?php ActiveForm::end(); ?>


<? $this->registerJs('
    $(document).ready(function () {
        change_location();
        }); 
        function change_location(){
            var selectVal = $("input[name=\'Building[city_or_region]\']:checked").val();
            if (selectVal == \'1\') { 
                $("select[name=\'Building[locality_id]\']").removeAttr("disabled");
                $("select[name=\'Building[course_id]\']").removeAttr("disabled");
                $("select[name=\'Building[region_id]\']").removeAttr("disabled");
                $("select[name=\'Building[region_kharkiv_admin_id]\']").attr("disabled", true).find("[value=\'0\']").attr("selected", "selected");
                $("select[name=\'Building[region_kharkiv_id]\']").attr("disabled", true).find("[value=\'0\']").attr("selected", "selected");
                $("select[name=\'Building[metro_id]\']").attr("disabled", true).find("[value=\'0\']").attr("selected", "selected");
            } else {
                $("select[name=\'Building[region_kharkiv_admin_id]\']").removeAttr("disabled");
                $("select[name=\'Building[region_kharkiv_id]\']").removeAttr("disabled");
                $("select[name=\'Building[metro_id]\']").removeAttr("disabled");
                $("select[name=\'Building[locality_id]\']").attr("disabled", true).find("[value=\'0\']").attr("selected", "selected");
                $("select[name=\'Building[course_id]\']").attr("disabled", true).find("[value=\'0\']").attr("selected", "selected");
                $("select[name=\'Building[region_id]\']").attr("disabled", true).find("[value=\'0\']").attr("selected", "selected");
            }
        }

        $(\'#building-city_or_region\').change(change_location);
        ');

?>

<?
 $this->registerJs('
	    var add_phone_tmp;

    $("#input_phone").keyup(function(){
        $(this).val($(this).val().replace(/[^0-9]/gim,\'\'));
    });

    $("#cancel_phone").click(function(e){
        e.preventDefault();
        $("#input_phone").val("");
        $("#div_phone").css("display", "none");
    });

    $("#add_phone").click(function(e){
        e.preventDefault();
        $("#input_phone").val("");
        $("#div_phone").css("display", "block");
        add_phone_tmp = true;
    });

    $("#edit_phone").click(function(e){
        e.preventDefault();
        if($("#select_phone :selected").length) {
            $("#input_phone").val($("#select_phone :selected").val());
            $("#div_phone").css("display", "block");
            add_phone_tmp = false;
        } else {
            alert("Вы не выбрали номер телефона для редактирования.");
        }
    });

    $("#delete_phone").click(function(e){
        e.preventDefault();
        if($("#select_phone :selected").length) {
            if(confirm("Вы уверены что хотите удалить?")) {
                $("#select_phone :selected").remove();
                save_phone();
            }
        } else {
            alert("Вы не выбрали номер телефона для удаленя.");
        }
    });

    $("#ok_phone").click(function(e){
        e.preventDefault();
        if($("#input_phone").val()) {
            if(add_phone_tmp) {
                $("#select_phone").append($(\'<option>\' + $("#input_phone").val() + \'</option>\'));
            } else {
                $("#select_phone :selected").text($("#input_phone").val());
            }
            save_phone();
        } else {
            alert("Вы не ввели номер телефона.");
        }
        $("#input_phone").val("");
        $("#div_phone").css("display", "none");
    });

    function save_phone() {
        var phone = [];
        $(\'#select_phone option\').each(function(){
            phone.push($(this).text());
        });
        $("input[name=\'Building[phone]\']").val(phone.join(","));
    }
 	')
?>

<script>
        window.onload = function () {
                var add = document.getElementById("add_site");
                if(add)
                {
                    add.onclick = addSite;
                }
                var del = document.getElementById("del_from_site");
                if(del)
                {
                    del.onclick = delSite;  
                }
            };

            function addSite(){
                if(confirm("Add site?"))
                {
                    var id = document.getElementById("building-id");
                    var xrequest = new XMLHttpRequest();    
              xrequest.open("GET", "/admin/addsite/add?id="+id.value+"&base=building", true);
              xrequest.send(); 

                    xrequest.onload = function() {
                    alert(this.responseText);
                    var add = document.getElementById("add_site");
                    add.style.display = "none";
                    var del = document.getElementById("del_from_site"); 
                    del.style.display = ""; 
                };
                }
                
            };

            function delSite(){
                if(confirm("Delete from site?"))
                {
                    var id = document.getElementById("building-id");
                    var xrequest = new XMLHttpRequest();    
              xrequest.open("GET", "/admin/addsite/del?id="+id.value, true);
              xrequest.send(); 

                    xrequest.onload = function() {
                    alert(this.responseText);
                    var add = document.getElementById("add_site");
                    add.style.display = "";
                    var del = document.getElementById("del_from_site"); 
                    del.style.display = "none"; 
                };
                }
                
            };
 </script>


