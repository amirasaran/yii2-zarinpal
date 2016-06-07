<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model vendor\amirasaran\zarinpal\models\Payment */

$this->title = $model->amount;
$this->registerMetaTag(['http-equiv' => 'refresh', 'content' => '2;URL=https://www.zarinpal.com/pg/StartPay/'.$model->authority]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Wating to go ZarinPal payment ...'), ['https://www.zarinpal.com/pg/StartPay/'.$model->authority], ['class' => 'btn btn-primary']) ?>
    </p>
</div>