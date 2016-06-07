<?php

use vendor\amirasaran\zarinpal\models\Payment;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model vendor\amirasaran\zarinpal\models\Payment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($model->status == 1) : ?>
    <p>
        <?= Html::a(Yii::t('app', 'Pay This Factor'), ['pay', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
    <?php endif; ?>

    <?php
     if ($model->status === Payment::STATUS_CANCELED) {
         $status = "<span class='glyphicon-erase glyphicon text-danger'><b> Canceled</b></span>";
     } elseif ($model->status == Payment::STATUS_WAITING) {
        $status = "<span class='glyphicon-warning-sign glyphicon text-info'><b> Waiting to Complete</b></span>";
    } elseif ($model->status == Payment::STATUS_SUCCESS) {
        $status = "<span class='glyphicon-ok glyphicon text-success '><b> Completed</b></span>";
    } else {
        $status = 'Not Set';
    }
    ?>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'authority',
            'amount',
            [
                'attribute' => 'status',
                'format'    => 'raw',
                'value'     => $status,

            ],
            'status',
            'refid',
            'description',
            'ip',
        ],
    ]) ?>

</div>
