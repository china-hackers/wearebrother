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
