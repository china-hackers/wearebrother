<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%word2}}".
 *
 * @property integer $id
 * @property integer $wid
 * @property string $word
 */
class Word2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%word2}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wid'], 'required'],
            [['wid'], 'integer'],
            [['word'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wid' => '所属word',
            'word' => '误拼写',
        ];
    }
}
