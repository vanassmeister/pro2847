<?php

namespace app\controllers;

use Yii;
use app\models\Payment;
use app\models\PaymentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Exception;

/**
 * PaymentController implements the CRUD actions for Payment model.
 */
class PaymentController extends Controller
{
    /**
     * @inheritdoc
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],             
        ];
    }

    /**
     * Lists all Payment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Payment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Payment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Payment();

        if ($model->load(Yii::$app->request->post())) {
            
            $payer = Yii::$app->user->identity;
            $model->payer_id = $payer->id;            
            
            $recipient = $model->recipient;
            
            $transaction = Yii::$app->db->beginTransaction();
            try {
                
                if(!$model->save()) {
                    throw new Exception('Невозможно сохранить платеж');
                }
                
                $payer->balance -= $model->amount;
                $recipient->balance += $model->amount;
                
                if(!$payer->save(true, ['balance'])) {
                    throw new Exception('Невозможно сохранить баланс плательщика');
                }

                if(!$recipient->save(true, ['balance'])) {
                    throw new Exception('Невозможно сохранить баланс получателя');
                }
                
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
                
            } catch (Exception $ex) {
                Yii::error($ex->getMessage());
                $transaction->rollBack();
            }
        } 
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Payment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
