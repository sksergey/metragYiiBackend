<?php
 use frontend\controllers\SiteController;
 use yii\widgets\LinkPager;
 use yii\helpers\Url;
?>
<? $this->title = Yii::t('app', 'Apartment'); ?>
<div class="filter-2">
	<div class="content">
		<div class="type-list">
			<ul>
				<li><span>Вид списка:</span></li>
				<li><a href="" title=""><img src="<?= Url::base(true);?>/images/grid.png" id="grid" alt=""></a></li>
				<li><a href="" title=""><img src="<?= Url::base(true);?>/images/list.png" id="list" alt=""></a></li>
			</ul>
		</div>
<!-- 
		<div class="currency">
			<span class="currency-text">Валюта:</span>
				<form action="" >
					<div id="radios">
				    	<input id="option1" name="options" type="radio">
				    		<label for="option1">UAH </label>
							<input id="option2" name="options" type="radio">
				    		<label for="option2">USD</label>
							<input id="option3" name="options" type="radio" checked>
				    		<label for="option3">EUR</label>
				    </div>
				</form>
		</div>
 -->
 	</div>
</div>
<div class="catalog grid">
	<div class="content">
<? foreach ($apartments as $apartment) { ?>

	
		<div class="item-catalog">
        	<div class="item-catalog-text">
        		  <?=  $apartment::getLocalitystring($apartment); ?>
        	</div>
            <div class="item-catalog-img">
                <img src="<? $image = $apartment->getImage();
				                	if($image){
				                		//echo $image->getPath('400x300');
				                		echo $image->getPathToOrigin();
				                	}
				                	else
				                		echo Url::base(true)."/images/2.png"; ?>" alt="">
				                
                    <div class="caption">
				    <div class="blur"></div>
					    <a href="apartment-detail?id=<?= $apartment['id']?>">
					    	<div class="caption-text">
					    		<img src="<?= Url::base(true);?>/images/house.png" alt="">

					    	</div>
					    </a>
				    </div>
			</div>
			<div class="item-catalog-text">
                <span class="square">
                	<span><img src="images/square.png" alt=""></span>
                	<?= $apartment['count_room'] ?> ком., <?= $apartment['total_area'] ?> м<sup>2</sup>
                </span>
				<span class="price"> $<?= $apartment['price'] ?></span>
			</div>
		</div>
    


<!-- <div class="catalog list" style="display: none;">
	<div class="content">
        <div class="row">
        	<div class="item-catalog-list">
        		<div class="item-catalog-text">
        		    <p><?= $apartment['id'] ?></p>
				</div>
				<div class="item-catalog-img">
					<img src="<? $image = $apartment->getImage();
				                	if($image){
				                		//echo $image->getPath('400x300');
				                	}
				                	else
				                		echo "images/2.png"; ?>" alt="">
					<div class="caption">
					   	<div class="blur"></div>
					   	<a href="path-to-apartment-id">
						    <div class="caption-text">
								<img src="images/house.png" alt="">
		                    </div>
		                </a>
					</div>
				</div>
		        <div class="item-catalog-text">
		            <span class="square">
		            	<span>
			            	<img src="images/square.png" alt="">
			            </span><?= $apartment['count_room'] ?> ком., <?= $apartment['total_area'] ?> м<sup>2</sup>
			        </span>
					<span class="price">$<?= $apartment['price'] ?></span>
				</div>
			</div>
			<div class="desc-catalog-list">
				<span class="price-list">$ <span><?= $apartment['price'] ?></span></span>
				<span class="square-list">ID - <?= $apartment['id'] ?></span>
				<span class="name-catalog-list">Тип квартиры : <?= $apartment::getTypeObject($apartment); ?></span>
  				<span class="name-catalog-list">Район : <?= $apartment::getRegionKharkiv($apartment); ?></span>
  				<span class="name-catalog-list">Комнат : <?= $apartment['count_room']?></span>
  				<span class="name-catalog-list">Этаж : <?= $apartment['floor']?></span>
  				<span class="name-catalog-list">Этажность : <?= $apartment['floor_all']?></span>
				<p class="text-catalog-list"><?= $apartment['notesite'] ?></p>
				<a href="path-to-apartment-id" class="link-catalog-list"><?= Yii::t('app', 'More...')?></a>
			</div>
		</div>
	</div>
</div> -->
 <? } ?>
	</div>
</div>

<? echo LinkPager::widget([
    'pagination' => $pages,

]);?>
<!-- <?php
 if ($total>1)
 {
  echo "<div class=\"pagination\">";
   echo "<div class=\"content\">";
    echo "<div id=\"pag-link\">";
     $pos = strpos($_SERVER['QUERY_STRING'], "&p=");
     if ($pos>0) $texturl = substr($_SERVER['QUERY_STRING'], 0, $pos);
     else $texturl=$_SERVER['QUERY_STRING'];
     $pagenameto="index.php?".$texturl;
	  if ($total<10)
	  {
	     $qq=0;
	     for ($i=1;$i<=$total;$i++)
	     {
	     	if ($page==$qq) echo "<span class=\"pag-link\"><a class=\"pag-link-active\" href=\"".$pagenameto."&p=".$qq."\">".$i."</a></span>";
     		else echo "<span class=\"pag-link\"><a href=\"".$pagenameto."&p=".$qq."\">".$i."</a></span>";
	     	$qq=$qq+$count_view_poz;
	     }
      }
      else
      {
      	$active_page=$page/$count_view_poz;
      	$last_page=$total*$count_view_poz-$count_view_poz;
      	$page_v_konze=$total-5;

      	if ($active_page<5)
      	{
      		 $qq=0;
		     for ($i=1;$i<=$active_page+5;$i++)
		     {
		     	if ($page==$qq) echo "<span class=\"pag-link\"><a class=\"pag-link-active\" href=\"".$pagenameto."&p=".$qq."\">".$i."</a></span>";
     			else echo "<span class=\"pag-link\"><a href=\"".$pagenameto."&p=".$qq."\">".$i."</a></span>";
		     	$qq=$qq+$count_view_poz;
		     }
		     echo "<span class=\"pag-link pag-link-dot\">...</span>";
		     echo "<span class=\"pag-link\"><a href=\"".$pagenameto."&p=".$last_page."\">".$total."</a></span>";
      	}
      	elseif ($active_page>=$page_v_konze)
      	{
      		 echo "<span class=\"pag-link\"><a href=\"".$pagenameto."&p=0\">1</a></span>";
      		 echo "<span class=\"pag-link pag-link-dot\">...</span>";
      		 $qq=$page_v_konze*$count_view_poz-$count_view_poz;
		     for ($i=$page_v_konze;$i<=$total;$i++)
		     {
		     	if ($page==$qq) echo "<span class=\"pag-link\"><a class=\"pag-link-active\" href=\"".$pagenameto."&p=".$qq."\">".$i."</a></span>";
		     	else echo "<span class=\"pag-link\"><a href=\"".$pagenameto."&p=".$qq."\">".$i."</a></span>";
		     	$qq=$qq+$count_view_poz;
		     }
      	}
      	else
      	{
      		echo "<span class=\"pag-link\"><a href=\"".$pagenameto."&p=0\">1</a></span>";
      		echo "<span class=\"pag-link pag-link-dot\">...</span>";
      		$qq=($active_page-3)*$count_view_poz-$count_view_poz;
      		for ($i=$active_page-3;$i<=$active_page+5;$i++)
		     {
		     	if ($page==$qq) echo "<span class=\"pag-link\"><a class=\"pag-link-active\" href=\"".$pagenameto."&p=".$qq."\">".$i."</a></span>";
		     	else echo "<span class=\"pag-link\"><a href=\"".$pagenameto."&p=".$qq."\">".$i."</a></span>";
		     	$qq=$qq+$count_view_poz;
		     }
      		echo "<span class=\"pag-link pag-link-dot\">...</span>";
  	        echo "<span class=\"pag-link\"><a href=\"".$pagenameto."&p=".$last_page."\">".$total."</a></span>";
      	}
      }
    echo "</div>";
   echo "</div>";
  echo "</div>";
 }



//include ("footer.php");
?> -->
	<script>
    $(document).ready(function() {
        $('select').selecter();
    });

    </script>
