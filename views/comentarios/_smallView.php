<?php
use yii\helpers\Html;
?>

<div class="comentarios-view">

    <?php
    $formatter = \Yii::$app->formatter;
    ?>
    <br>
    <?= Html::encode($model->cuerpo) ?>
    <br>
    <small>
        por <?= Html::a(Html::encode($model->usuario->nombre),
                ['usuarios/view', 'id' => $model->usuario_id]) ?> -----
        Creado a <?= $formatter->asTime($model->created_at, 'short') ?> <?= $formatter->asRelativeTime($model->created_at, new DateTime()) ?>
    </small><br>


</div>
