<?php

namespace app\controllers;

use app\models\Category;
use app\models\Content;
use app\models\News;
use Yii;
use app\components\AppController as Controller;
use app\models\Feedback;
use app\models\Config;
use yii\data\ActiveDataProvider;
use app\modules\backend\models\BaseConfig;
use app\models\Ad;
use yii\web\NotFoundHttpException;
use app\models\Page;
use yii\helpers\Html;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function init(){
        parent::init();
        $ads = Ad::find()->where('type=101')->all();
        Yii::$app->view->params['ads'] = $ads;
        $cates = Category::find()->where('type=1')->all();
        Yii::$app->view->params['cates'] = $cates;
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->getView()->title = "北川卫生和计划生育委员会";
        $cates = Category::find()->where('type=1')->all();
        $list = News::find()->limit(5)->orderBy('id desc')->all();
        $config = new BaseConfig();
        $des = $config->description;
        return $this->render('index', [
            'cates' => $cates,
            'list' => $list,
            'des' => $des,
        ]);
    }

    public function actionNews($id){
        $model = News::findOne($id);
        $this->getView()->title = $model->title;
        return $this->render('news',[
           'model'=>$model
        ]);
    }

    public function actionList($id){
        $cate = Category::findOne($id);
        $list = News::find()->where('category_id="'.$id.'"')->orderBy('id DESC')->limit(80)->all();
        $this->getView()->title = $cate->name;
        return $this->render('list',[
           'list' => $list
        ]);
    }

    public function actionFeedback(){
        $this->getView()->title = '留言板';
        $model = new Feedback();
        if($_POST){
            $model->attributes = $_POST['feedback'];
            $model->created_at = time();
            if($model->save()){
                $message = '提交成功！';
            }else{
                $message = $model->getFirstErrors();
            }
            Yii::$app->session->setFlash('contactFormSubmitted',$message);
            return $this->refresh();
        }
        return $this->render('feedback');
    }

    /**
     * Displays about page.
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionAbout()
    {
        $config = Config::getByName('about_us');
        if(empty($config)){
            throw new NotFoundHttpException('页面不存在');
        }
        return $this->actionPage($config['value']);
    }
    /**
     * Displays products page
     *
     * @return string
     */
    public function actionContact()
    {
        $config = Config::getByName('contact_us');
        if(empty($config)){
            throw new NotFoundHttpException('页面不存在');
        }
        return $this->actionPage($config['value']);
    }

    /**
     * config 页面
     * @param int $id
     * @throws NotFoundHttpException
     * @return string
     */
    public function actionPage($id)
    {
        $page = Page::findOne($id);
        if(empty($page)){
            throw new NotFoundHttpException('页面不存在');
        }
        if(!empty($page->keywords)){
            $this->view->registerMetaTag(['name'=>'keywords', 'content'=>$page->keywords],'keywords');
        }
        if(!empty($page->description)){
            $this->view->registerMetaTag(['name'=>'description', 'content'=>$page->description], 'description');
        }
        $this->getView()->title = $page->title;
        return $this->render('page',[
            'model'=>$page
        ]);
    }

}
