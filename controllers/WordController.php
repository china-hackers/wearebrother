<?php

namespace app\controllers;

use Yii;
use app\models\Word;
use app\components\AppController as Controller;

class WordController extends Controller
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
        ];
    }

    public function actionTest(){
        $data = file_get_contents('./1.html');
        $parm = '/<\/div>(\s*?)<\/div>(\s*?)<\/div>([\s\S]{1,})/';
        $matches = [];
        preg_match($parm, $data, $matches);
        print_r($matches);

    }

    public function actionError($w){
        echo 'Sorry, we are not ready~';
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($w='')
    {
        $data = [];
        if($w) $data = Word::searchWord($w);
        return $this->renderPartial('index', [
            'data' => $data
        ]);
    }

}
