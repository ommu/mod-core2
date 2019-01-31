<?php
/**
 * Core Zone Districts (core-zone-district)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\zone\DistrictController
 * @var $model ommu\core\models\CoreZoneDistrict
 * @var $form app\components\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 15 September 2017, 10:26 WIB
 * @modified date 30 January 2019, 17:14 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
?>

<div class="core-zone-district-form">

<?php $form = ActiveForm::begin([
	'enableClientValidation' => true,
	'enableAjaxValidation' => false,
	//'enableClientScript' => true,
]); ?>

<?php //echo $form->errorSummary($model);?>

<?php $city_id = $form->field($model, 'city_id', ['template' => '{input}', 'options' => ['tag' => null]])->hiddenInput()->label(false);
echo $form->field($model, 'cityName', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12">{input}'.$city_id.'{error}</div>'])
	// ->textInput(['maxlength'=>true])
	->widget(AutoComplete::className(), [
		'options' => [
			'data-toggle' => 'tooltip', 'data-placement' => 'top',
			'class' => 'ui-autocomplete-input form-control'
		],
		'clientOptions' => [
			'source' => Url::to(['zone/city/suggest', 'extend'=>'city_name']),
			'minLength' => 2,
			'select' => new JsExpression("function(event, ui) {
				\$('.field-cityname #city_id').val(ui.item.id);
				\$('.field-cityname #cityname').val(ui.item.label);
				return false;
			}"),
		]
	])
	->label($model->getAttributeLabel('cityName'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<?php echo $form->field($model, 'district_name', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12">{input}{error}</div>'])
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('district_name'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<?php echo $form->field($model, 'mfdonline', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12">{input}{error}</div>'])
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('mfdonline'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<?php echo $form->field($model, 'checked', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12 checkbox">{input}{error}</div>'])
	->checkbox(['label'=>''])
	->label($model->getAttributeLabel('checked'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<?php echo $form->field($model, 'publish', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12 checkbox">{input}{error}</div>'])
	->checkbox(['label'=>''])
	->label($model->getAttributeLabel('publish'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<div class="ln_solid"></div>
<div class="form-group">
	<div class="col-md-6 col-sm-9 col-xs-12 col-sm-offset-3">
		<?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
	</div>
</div>

<?php ActiveForm::end(); ?>

</div>