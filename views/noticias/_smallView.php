<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

$formatter = Yii::$app->formatter;
$url = Url::to(['noticias/menear']);
$js = <<<EOT
    $('.boton').click(function (event) {
        var el = $(this);
        var id = el.data('key');
        $.ajax({
            url: '$url',
            data: { id: id },
            success: function (data) {
                $('#boton-' + id).text(`Mover (` + data +` movimientos)`);
                el.attr('disabled', true);
            }
        });
    });
EOT;
$this->registerJs($js);
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
    <div class="media-left text-center">
        <?= Html::button('Mover (' .Html::encode($model->movimiento) . ' movimientos)', ['class' => 'btn-primary boton boton', 'id' => 'boton-' . $model->id, 'data-key' => $model->id]) ?>
           <?= Html::a('Comentarios',
                ['comentarios/ver','id'=> $model->id],
                ['class' => 'btn btn-primary']) ?>

        <?= Html::a(Html::encode($model->categoria->categoria),
                ['noticias/index', 'NoticiasSearch[categoria_id]' => $model->categoria_id],
                ['class' => 'btn btn-primary'])
         ?>
    </div>
</div>
