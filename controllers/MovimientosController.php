<?php

namespace app\controllers;

use app\models\Movimientos;
use app\models\Noticias;
use Yii;

class MovimientosController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate($id)
    {
        $usuario_id = Yii::$app->user->identity->id;

        $movimiento = Movimientos::find()
            ->where([
                'noticia_id' => $id,
                'usuario_id' => $usuario_id,
            ])->one();

        if ($movimiento) {
            Yii::$app->session->setFlash('success', 'Solo puede votar una vez');
            return $this->redirect(['/noticias/index']);
        }
        $movimiento = new Movimientos([
                'usuario_id' => $usuario_id,
                'noticia_id' => $id,
            ]);

        $noticia = Noticias::findOne(['id' => $id]);
        $noticia->movimiento++;


        if (!$movimiento->save() & !$noticia->save()) {
            Yii::$app->session->setFlash('error', 'No se ha podido registrar su movimiento');
        }
        return $noticia->movimiento;
    }
}
