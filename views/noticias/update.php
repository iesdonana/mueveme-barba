<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Noticias */

$this->title = 'Modificar la noticia: ' . $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Noticias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="noticias-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listaCategorias' => $listaCategorias,
    ]) ?>

</div>
