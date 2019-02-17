<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NoticiasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = $model->titulo;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="noticias-index">
    <div class="">
        <?= $this->render('../noticias/_smallView', ['model' => $model]) ?>
    </div>

    <div class="">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('_smallView', ['model' => $model]);
            },
        ]) ?>
    </div>

    <?= Html::a('Comentar', ['comentarios/create', 'pelicula_id' => $model->id], ['class' => 'btn btn-primary']) ?>
</div>
