<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\SignupForm */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use app\models\User;
use app\models\Order;
$this->title = 'Заказ';
$this->params['breadcrumbs'][] = $this->title;
$users=User::find()->all();
?>
<div class="site-order">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Добавить заказ в бонусную систему:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'user_id')->dropDownList(
         ArrayHelper::map($users,'id',function ($element) {
         return $element['id'] . '. '.$element['surname'] . ' '. $element['name'];
         }),
        ['prompt'=>'Выбрать...']
        )->label('Пользователь'); ?>

                <?= $form->field($model, 'sum_of_order')->label('Сумма заказа') ?>



                <div class="form-group">
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
