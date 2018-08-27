<?php

namespace app\models;

use Yii;
use \app\models\Word2;

/**
 * This is the model class for table "{{%word}}".
 *
 * @property integer $id
 * @property string $word
 * @property string $plain
 * @property string $explain
 */
class Word extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%word}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plain', 'explain'], 'string'],
            [['word'], 'string', 'max' => 50],
        ];
    }

    public static function request($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $r = curl_exec($ch);
        curl_close($ch);
        return $r;
    }

    private static function insertWord($data, $sw, $w){
        //先确保单词库有就可以了
        $word = Word::find()->where('word="'.$w.'"')->one();
        //单词库里面没有插入单词就是了
        if(!$word){
            $word = new Word();
            $word->attributes = $data;
            try{
                $word->save();
            }catch(\Exception $e){
                file_put_contents('./word.txt',$w."\r\n",FILE_APPEND);
            }
        }
        //如果查询的单词和有道的单词有细微区别，就建立对应关系
        if($sw !== $w){
            $word2 = new Word2();
            $word2->wid = $word->id;
            $word2->word = $sw;
            try{
                $word2->save();
            }catch(\Exception $e){
                file_put_contents('./word2.txt',$sw."\r\n",FILE_APPEND);
            }
        }
    }

    private static function getECinfo($html, $sw){
        $match = [];
        $data = [];
        $html = str_replace('   ', '', $html);
        //截取翻译和扩展
        $patt = '/(<div id="bd")([\s\S]*?)<div class="content-wrp"/';
        preg_match($patt, $html,$match);
        $html = $match[1].$match[2];
        //截取扩展
        $patt = '/<\/div>(\s*?)<\/div>(\s*?)<\/div>([\s\S]{1,})<\/div>/';
        preg_match($patt, $html, $match);
        $data['explain'] = trim($match[3]);
        //截取核心内容
        $patt = '/<div id="ec_contentWrp"([\s\S]*?)<\/div>(\s*?)<\/div>(\s*?)<\/div>/';
        preg_match($patt, $html, $match);
        $html = $match[0];
        //匹配出单词
        $patt = '/<span>([\s\S]*?)<\/span>/';
        preg_match($patt, $html, $match);
        $w = trim($match[1]);
        //替换纠错按钮
        $html = str_replace('https://c.youdao.com/ugc/errorreport.html', '/word/error', $html);
        $data['word'] = $w;
        $data['plain'] = $html;
        self::insertWord($data,$sw,$w);
        return $data;
    }

    private static function getCEinfo($html, $sw){
        $match = [];
        $data = [];
        $html = str_replace('   ', '', $html);
        //截取翻译和扩展
        $patt = '/(<div id="bd")([\s\S]*?)<div class="content-wrp"/';
        preg_match($patt, $html,$match);
        $html = $match[1].$match[2];
        //截取扩展
        $patt = '/<\/ul>(\s*?)<\/div>(\s*?)<\/div>([\s\S]{1,})<\/div>/';
        preg_match($patt, $html, $match);
        $data['explain'] = trim($match[3]);
        //截取核心内容
        $patt = '/<div id="ce_contentWrp"([\s\S]*?)<\/div>(\s*?)<\/div>/';
        preg_match($patt, $html, $match);
        $match[0] = str_replace('/dict?q=','/s/',$match[0]);
        $data['word'] = $sw;
        $data['plain'] = $match[0];
        self::insertWord($data,$sw,$sw);
        return $data;
    }

    private static function getFYinfo($html){
        $match = [];
        $data = [];
        $html = str_replace('   ', '', $html);
        //截取核心内容
        $patt = '/<div id="fanyi_contentWrp"([\s\S]*?)<\/div>(\s*?)<\/div>/';
        preg_match($patt, $html, $match);
        $data['plain'] = $match[0];
        return $data;
    }

    public static function searchWord($w){
        $w = trim($w);
        $w = str_replace('"','\'',$w);
        //优先查询数据库
        $word = Word::find()->where('word="'.$w.'"')->one();
        if($word) {
            return $word->attributes;
        }
        $model = Word2::find()->where('word="'.$w.'"')->one();
        if($model){
            $word = Word::findOne($model->wid);
            return $word->attributes;
        }
        //抓取有道词典
        $url = 'http://m.youdao.com/dict?le=eng&q='.urlencode($w);
        $html = self::request($url);
        if(strpos($html,'"ec_contentWrp"')){//英译中
            $data = self::getECinfo($html,$w);
        }elseif(strpos($html,'"ce_contentWrp"')){//中译英
            $data = self::getCEinfo($html,$w);
        }elseif(strpos($html, '"fanyi_contentWrp"')){//翻译
            $data = self::getFYinfo($html);
        }else{//没有结果
            $data = [];
        }
        return $data;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'word' => '单词',
            'plain' => '翻译',
            'explain' => '扩展翻译',
        ];
    }
}
