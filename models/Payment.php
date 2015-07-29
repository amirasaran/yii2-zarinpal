<?php

namespace vendor\amirasaran\zarinpal\models;

require_once('nusoap.php');

use vendor\amirasaran\zarinpal\Zarinpal;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "payment".
 *
 * @property integer $id
 * @property string $authority
 * @property integer $amount
 * @property integer $status
 * @property string $refid
 * @property integer $description
 * @property integer $ip
 */
class Payment extends \yii\db\ActiveRecord
{

    const STATUS_SUCCESS = 100;
    const STATUS_WAITING = 1;
    const STATUS_CANCELED = -1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%payment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['authority', 'amount', 'status', 'refid', 'description', 'ip'], 'required'],
            [['amount', 'status',  'ip'], 'integer'],
            [['authority'], 'string', 'max' => 36],
            [['description'], 'string'],
            [['refid'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'authority' => Yii::t('app', 'Authority'),
            'amount' => Yii::t('app', 'Amount'),
            'status' => Yii::t('app', 'Status'),
            'refid' => Yii::t('app', 'Refid'),
            'description' => Yii::t('app', 'Description'),
            'ip' => Yii::t('app', 'Ip'),
        ];
    }


    /*
     * Check Payment Status
     */
    public function checkAuthority(){

    }

    public function createPayment($module){

        $zarinPal = new Zarinpal('zarinpal');
        $params =
            [
                'MerchantID' 	=> $module->module->merchant_id,
                'Amount' 		=> $this->amount,
                'Description' 	=> $this->description,
//                'Email' 		=> $Email,
//                'Mobile' 		=> $Mobile,
                'CallbackURL' 	=> Url::to($module->module->calback_url),
            ];
        $client = new nusoap_client('https://de.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
        $client->soap_defencoding = 'UTF-8';
        $result = $client->call('PaymentRequest',[$params]);

        return $result;
    }
}