<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<div class="noticias-view">

    <h1><?= Html::a(Html::encode($model->titulo), Html::encode($model->noticia)) ?></h1>

    <?php
    $formatter = \Yii::$app->formatter;

    $inicio = strpos($model->noticia, "//")+2;
    $fin = strpos($model->noticia, "/", $inicio)-$inicio;
    $str = mb_substr($model->noticia, $inicio, $fin);

 ?>
    <small>
        por <?= Html::a(Html::encode($model->usuario->nombre),
                ['usuarios/view', 'id' => $model->usuario_id]) ?>
        a <?= Html::a(Html::encode($str), Html::encode($model->noticia)) ?> -----
        Creado a <?= $formatter->asTime($model->created_at, 'short') ?> <?= $formatter->asRelativeTime($model->created_at, new DateTime()) ?>
    </small><br>

    <?= Html::encode($model->cuerpo) ?>

    <?php
    $meneos = $model->movimiento;
    $url = Url::to(['noticias/movimientos']);
    $js = <<<EOF
    $('button[noticia-id]').on('click', function() {
        var button = $(this);
        $.ajax({
            url: '$url',
            method: 'GET',
            data: { id: $(this).attr('noticia-id') },
            success: function (data, status, xhr) {
                button.next().html(data);
            }
        });
    });
EOF;
$this->registerJs($js); ?>

    <div class="col">
        <?= Html::button('Meneos' ,['class'=> 'btn btn-primary', 'noticia-id' => $model->id]) ?>
        <?= Html::label($model->movimiento) ?>
        <?= Html::a('Comentarios',
                ['comentarios/ver','id'=> $model->id],
                ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Html::encode($model->categoria->categoria),
                ['noticias/index', 'NoticiasSearch[categoria_id]' => $model->categoria_id],
                ['class' => 'btn btn-primary'])
         ?>
    </div>

</div>
