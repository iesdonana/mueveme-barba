<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NoticiasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="noticias-index">

    <?= $this->render('_search', [
        'model' => $searchModel,
        'listaCategorias' => $listaCategorias,
    ]); ?>

    <p>
        <?= Html::a('Create Noticias', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_smallView', ['model' => $model]);
        },
    ]) ?>
    
</div>
