<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class ActivityLog extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%activity_logs}}';
    }

    public static function log($action, $entityType, $entityId)
    {
        $log = new self();
        $log->user_id = Yii::$app->user->id ?? 0;
        $log->action = $action;
        $log->entity_type = $entityType;
        $log->entity_id = $entityId;
        $log->ip_address = Yii::$app->request->userIP;
        $log->user_agent = Yii::$app->request->userAgent;
        $log->save(false);
    }
}
