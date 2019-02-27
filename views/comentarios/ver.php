<?php
use app\helpers\BuscaImagen;
use app\helpers\DomainExtractor;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Movimientos;
use app\models\Comentarios;
use yii\web\View;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NoticiasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = $model->titulo;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style media="screen">
    .all-coments li {
        list-style:none;
        border: 1px solid white;
        background-color: #fff5ed;
    }
</style>
<div class="noticias-index">
    <div class="">
        <?= $this->render('../noticias/_smallView', ['model' => $model]) ?>
    </div>

    <div class="all-coments">
        <?php
        pintarComentarios($comentarios, $this);

        function pintarComentarios($comentarios, $vista)
        {
        ?>
        <?php if ($comentarios) : ?>
            <ul>
            <?php foreach ($comentarios as $comentario) : ?>
                <li>
                    <?= $vista->render('_smallView',[
                        'model' => $comentario
                        ]) ?>
                    <?php pintarComentarios($comentario->comentarios, $vista)?>
                </li>
            <?php endforeach ?>
            </ul>
        <?php endif;
        }
        ?>
    </div>

    <?= Html::a('Comentar', ['comentarios/create', 'noticia_id' => $model->id], ['class' => 'btn btn-primary']) ?>
</div>
