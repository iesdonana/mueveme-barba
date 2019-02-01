<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Noticias */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Noticias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="noticias-view">

    <h1><?= Html::a(Html::encode($this->title), Html::encode($model->noticia)) ?></h1>

    <?php
    $inicio = strpos($model->noticia, "//")+2;
    $fin = strpos($model->noticia, ".", $inicio)-$inicio;
    $str = mb_substr($model->noticia, $inicio, $fin);
    ?>
    <small>por <?= $model->usuario->nombre ?> a <?= Html::a($str, $model->noticia) ?>  </small><br>
    <!-- Falta fecha de noticia -->

    <?= Html::encode($model->cuerpo) ?>


</div>