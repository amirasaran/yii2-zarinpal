<?php

namespace vendor\amirasaran\zarinpal;

use yii\base\Module;

class Zarinpal extends Module
{
    public $merchant_id;
    public $calback_url;
    public $controllerNamespace = 'vendor\amirasaran\zarinpal\controllers';
    public $defaultRoute = 'payment';
}
