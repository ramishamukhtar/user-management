<?php
namespace common\models;

use yii\db\ActiveRecord;

class Role extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%roles}}';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['deleted_at'], 'safe'],
            [['name'], 'string', 'max' => 50],
        ];
    }
}
