<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NoticiasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Noticias', 'url' => ['ver']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="noticias-index">

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_smallView', ['model' => $model]);
        },
    ]) ?>
</div>
