<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model vendor\amirasaran\zarinpal\models\Payment */

$this->title = Yii::t('app', 'Create Payment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="payment-form">

        <?php $form = ActiveForm::begin(); ?>

<!--        --><?//= $form->field($model, 'authority')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'amount')->textInput() ?>

<!--        --><?//= $form->field($model, 'status')->textInput() ?>

<!--        --><?//= $form->field($model, 'refid')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textInput() ?>

<!--        --><?//= $form->field($model, 'ip')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
