<?php

namespace frontend\controllers;

use Yii;
use common\models\RolePermission;
use common\models\Role;
use common\models\Permission;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RolePermissionController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => RolePermission::find()->where(['deleted_at' => null]),
        ]);

        return $this->render('@frontend/views/site/role-permission/index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($role_id, $permission_id)
    {
        return $this->render('@frontend/views/site/role-permission/view', [
            'model' => $this->findModel($role_id, $permission_id),
        ]);
    }

    public function actionCreate()
    {
        $model = new RolePermission();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'role_id' => $model->role_id, 'permission_id' => $model->permission_id]);
        }

        return $this->render('@frontend/views/site/role-permission/create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($role_id, $permission_id)
    {
        $model = $this->findModel($role_id, $permission_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'role_id' => $model->role_id, 'permission_id' => $model->permission_id]);
        }

        return $this->render('@frontend/views/site/role-permission/update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($role_id, $permission_id)
    {
        $model = $this->findModel($role_id, $permission_id);
        $model->deleted_at = date('Y-m-d H:i:s');
        $model->save(false);

        return $this->redirect(['index']);
    }

    protected function findModel($role_id, $permission_id)
    {
        if (($model = RolePermission::findOne(['role_id' => $role_id, 'permission_id' => $permission_id, 'deleted_at' => null])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested role-permission does not exist.');
    }
}
