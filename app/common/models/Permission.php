<?php
namespace common\models;

use yii\db\ActiveRecord;

class Permission extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%permissions}}';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id'], 'integer'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['deleted_at'], 'safe'],
            [['name', 'route'], 'string', 'max' => 255],
        ];
    }
}
