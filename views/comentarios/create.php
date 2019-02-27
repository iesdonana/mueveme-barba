<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Comentarios */

$this->title = 'Comentar una noticia';
//$this->params['breadcrumbs'][] = ['label' => '', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$model->noticia_id = 1;
?>
<div class="comentarios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
