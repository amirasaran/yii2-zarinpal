<?php

namespace vendor\amirasaran\zarinpal\models;

use SoapClient;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "payment".
 *
 * @property int $id
 * @property string $authority
 * @property int $amount
 * @property int $status
 * @property string $refid
 * @property int $description
 * @property int $ip
 */
class Payment extends \yii\db\ActiveRecord
{
    const STATUS_SUCCESS = 100;
    const STATUS_WAITING = 1;
    const STATUS_CANCELED = -1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%payment}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['authority', 'amount', 'status', 'description', 'ip'], 'required'],
            [['amount', 'status'], 'integer'],
            [['authority'], 'string', 'max' => 36],
            [['description'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('app', 'ID'),
            'authority'   => Yii::t('app', 'Authority'),
            'amount'      => Yii::t('app', 'Amount'),
            'status'      => Yii::t('app', 'Status'),
            'refid'       => Yii::t('app', 'Refid'),
            'description' => Yii::t('app', 'Description'),
            'ip'          => Yii::t('app', 'Ip'),
        ];
    }

    /*
     * Check Payment Status
     */
    public function checkAuthority($module)
    {
        $params =
            [
                'MerchantID'       => $module->module->merchant_id,
                'Authority'        => $this->authority,
                'Amount'           => $this->amount,
            ];

        $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        $result = $client->PaymentVerification($params);

        if ($result->Status == 100) {
            $this->status = self::STATUS_SUCCESS;
            $this->refid = $result->RefID;
        } else {
            $this->status = self::STATUS_CANCELED;
        }

        return ($result->Status == 100) ? true : $result->Status;
    }

    public function createPayment($module)
    {
        $params =
            [
                'MerchantID'     => $module->module->merchant_id,
                'Amount'         => $this->amount,
                'Description'    => $this->description,
                'CallbackURL'    => Url::to($module->module->calback_url),
            ];
        $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        $result = $client->PaymentRequest($params);

        return $result;
    }
}
