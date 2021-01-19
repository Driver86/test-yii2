<?php

use yii\db\Migration;

class m200119_165050_create_category_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'title' => $this->string(255)->notNull(),
            'left' => $this->integer()->unsigned()->notNull(),
            'right' => $this->integer()->unsigned()->notNull(),
            'root' => $this->integer()->unsigned()->notNull(),
            'level' => $this->integer()->unsigned()->notNull(),
        ]);
        $this->createIndex('left', 'category', 'left');
        $this->createIndex('right', 'category', 'right');
        $this->createIndex('root', 'category', 'root');
        $this->createIndex('level', 'category', 'level');
    }
}
