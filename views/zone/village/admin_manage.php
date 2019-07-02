<?php
/**
 * Core Zone Villages (core-zone-village)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\zone\VillageController
 * @var $model ommu\core\models\CoreZoneVillage
 * @var $searchModel ommu\core\models\search\CoreZoneVillage
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 16 September 2017, 17:35 WIB
 * @modified date 30 January 2019, 17:15 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\DetailView;
use ommu\core\models\CoreZoneCountry;
use ommu\core\models\CoreZoneProvince;
use ommu\core\models\CoreZoneCity;
use ommu\core\models\CoreZoneDistrict;

$this->params['breadcrumbs'][] = $this->title;

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Add Village'), 'url' => Url::to(['create']), 'icon' => 'plus-square', 'htmlOptions' => ['class'=>'btn btn-success']],
];
$this->params['menu']['option'] = [
	//['label' => Yii::t('app', 'Search'), 'url' => 'javascript:void(0);'],
	['label' => Yii::t('app', 'Grid Option'), 'url' => 'javascript:void(0);'],
];
?>

<div class="core-zone-village-manage">
<?php Pjax::begin(); ?>

<?php if($country != null) {
$model = $country;
echo DetailView::widget([
	'model' => $model,
	'options' => [
		'class'=>'table table-striped detail-view',
	],
	'attributes' => [
		[
			'attribute' => 'country_name',
			'value' => function ($model) {
				return Html::a($model->country_name, ['zone/country/view', 'id'=>$model->country_id], ['title'=>$model->country_name, 'class'=>'modal-btn']);
			},
			'format' => 'html',
		],
		'code',
	],
]);
}?>

<?php if($province != null) {
$model = $province;
echo DetailView::widget([
	'model' => $model,
	'options' => [
		'class'=>'table table-striped detail-view',
	],
	'attributes' => [
		[
			'attribute' => 'province_name',
			'value' => function ($model) {
				return Html::a($model->province_name, ['zone/province/view', 'id'=>$model->province_id], ['title'=>$model->province_name, 'class'=>'modal-btn']);
			},
			'format' => 'html',
		],
		[
			'attribute' => 'countryName',
			'value' => function ($model) {
				$countryName = isset($model->country) ? $model->country->country_name : '-';
				if($countryName != '-')
					return Html::a($countryName, ['zone/country/view', 'id'=>$model->country_id], ['title'=>$countryName, 'class'=>'modal-btn']);
				return $countryName;
			},
			'format' => 'html',
		],
		'mfdonline',
	],
]);
}?>

<?php if($city != null) {
$model = $city;
echo DetailView::widget([
	'model' => $model,
	'options' => [
		'class'=>'table table-striped detail-view',
	],
	'attributes' => [
		[
			'attribute' => 'city_name',
			'value' => function ($model) {
				return Html::a($model->city_name, ['zone/city/view', 'id'=>$model->city_id], ['title'=>$model->city_name, 'class'=>'modal-btn']);
			},
			'format' => 'html',
		],
		[
			'attribute' => 'provinceName',
			'value' => function ($model) {
				$provinceName = isset($model->province) ? $model->province->province_name : '-';
				if($provinceName != '-')
					return Html::a($provinceName, ['zone/province/view', 'id'=>$model->province_id], ['title'=>$provinceName, 'class'=>'modal-btn']);
				return $provinceName;
			},
			'format' => 'html',
		],
		[
			'attribute' => 'countryName',
			'value' => function ($model) {
				$countryName = isset($model->province->country) ? $model->province->country->country_name : '-';
				if($countryName != '-')
					return Html::a($countryName, ['zone/country/view', 'id'=>$model->province->country_id], ['title'=>$countryName, 'class'=>'modal-btn']);
				return $countryName;
			},
			'format' => 'html',
		],
		'mfdonline',
	],
]);
}?>

<?php if($district != null) {
$model = $district;
echo DetailView::widget([
	'model' => $model,
	'options' => [
		'class'=>'table table-striped detail-view',
	],
	'attributes' => [
		[
			'attribute' => 'district_name',
			'value' => function ($model) {
				return Html::a($model->district_name, ['zone/district/view', 'id'=>$model->district_id], ['title'=>$model->district_name, 'class'=>'modal-btn']);
			},
			'format' => 'html',
		],
		[
			'attribute' => 'cityName',
			'value' => function ($model) {
				$cityName = isset($model->city) ? $model->city->city_name : '-';
				if($cityName != '-')
					return Html::a($cityName, ['zone/city/view', 'id'=>$model->city_id], ['title'=>$cityName, 'class'=>'modal-btn']);
				return $cityName;
			},
			'format' => 'html',
		],
		[
			'attribute' => 'provinceName',
			'value' => function ($model) {
				$provinceName = isset($model->city->province) ? $model->city->province->province_name : '-';
				if($provinceName != '-')
					return Html::a($provinceName, ['zone/province/view', 'id'=>$model->city->province_id], ['title'=>$provinceName, 'class'=>'modal-btn']);
				return $provinceName;
			},
			'format' => 'html',
		],
		[
			'attribute' => 'countryName',
			'value' => function ($model) {
				$countryName = isset($model->city->province->country) ? $model->city->province->country->country_name : '-';
				if($countryName != '-')
					return Html::a($countryName, ['zone/country/view', 'id'=>$model->city->province->country_id], ['title'=>$countryName, 'class'=>'modal-btn']);
				return $countryName;
			},
			'format' => 'html',
		],
		'mfdonline',
	],
]);
}?>

<?php //echo $this->render('_search', ['model'=>$searchModel]); ?>

<?php echo $this->render('_option_form', ['model'=>$searchModel, 'gridColumns'=>$searchModel->activeDefaultColumns($columns), 'route'=>$this->context->route]); ?>

<?php
$columnData = $columns;
array_push($columnData, [
	'class' => 'app\components\grid\ActionColumn',
	'header' => Yii::t('app', 'Option'),
	'urlCreator' => function($action, $model, $key, $index) {
		if($action == 'view')
			return Url::to(['view', 'id'=>$key]);
		if($action == 'update')
			return Url::to(['update', 'id'=>$key]);
		if($action == 'delete')
			return Url::to(['delete', 'id'=>$key]);
	},
	'buttons' => [
		'view' => function ($url, $model, $key) {
			return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => Yii::t('app', 'Detail')]);
		},
		'update' => function ($url, $model, $key) {
			return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => Yii::t('app', 'Update')]);
		},
		'delete' => function ($url, $model, $key) {
			return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
				'title' => Yii::t('app', 'Delete'),
				'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
				'data-method'  => 'post',
			]);
		},
	],
	'template' => '{view} {update} {delete}',
]);

echo GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'columns' => $columnData,
]); ?>

<?php Pjax::end(); ?>
</div>