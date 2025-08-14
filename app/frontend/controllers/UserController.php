<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Role;
use common\models\ActivityLog; // <-- Added for logging
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        ActivityLog::log('navigate', 'User', Yii::$app->user->id);
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->with('role')->where(['<>', 'role_id', 1]),
            'pagination' => [
                'pageSize' => 10, // users per page
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        return $this->render('@frontend/views/site/user/index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        ActivityLog::log('navigate', 'User', Yii::$app->user->id);
        return $this->render('@frontend/views/site/user/view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        ActivityLog::log('navigate', 'User', Yii::$app->user->id);
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            $model->setPassword($model->password); // set hashed password
            $model->generateAuthKey(); // generate auth key
            if ($model->role_id) {
                $model->role_id = $model->role_id; // assign role_id from virtual role property
            }
            try {
            if (!$model->save()) {
                ActivityLog::log('create_failed', 'User', null);
                throw new \Exception('Failed to save user. Validation errors: ' . json_encode($model->errors));
            }
            ActivityLog::log('create_success', 'User', $model->id);
            return $this->redirect(['view', 'id' => $model->id]);
            } catch (\Throwable $e) {
                Yii::error($e->getMessage(), __METHOD__);
                ActivityLog::log('create_error', 'User', null);
                Yii::$app->session->setFlash('error', 'An unexpected error occurred while creating the user.');
            }
        }

        return $this->render('@frontend/views/site/user/create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        ActivityLog::log('navigate', 'User', $id);
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->password)) {
                $model->setPassword($model->password);
            }
            $model->generateAuthKey();
            try {
            if (!$model->save()) {
                ActivityLog::log('update_failed', 'User', $model->id);
                throw new \Exception('Failed to save user. Validation errors: ' . json_encode($model->errors));
            }
            ActivityLog::log('update_success', 'User', $model->id);
            return $this->redirect(['view', 'id' => $model->id]);
            } catch (\Throwable $e) {
                ActivityLog::log('update_error', 'User', $model->id);
                Yii::error($e->getMessage(), __METHOD__);
                Yii::$app->session->setFlash('error', 'An unexpected error occurred while creating the user.');
            }
        }

        return $this->render('@frontend/views/site/user/update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        try {
            $model = $this->findModel($id);
            if ($model->delete() !== false) {
                ActivityLog::log('delete_success', 'User', $id);
            } else {
                ActivityLog::log('delete_failed', 'User', $id);
            }
        } catch (\Throwable $e) {
            Yii::error($e->getMessage(), __METHOD__);
            ActivityLog::log('delete_error', 'User', $id);
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = User::find()->with('role')->where(['id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
}
