<?
	use yii\helpers\Url;
	use yii\helpers\Html;

	use yii\data\ActiveDataProvider;
	use yii\grid\GridView;

	use app\models\RegionKharkivAdmin;
	use app\models\Layout;
	use app\models\TypeObject;
	use app\models\Users;
?>

<?
	echo GridView::widget([
	    'dataProvider' => $dataProvider,
	    'columns' => [
	        ['class' => 'yii\grid\SerialColumn'],
	        [
	        	'class' => 'yii\grid\ActionColumn',
	        	'controller' => 'apartment'
	        	/*'attribute' => 'Action',
	        	'value' => function($dataProvider){
	        		//return Url::to(['agency/apartmentedit', 'id' => $dataProvider->id]);
	        		return Html::a('Редактировать', ['agency/apartmentedit', 'id' => $dataProvider->id], ['class' => 'profile-link']);
	        	}*/
	        ],
	        'id',
	       	[
	        	'attribute' => 'type_object_id',
	        	'value' =>  function ($dataProvider) {
	        		return TypeObject::findOne($dataProvider->type_object_id)->name;
	        	}
	        ],
	        [
	        	'attribute' => 'region_kharkiv_admin_id',
	        	'value' =>  function ($dataProvider) {
	        		return RegionKharkivAdmin::findOne($dataProvider->region_kharkiv_admin_id)->name;
                }
	        ],
	        'count_room',
	        [
	        	'attribute' => 'layout_id',
	        	'value' =>  function ($dataProvider) {
	        		return Layout::findOne($dataProvider->layout_id)->name;
	        		//return $dataProvider->layout_id;
                }
	        ],
	        'floor',
	        'corps',
	        'number_apartment',
	        'note',
	        'notesite',
	        'phone',
	        'price',
			[
				'attribute' => 'update_author_id',
				'value' =>  function ($dataProvider) {
					return Users::findOne($dataProvider->update_author_id)->name;
				}
			],
	        'enabled'
	    ],
	]);
?>



