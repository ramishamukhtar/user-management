<?php

namespace tests\unit;

use common\models\ActivityLog;
use Yii;

class ActivityLogTest extends \Codeception\Test\Unit
{
    public function testLogCreatesRecord()
    {
        // Act
        ActivityLog::log('test_action', 'TestEntity', 123);

        // Assert
        $log = ActivityLog::find()->where(['action' => 'test_action'])->one();
        $this->assertNotNull($log);
        $this->assertEquals('TestEntity', $log->entity_type);
        $this->assertEquals(123, $log->entity_id);
    }
}
