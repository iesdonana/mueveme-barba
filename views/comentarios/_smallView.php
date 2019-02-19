<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;

$formatter = \Yii::$app->formatter;
?>
<style media="screen">
.comentario {
    padding: 5px;
}
.comentario-cuerpo {
    background-color: #fff5ed;
    position: relative;
    padding: 5px 10px 5px 30px;
    border-radius: 2px;
}
.comentario-texto {
    padding-left: 10px;
}
.votos {
    padding-left: 10px;
    padding-top: 3px;
}
</style>

<div class="comentario">
    <div class="comentario-cuerpo">
        <div class="comentario-texto">
            <?= Html::encode($model->cuerpo) ?>
            <br>
            <small>
                por <?= Html::a(Html::encode($model->usuario->nombre),
                ['usuarios/view', 'id' => $model->usuario_id]) ?> -----
                Creado a <?= $formatter->asTime($model->created_at, 'short') ?> <?= $formatter->asRelativeTime($model->created_at, new DateTime()) ?>
                <?= Html::a('Responder', ['comentarios/create', 'model' => $model], ['class' => 'btn btn-primary']) ?>
                <?php Modal::begin([
                    'header' => '<h2>Hello world</h2>',
                    'toggleButton' => ['label' => 'Responder'],
                ]);


                echo $this->render('create', [
                    'model' => $model,
                ]);

                Modal::end(); ?>
            </small>
        </div>
    </div>
</div>
