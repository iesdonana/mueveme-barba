<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\NoticiasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="noticias-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php // echo $form->field($model, 'id') ?>

    <?= $form->field($model, 'titulo') ?>

    <?php // echo $form->field($model, 'noticia') ?>

    <?php // echo $form->field($model, 'cuerpo') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'movimiento') ?>

    <?php
    if (isset($listaCategorias)) {
        echo $form->field($model, 'categoria_id')
        ->widget(Select2::class,['data'=>$listaCategorias,
            'options'=>[
                'placeholder'=> 'Selecciona una categoria...',
            ],
        ])
        ->label('Categoria');
    } else {
        echo $form->field($model, 'categoria_id')->widget(Select2::classname(), [
            'initValueText' => '', // set the initial display text
            'options' => ['placeholder' => 'Selecciona una categoria...'],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 2,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Esperando el resultado...'; }"),
                ],
                'ajax' => [
                    'url' => Url::to(['categorias/list']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(categorias) { return categorias.text; }'),
                'templateSelection' => new JsExpression('function (categorias) { return categorias.text; }'),
            ],
        ])
        ->label('Categoria');
    }
    ?>

    <?php // echo $form->field($model, 'usuario_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
