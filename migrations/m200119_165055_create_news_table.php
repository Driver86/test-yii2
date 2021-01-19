<?php

use yii\db\Migration;

class m200119_165055_create_news_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'categoryId' => $this->integer()->unsigned()->notNull(),
            'title' => $this->string(255)->notNull(),
            'text' => $this->text()->notNull(),
        ]);

        $this->addForeignKey('fk_news_to_category', 'news', 'categoryId', 'category', 'id');
    }
}
