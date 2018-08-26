<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%content_reply}}".
 *
 * @property integer $id
 * @property integer $content_id
 * @property string $detail
 * @property integer $heart
 * @property integer $user_id
 * @property integer $created
 */
class ContentReply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%content_reply}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content_id', 'heart', 'user_id', 'created'], 'integer'],
            [['detail', 'user_id'], 'required'],
            [['detail'], 'string'],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['content_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function getContent(){
        // hasOne要求返回两个参数 第一个参数是关联表的类名 第二个参数是两张表的关联关系
        // 这里id是ArticleCategory表的id, 关联article表的id
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content_id' => '所属文章',
            'detail' => '评论内容',
            'heart' => '赞',
            'user_id' => '用户ID',
            'created' => '评论时间',
        ];
    }
}
