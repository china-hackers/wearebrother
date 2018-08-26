<?php
/**
 * Created by PhpStorm.
 * Author: Leonidax
 * Date: 2016/12/11
 * Time: 13:42
 * Email:wap@iamlk.cn
 */

namespace app\modules\backend\models;

use yii\base\Model;
use app\models\ContentReply;
use yii\data\ActiveDataProvider;

class ContentReplySearch extends ContentReply
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['detail', 'created'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * 创建时间
     * @return array|false|int
     */
    public function getCreated()
    {
        if(empty($this->created)){
            return null;
        }
        $createdAt = is_string($this->created)?strtotime($this->created):$this->created;
        if(date('H:i:s', $createdAt)=='00:00:00'){
            return [$createdAt, $createdAt+3600*24];
        }
        return $createdAt;
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param int $pageSize
     * @return ActiveDataProvider
     */
    public function search($params, $pageSize=20)
    {
        $query = ContentReply::find();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>['defaultOrder'=>['id'=>SORT_DESC]],
            'pagination' => ['pageSize'=>$pageSize]
        ]);

        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $createAt = $this->getCreated();
        if(is_array($createAt)) {
            $query->andFilterWhere(['>=','created', $createAt[0]])
                ->andFilterWhere(['<=','created', $createAt[1]]);
        }else{
            $query->andFilterWhere(['created'=>$createAt]);
        }

        return $dataProvider;
    }
}