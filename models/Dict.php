<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%dict}}".
 *
 * @property integer $id
 * @property string $word
 * @property string $word_pl
 * @property string $word_third
 * @property string $word_past
 * @property string $word_done
 * @property string $word_ing
 * @property string $word_er
 * @property string $word_est
 * @property string $ph_en
 * @property string $ph_am
 * @property string $ph_other
 * @property string $ph_en_mp3
 * @property string $ph_am_mp3
 * @property string $ph_tts_mp3
 * @property string $parts
 * @property string $gelinsi
 * @property string $yysy
 * @property string $zysy
 * @property string $wlsy
 * @property string $tgc
 * @property string $jyc
 * @property string $sylj
 * @property string $yslj
 * @property string $qwlj
 */
class Dict extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dict}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gelinsi', 'yysy', 'zysy', 'wlsy', 'tgc', 'jyc', 'sylj', 'yslj', 'qwlj'], 'string'],
            [['word', 'word_pl', 'word_third', 'word_past', 'word_done', 'word_ing', 'word_er', 'word_est', 'ph_en', 'ph_am', 'ph_other'], 'string', 'max' => 50],
            [['ph_en_mp3', 'ph_am_mp3', 'ph_tts_mp3'], 'string', 'max' => 250],
            [['parts'], 'string', 'max' => 500],
        ];
    }

    private static function getByIciba($w){
        $w = urlencode($w);
        $url = "http://dict-co.iciba.com/api/dictionary.php?type=json&w=$w&key=9F153B01D3161642CB56C1BB78D4E50E";
        $json = file_get_contents($url);
        $json = json_decode($json);
        return $json;
    }

    private static function getPartsZh($json){
        $symbols = $json->symbols;
        $string = '';
        foreach($symbols as $s){
            $tmp = '<p class="word_line"><span class="yinbiao">['.$s->word_symbol.']</span>';
            $parts = $s->parts;
            foreach($parts as $p){
                $tmp .= '<span class="leixing">('.$p->part_name.')</span>';
                $means = $p->means;
                foreach($means as $m){
                    $word = urlencode($m->word_mean);
                    $tmp .= '<a class="word" href="/s/'.$word.'">'.$m->word_mean.'</a>;';
                }
            }
            $string .= '</p>'.$tmp;
        }
        return $string;
    }

    private static function getWordByIciba($json, $data){
        $exchange = $json->exchange;
        foreach($exchange as $k=>$v){
            if(empty($v)) continue;
            if(is_array($v))
                $data[$k] = $v[0];
            else
                $data[$k] = $v;
        }
        $symbols = $json->symbols;
        $string = '';
        foreach($symbols as $symbol)
        foreach($symbol as $k=>$v){
            if(empty($v)) continue;
            if(is_array($v)){
                if($k != 'parts') continue;
                $parts = $v;
                foreach($parts as $p){
                    $string .= '<p class="word_line"><span class="leixing">('.$p->part.')</span>';
                    $means = $p->means;
                    foreach($means as $m){
                        $string .= ' '.$m.';';
                    }
                    $string .= '</p>';
                }
            }else{
                $data[$k] = $v;
            }
        }
        $data['parts'] = $string;
        return $data;
    }

    private static function getByBaidu($w){
        $url = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
        $x = ord($w);
        $q = [];
        if($x>64 && $x<123){
            $from = 'en';
            $to = 'zh';
        }else{
            $from = 'zh';
            $to = 'en';
        }
        $q['q'] = urlencode($w);
        $q['from'] = $from;
        $q['to'] = $to;
        $q['appid'] = '20180825000198731';
        $q['salt'] = time();
        $q['sign'] = md5($q['appid'].$q['q'].$q['salt'].'iwgexIvo7_HxEbgLH4cJ');
        foreach($q as $k=>$v){
            $url .= $k.'='.$v.'&';
        }
        return file_get_contents($url);
    }

    public static function searchDict($w){
        $w = trim($w);
        $w = str_replace('"','\'',$w);
        $model = Dict::find()->where('word="'.$w.'"')->one();
        if($model){
            $data =  $model->attributes;
            foreach($data as $key=>$value){
                if(empty($value)) unset($data[$key]);
            }
            return $data;
        }
        $model = new Dict();
        $data = $model->attributes;
        $json = self::getByIciba($w);
        print_r($json);
        if(!isset($json->word_name)){//整段翻译
            $data['word'] = $w;
            $data['parts'] = self::getByBaidu($w);
            echo '---------';
        }elseif(!isset($json->exchange)){//查询中文
            $data['word'] = $json->word_name;
            $data['parts'] = self::getPartsZh($json);
        }else{
            $data['word'] = $json->word_name;
            $data = self::getWordByIciba($json, $data);
            $model->attributes = $data;
            $model->save();
        }
        foreach($data as $key=>$value){
            if(empty($value)) unset($data[$key]);
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
            'word_pl' => '复数',
            'word_third' => '第三人称',
            'word_past' => '过去式',
            'word_done' => '完成式',
            'word_ing' => '进行式',
            'word_er' => '比较级',
            'word_est' => '最高级',
            'ph_en' => '英式发音',
            'ph_am' => '美式发音',
            'ph_other' => '其他',
            'ph_en_mp3' => 'mp3',
            'ph_am_mp3' => 'mp3',
            'ph_tts_mp3' => 'MP3',
            'parts' => '翻译',
            'gelinsi' => '格林斯辞典',
            'yysy' => '英英释义',
            'zysy' => '专业释义',
            'wlsy' => '网络释义',
            'tgc' => '同根词',
            'jyc' => '同近义词',
            'sylj' => '双语例句',
            'yslj' => '原声例句',
            'qwlj' => '权威例句',
        ];
    }
}
