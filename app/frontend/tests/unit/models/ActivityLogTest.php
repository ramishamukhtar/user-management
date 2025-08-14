<?php

namespace frontend\tests\unit\models;

use common\models\ActivityLog;
use Yii;
use Codeception\Test\Unit;

class ActivityLogTest extends Unit
{
    public function testLogCreatesRecord()
    {
        $beforeCount = ActivityLog::find()->count();

        ActivityLog::log('test_action', 'User', 1);

        $afterCount = ActivityLog::find()->count();

        $this->assertEquals($beforeCount + 1, $afterCount, 'Activity log count should increase by 1');
    }
}
