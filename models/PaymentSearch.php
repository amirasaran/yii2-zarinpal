<?php

namespace vendor\amirasaran\zarinpal\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use vendor\amirasaran\zarinpal\models\Payment;

/**
 * PaymentSearch represents the model behind the search form about `vendor\amirasaran\zarinpal\models\Payment`.
 */
class PaymentSearch extends Payment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'amount', 'status', 'description', 'ip'], 'integer'],
            [['authority', 'refid'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Payment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'amount' => $this->amount,
            'status' => $this->status,
            'description' => $this->description,
            'ip' => $this->ip,
        ]);

        $query->andFilterWhere(['like', 'authority', $this->authority])
            ->andFilterWhere(['like', 'refid', $this->refid]);

        return $dataProvider;
    }
}
