ZarinPal Payment
================
Online Zarinpal Payment Extension For Yii2

Installation
==============
The preferred way to install this extension is through composer.

Either run
```
php composer.phar require amirasaran/zarinpal:*
```
or add
```
"amirasaran/zarinpal": "*"
```
to the require section of your ``composer.json`` file.
    
How to config payment component
===============================
Add the following code to your ``common/config/main.php`` ``components``

```
    'components' => [
         ....
        'zarinpal' => [
            'class' => 'amirasaran\zarinpal\Zarinpal',
            'merchant_id' => 'XXXXXXX-XXX-XXXX-XXXXXXXXXXXX',
            'callback_url' => 'http://site.com/payment/verify'
        ],
        .... 
    ]
        
```

How to use this component
=========================
For example, imagine that you have a controller called this PaymentController at first you need 2 actions,
one of them is for request payment and another is verify payment.

you need to use an storage to save your payments and payments status.

``PaymentController.php``
```
..... 

public function actionRequest()
{
    /** @var Zarinpal $zarinpal */
    $zarinpal = Yii::$app->zarinpal ;
    if($zarinpal->request(100,'Test Payment description')->getStatus() == '100'){
        /*
        * You can save your payment request data to the database in here before rediract user
        * to get authority code you can use $zarinpal->getAuthority()
        */
        return $this->redirect($zarinpal->getRedirectUrl());
    }
    echo "Error !";
}


public function actionVerify($Authority, $Status){

    if($Status != "OK")
        return ; //Payment canceled by user 

    /** @var Zarinpal $zarinpal */
    $zarinpal = Yii::$app->zarinpal ;
    
    if($zarinpal->verify($Authority, 100)->getStatus() == '100'){
        //User payment successfully verified!
        echo "payment successfully";
    }
    elseif($zarinpal->getStatus() == '101') {
        //User payment successfuly verified but user try to verified more than one 
        echo  "duplicated verify payment";
    } 
    else
        echo "payment error !";
}

.....
```
