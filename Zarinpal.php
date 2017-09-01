<?php

namespace amirasaran\zarinpal;

use SoapClient;
use yii\base\Model;

class Zarinpal extends Model
{
    public $merchant_id;
    public $callback_url;
    public $testing = false;
    private $_status;
    private $_authority;
    private $_ref_id;

    public function request($amount, $description, $email = null, $mobile = null, $callbackParams = [])
    {
        if(count($callbackParams) > 0){
            $i = 0;
            foreach ($callbackParams as $name => $value){
                if($i == 0) {
                    $this->callback_url .= '?';
                }else{
                    $this->callback_url .= '&';
                }
                $this->callback_url .= $name.'='.$value;
                $i++;
            }
        }
        
        if($this->testing){
            $client = new SoapClient('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        }else{
            $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        }
        $result = $client->PaymentRequest(
            [
                'MerchantID'  => $this->merchant_id,
                'Amount'      => $amount,
                'Description' => $description,
                'Email'       => $email,
                'Mobile'      => $mobile,
                'CallbackURL' => $this->callback_url,
            ]
        );

        $this->_status = $result->Status;
        $this->_authority = $result->Authority;

        return $this;
    }

    public function verify($authority, $amount)
    {
        $this->_authority = $authority;
        if($this->testing){
            $client = new SoapClient('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        }else{
            $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        }
        $result = $client->PaymentVerification(
            [
                'MerchantID' => $this->merchant_id,
                'Authority'  => $this->_authority,
                'Amount'     => $amount,
            ]
        );

        $this->_status = $result->Status;
        $this->_ref_id = $result->RefID;

        return $this;
    }

    public function getStatus()
    {
        return $this->_status;
    }

    public function getRedirectUrl($zaringate = true)
    {
        if($this->testing){
            $url = 'https://sandbox.zarinpal.com/pg/StartPay/'. $this->_authority;
        }else{
            $url = 'https://www.zarinpal.com/pg/StartPay/'.$this->_authority;
        }
        $url .=  ($zaringate) ? '/ZarinGate' : '';

        return $url;
    }

    public function getAuthority()
    {
        return $this->_authority;
    }
}
