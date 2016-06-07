<?php

use vendor\amirasaran\zarinpal\models\Payment;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel vendor\amirasaran\zarinpal\models\PaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Payments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Payment'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'authority',
            'amount',
            [
                'attribute' => 'status',
                'format'    => 'raw',
                'value'     => function ($model) {
                    if ($model->status === Payment::STATUS_CANCELED) {
                        $status = "<span class='glyphicon-erase glyphicon text-danger'><b> Canceled</b></span>";
                    } elseif ($model->status == Payment::STATUS_WAITING) {
                        $status = "<span class='glyphicon-warning-sign glyphicon text-info'><b> Waiting to Complete</b></span>";
                    } elseif ($model->status == Payment::STATUS_SUCCESS) {
                        $status = "<span class='glyphicon-ok glyphicon text-success '><b> Completed</b></span>";
                    } else {
                        $status = 'Not Set';
                    }

                    return $status;
                },
            ],
            'refid',
             'description',
             'ip',

            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>

</div>
