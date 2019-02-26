<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Usuarios', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'email:email',
            // 'created_at:datetime',
            'baneado:boolean',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {ban}',
                'buttons' => [
                    'ban' => function ($url, $model, $key) {
                        return Html::a(
                            'Banear',
                            ['usuarios/banear', 'id' => $model->id],
                            [
                                'data-method' => 'POST',
                                'data-confirm' => '¿Seguro que desea banear a ese usuario?'
                            ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
