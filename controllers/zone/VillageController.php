<?php
/**
 * VillageController
 * @var $this ommu\core\controllers\zone\VillageController
 * @var $model ommu\core\models\CoreZoneVillage
 *
 * VillageController implements the CRUD actions for CoreZoneVillage model.
 * Reference start
 * TOC :
 *	Index
 *	Manage
 *	Create
 *	Update
 *	View
 *	Delete
 *	RunAction
 *	Publish
 *	Suggest
 *
 *	findModel
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.id)
 * @created date 16 September 2017, 17:35 WIB
 * @modified date 30 January 2019, 17:14 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

namespace ommu\core\controllers\zone;

use Yii;
use app\components\Controller;
use mdm\admin\components\AccessControl;
use yii\filters\VerbFilter;
use ommu\core\models\CoreZoneVillage;
use ommu\core\models\search\CoreZoneVillage as CoreZoneVillageSearch;
use ommu\core\models\view\CoreZoneVillage as CoreZoneVillageView;

class VillageController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function init()
	{
        parent::init();

        $this->subMenu = $this->module->params['zone_submenu'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
        return [
            'access' => [
                'class' => AccessControl::className(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'publish' => ['POST'],
                ],
            ],
        ];
	}

	/**
	 * {@inheritdoc}
	 */
	public function allowAction(): array {
		return ['suggest'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actionIndex()
	{
        return $this->redirect(['manage']);
	}

	/**
	 * Lists all CoreZoneVillage models.
	 * @return mixed
	 */
	public function actionManage()
	{
        $searchModel = new CoreZoneVillageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $gridColumn = Yii::$app->request->get('GridColumn', null);
        $cols = [];
        if ($gridColumn != null && count($gridColumn) > 0) {
            foreach ($gridColumn as $key => $val) {
                if ($gridColumn[$key] == 1) {
                    $cols[] = $key;
                }
            }
        }
        $columns = $searchModel->getGridColumn($cols);

        if (($country = Yii::$app->request->get('country')) != null) {
            $country = \ommu\core\models\CoreZoneCountry::findOne($country);
        }
        if (($province = Yii::$app->request->get('province')) != null) {
            $province = \ommu\core\models\CoreZoneProvince::findOne($province);
        }
        if (($city = Yii::$app->request->get('city')) != null) {
            $city = \ommu\core\models\CoreZoneCity::findOne($city);
        }
        if (($district = Yii::$app->request->get('district')) != null) {
            $district = \ommu\core\models\CoreZoneDistrict::findOne($district);
        }

		$this->view->title = Yii::t('app', 'Villages');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_manage', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'columns' => $columns,
			'country' => $country,
			'province' => $province,
			'city' => $city,
			'district' => $district,
		]);
	}

	/**
	 * Creates a new CoreZoneVillage model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
        $model = new CoreZoneVillage();
        if (($id = Yii::$app->request->get('id')) != null) {
            $model->district_id = $id;
        }

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            // $postData = Yii::$app->request->post();
            // $model->load($postData);
            // $model->order = $postData['order'] ? $postData['order'] : 0;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Village success created.'));
                if (!Yii::$app->request->isAjax) {
                    if ($id != null) {
						return $this->redirect(['manage', 'district' => $model->district_id]);
                    }
					return $this->redirect(['manage']);
				}
                if ($id != null) {
					return $this->redirect(Yii::$app->request->referrer ?: ['manage', 'district' => $model->district_id]);
                }
                return $this->redirect(Yii::$app->request->referrer ?: ['manage']);

            } else {
                if (Yii::$app->request->isAjax) {
                    return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
                }
            }
        }

		$this->view->title = Yii::t('app', 'Create Village');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->oRender('admin_create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing CoreZoneVillage model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            // $postData = Yii::$app->request->post();
            // $model->load($postData);
            // $model->order = $postData['order'] ? $postData['order'] : 0;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Village success updated.'));
                if (!Yii::$app->request->isAjax) {
					return $this->redirect(['update', 'id' => $model->village_id]);
                }
                if (($district = Yii::$app->request->get('district')) != null) {
					return $this->redirect(Yii::$app->request->referrer ?: ['manage', 'district' => $district]);
                }
                return $this->redirect(Yii::$app->request->referrer ?: ['manage']);

            } else {
                if (Yii::$app->request->isAjax) {
                    return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
                }
            }
        }

		$this->view->title = Yii::t('app', 'Update Village: {village-name}', ['village-name' => $model->village_name]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->oRender('admin_update', [
			'model' => $model,
		]);
	}

	/**
	 * Displays a single CoreZoneVillage model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
        $model = $this->findModel($id);

		$this->view->title = Yii::t('app', 'Detail Village: {village-name}', ['village-name' => $model->village_name]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->oRender('admin_view', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing CoreZoneVillage model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$model->publish = 2;

        if ($model->save(false, ['publish', 'modified_id'])) {
			Yii::$app->session->setFlash('success', Yii::t('app', 'Village success deleted.'));
			return $this->redirect(Yii::$app->request->referrer ?: ['manage']);
		}
	}

	/**
	 * actionPublish an existing CoreZoneVillage model.
	 * If publish is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionPublish($id)
	{
		$model = $this->findModel($id);
		$replace = $model->publish == 1 ? 0 : 1;
		$model->publish = $replace;

        if ($model->save(false, ['publish', 'modified_id'])) {
			Yii::$app->session->setFlash('success', Yii::t('app', 'Village success updated.'));
			return $this->redirect(Yii::$app->request->referrer ?: ['manage']);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function actionSuggest()
	{
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		$term = Yii::$app->request->get('term', null);
		$districtId = Yii::$app->request->get('did', null);
		$extend = Yii::$app->request->get('extend', null);

		$model = CoreZoneVillage::find()
            ->alias('t')
			->suggest();
        if ($term != null) {
            $model->andWhere(['like', 't.village_name', $term]);
        }
        if ($districtId != null) {
            $model->andWhere(['t.district_id' => $districtId]);
        }
		$model = $model->limit(30)->orderBy('t.village_name asc')->all();
			
		$result = [];
		$i = 0;
        foreach ($model as $val) {
            if ($extend == null) {
				$result[] = [
					'id' => $val->village_id,
					'label' => $val->village_name, 
				];
			} else {
				$extendArray = array_map("trim", explode(',', $extend));
				$result[$i] = [
					'id' => $val->village_id,
					'label' => join(', ', [$val->village_name, $val->district->district_name, $val->district->city->city_name, $val->district->city->province->province_name]),
				];
                if (!empty($extendArray)) {
                    if (in_array('village_name', $extendArray)) {
                        $result[$i]['village_name'] = $val->village_name;
                    }
                    if (in_array('district_id', $extendArray)) {
                        $result[$i]['district_id'] = $val->district_id;
                    }
                    if (in_array('district_name', $extendArray)) {
                        $result[$i]['district_name'] = $val->district->district_name;
                    }
                    if (in_array('city_id', $extendArray)) {
                        $result[$i]['city_id'] = $val->district->city_id;
                    }
                    if (in_array('city_name', $extendArray)) {
                        $result[$i]['city_name'] = $val->district->city->city_name;
                    }
                    if (in_array('province_id', $extendArray)) {
                        $result[$i]['province_id'] = $val->district->city->province_id;
                    }
                    if (in_array('province_name', $extendArray)) {
                        $result[$i]['province_name'] = $val->district->city->province->province_name;
                    }
                    if (in_array('country_id', $extendArray)) {
                        $result[$i]['country_id'] = $val->district->city->province->country_id;
                    }
                    if (in_array('country_name', $extendArray)) {
                        $result[$i]['country_name'] = $val->district->city->province->country->country_name;
                    }
                    if (in_array('zipcode', $extendArray)) {
                        $result[$i]['zipcode'] = $val->zipcode;
                    }
				} else {
                    $result[$i]['village_name'] =  $val->village_name;
                }
				$i++;
			}
		}
		return $result;
	}

	/**
	 * Finds the CoreZoneVillage model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return CoreZoneVillage the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
        if (($model = CoreZoneVillage::findOne($id)) !== null) {
            return $model;
        }

		throw new \yii\web\NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}
