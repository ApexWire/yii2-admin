<?php

namespace mdm\admin\controllers;

use Yii;
use mdm\admin\models\Route;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * Description of RuleController
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 *
 *
 * in config
 * $config = yii\helpers\ArrayHelper::merge(
 *  require(Yii::getAlias('@common') . '/config/main.php'),
 *  require(Yii::getAlias('@common') . '/config/main-local.php'),
 *  require(Yii::getAlias('@frontend') . '/config/main.php'),
 *  require(Yii::getAlias('@frontend') . '/config/main-local.php')
 * );
 * ...
 * 'controllerMap' => [
 * ...
 *  'route' => [
 *  'class' => 'mdm\admin\controllers\RouteController',
 *  'appModule' =>  new yii\web\Application($config),
 *  ],
 * ...
 * ],
 * ```
 */
class RouteController extends Controller
{
    /** @type null|string|\yii\web\Application */
    public $appModule = null;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                    'assign' => ['post'],
                    'remove' => ['post'],
                    'refresh' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Route models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Route();

        return $this->render('index', ['routes' => $model->getRoutes($this->appModule)]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        Yii::$app->getResponse()->format = 'json';
        $routes = Yii::$app->getRequest()->post('route', '');
        $routes = preg_split('/\s*,\s*/', trim($routes), -1, PREG_SPLIT_NO_EMPTY);
        $model = new Route();
        $model->addNew($routes);

        return $model->getRoutes($this->appModule);
    }

    /**
     * Assign routes
     * @return array
     */
    public function actionAssign()
    {
        $routes = Yii::$app->getRequest()->post('routes', []);
        $model = new Route();
        $model->addNew($routes);
        Yii::$app->getResponse()->format = 'json';

        return $model->getRoutes($this->appModule);
    }

    /**
     * Remove routes
     * @return array
     */
    public function actionRemove()
    {
        $routes = Yii::$app->getRequest()->post('routes', []);
        $model = new Route();
        $model->remove($routes);
        Yii::$app->getResponse()->format = 'json';

        return $model->getRoutes($this->appModule);
    }

    /**
     * Refresh cache
     * @return array
     */
    public function actionRefresh()
    {
        $model = new Route();
        $model->invalidate();
        Yii::$app->getResponse()->format = 'json';

        return $model->getRoutes($this->appModule);
    }
}
