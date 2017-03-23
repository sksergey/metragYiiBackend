<?
	use common\models\Street;
	use common\models\RegionKharkiv;
	use common\models\Metro;
	use common\models\WallMaterial;
    use common\models\Addsite;
    use common\models\Users;

    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\bootstrap\Carousel;

?>

	 	<?
    	$img = [];
    	$images = $apartment->getImages();
				foreach ($images as $image){
                        if($image){
                        $img[] = '<img src="'. $image->getPathToOrigin(). '" alt="">';
                     }
                }
				if(empty($img)){
					$img[] = '<img src="'. Url::base(true)."/images/no_image.png". '" alt="">';
				} 
    	?>
		<div class="content" style="" >	
			<?= Carousel::widget(['items'=>$img]); ?>
		</div>
		

<div class="product">
    <div class="content">
	 	

    	<div class="prod-desc">
		  	<span><?= Yii::t('app', 'Characteristics') ?>:</span>
		   	<table>
				<tbody>
					<tr>
			  			<td class="options"><?= Yii::t('app', 'Price') ?>:</td>
			  			<td><?= $apartment['price'] ?></td>
			 		</tr>
			 		<tr>
			  			<td class="options">ID:</td>
			  			<td><?= $apartment['id'] ?></td>
			 		</tr>
             		<tr>
			  			<td class="options"><?= Yii::t('app', 'Phone') ?>:</td>
			  			<td><?= Users::findOne(Addsite::findOne(['idbase' => $apartment['id']])->user)->phone ?></td>
			 		</tr>
	 				<tr>
				  		<td class="options"><?= Yii::t('app', 'Region Kharkiv') ?>:</td>
				  		<td><?= RegionKharkiv::findOne($apartment['region_kharkiv_id'])->name ?></td>
				 	</tr>
				 	<tr>
				  		<td class="options"><?= Yii::t('app', 'Street') ?>:</td>
				  		<td><?= Street::findOne($apartment['street_id'])->name ?></td>
				 	</tr>
				  	<tr>
	 			  		<td class="options"><?= Yii::t('app', 'Metro') ?>:</td>
	    		  		<td><?= Metro::findOne($apartment['metro_id'])->name ?></td>
	    		  	</tr>
	    		  	<tr>
				  		<td class="options"><?= Yii::t('app', 'Count Room') ?>:</td>
				  		<td><?= $apartment['count_room'] ?></td>
				 	</tr>
	             	<tr>
				  		<td class="options"><?= Yii::t('app', 'Floor') ?> / <?= Yii::t('app', 'Floor All') ?>:</td>
				  		<td><?= $apartment['floor'] ?> / <?= $apartment['floor_all'] ?></td>
				 	</tr>
	             	<tr>
				  		<td class="options"><?= Yii::t('app', 'Area (total/floor/kitchen)') ?>:</td>
				  		<td><?= $apartment['total_area'] ?> / <?= $apartment['floor_area'] ?> / <?= $apartment['kitchen_area'] ?></td>
				 	</tr>
					<tr>
				  		<td class="options"><?= Yii::t('app', 'Wall Material') ?>:</td>
				  	  	<td><?= WallMaterial::findOne($apartment['wall_material_id'])->name ?></td>
                    </tr>
					<tr>
				  		<td class="options"><?= Yii::t('app', 'Count Balcony') ?>:</td>
				  		<td><?= $apartment['count_balcony'] ?></td>
				 	</tr>

				 <!-- if ($type_realty_id==3)
				 
				 	<tr>
				 						<td class="options">Cрок сдачи:</td>
				 						<td> ??? </td>
				 					</tr>
				 					<tr>
				  		<td class="options">Район:</td>
				  		<td>".$district."</td>
				 	</tr>
				 	<tr>
				  		<td class="options">Улица:</td>
				  		<td>".$street."</td>
				 	</tr>
				 	    		  	<tr>
				 	 			  		<td class="options">Метро:</td>
				 	    		  		<td>".$metro_name->row['name']."</td>
				 	    		  	</tr>
				 	    		  	<tr>
				  		<td class="options">Комнат:</td>
				  		<td>".$data->row['count_room']."</td>
				 	</tr>
				 	             	<tr>
				  		<td class="options">Этажность:</td>
				  		<td>".$data->row['floor_all']."</td>
				 	</tr>
				 	             	<tr>
				  		<td class="options">Площадь дома:</td>
				  		<td>".round($data->row['total_area_house'])."</td>
				 	</tr>
				 	<tr>
				  		<td class="options">Площадь участка:</td>
				  		<td>".round($data->row['total_area'])."</td>
				 	</tr>
				                  	<tr>
				  		<td class="options">Год постройки:</td>
				  		<td>".round($data->row['building_year'])."</td>
				 	</tr> -->
			 
			 <!-- if ($type_realty_id==5)
			 
			 				 	<tr>
			 				  		<td class="options">Район:</td>
			 				  		<td>".$district."</td>
			 				 	</tr>
			 				 	<tr>
			 				  		<td class="options">Улица:</td>
			 				  		<td>".$street."</td>
			 				 	</tr>
			 	             	<tr>
			 				  		<td class="options">Площадь участка:</td>
			 				  		<td>".round($data->row['total_area'])."</td>
			 				 	</tr>
			 				 	<tr>
			 				  		<td class="options">Наличие дома под снос:</td>
			 				  		<td>'house_demolition' ? "да" : "нет
			 				  	</td>
			 				 	</tr>
			                  	<tr>
			 				  		<td class="options">Наличие гос. акта:</td>
			 				  		<td>['state_act'] ? "да" : "нет</td>
			 				 	</tr> -->
			    </tbody>
          	</table>
        	<span><?= Yii::t('app', 'Description') ?>:</span>
        	<p><?= $apartment['notesite'] ?></p>
		</div>
	</div>
</div>


	<!-- <script src="<?php echo TEMPLATE ?>js/jquery.fs.selecter.min.js"></script>
	<script type="text/javascript" src="<?php echo TEMPLATE ?>js/tabs.js"></script>
	<script>
	 $(document).ready(function() {
	        $('select').selecter();
	    });
	$('#thumbs').delegate('img','click', function(){
		$('#largeImage').attr('src',$(this).attr('src').replace('thumb','large'));
		$('#description').html($(this).attr('alt'));
	});
	
	
	</script> -->
	
