<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%uploaded_files}}`.
 */
class m230218_144258_create_uploaded_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%uploaded_files}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text(),
            'date_time' => $this->datetime()->defaultExpression('now()'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%uploaded_files}}');
    }
}
