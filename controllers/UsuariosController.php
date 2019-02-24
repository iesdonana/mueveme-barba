<?php

namespace app\controllers;

use app\models\Usuarios;
use app\models\UsuariosSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class UsuariosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Usuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuarios model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuarios(['scenario' => Usuarios::SCENARIO_CREATE]);
        $model->setToken();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->actionEmail($model);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Usuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Usuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionEmail($model)
    {
        $url = Url::to([
            'usuarios/verificar',
            'id' => $model->id,
            'token' => $model->token,
        ], true);
        if (Yii::$app->mailer->compose()
        ->setFrom('BBCphp@gmail.com')
        ->setTo($model->email)
        ->setSubject('Mueveme')
        ->setTextBody("Verifique su correo: $url")
        // ->setHtmlBody('<h1>Esto es una prueba</h1>')
        ->send()) {
            Yii::$app->session->setFlash('success', 'Se ha enviado un correo a su cuenta de email, por favor verifique su cuenta.');
        } else {
            Yii::$app->session->setFlash('error', 'Ha habido un error al mandar el correo.');
        }
        return $this->redirect(['index']);
    }

    public function actionVerificar($id, $token)
    {
        $model = $this->findModel($id);
        if ($model->token === $token) {
            $model->verificado = 's';
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Cuenta verificada, ya puede loguearse.');
            } else {
                Yii::$app->session->setFlash('error', 'Error interno, no se ha podido verificar la cuenta.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Error en la verificacion de la cuenta.');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
