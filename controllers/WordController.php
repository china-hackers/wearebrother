<?php

namespace app\controllers;

use Yii;
use app\models\Dict;
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
        $w = urlencode('CHINA');
        $url = "http://dict-co.iciba.com/api/dictionary.php?type=json&w=$w&key=9F153B01D3161642CB56C1BB78D4E50E";
        echo file_get_contents($url);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($w='')
    {
        $data = [];
        if($w) $data = Dict::searchDict($w);
        return $this->renderPartial('index', [
            'data' => $data
        ]);
    }

}
