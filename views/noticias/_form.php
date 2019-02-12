<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Noticias */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="noticias-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'noticia')->textInput(['maxlength' => true])->label('Link') ?>

    <?= $form->field($model, 'cuerpo')->textarea(['rows' => 6]) ?>

    <?php // echo $form->field($model, 'created_at')->textInput() ?>

    <?php // echo $form->field($model, 'movimiento')->textInput() ?>

    <?=
    $form->field($model, 'categoria_id')
    ->widget(Select2::class,['data'=>$listaCategorias,
        'options'=>[
            'placeholder'=> 'Busca, Reventao!',
        ],
    ])
    ->label('Categoria')
    ?>


    <?= $form->field($model, 'usuario_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
