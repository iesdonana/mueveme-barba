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
    $('button').click(function(e) {
        var idPoyuo = $(this).attr('noticia_id');
        var bot = this ;
        $.ajax({
            url: '$url',
            method: 'POST',
            data: { movimientos: '$meneos' , id: idPoyuo },
            success: function (data, status, xhr) {
                 $(bot).next().html(data);
            }
        });
    });
EOF;
$this->registerJs($js); ?>

    <div class="row">
        <?= Html::button('Meneos ',['class'=> 'btn btn-primary', 'noticia_id' => $model->id]) ?>
        <label id="meneillos"><?= $meneos?></label>
        <?= Html::a('Comentarios',
                ['comentarios/ver','id'=> $model->id],
                ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Html::encode($model->categoria->categoria),
                ['noticias/index', 'NoticiasSearch[categoria_id]' => $model->categoria_id],
                ['class' => 'btn btn-primary'])
         ?>
    </div>

</div>
