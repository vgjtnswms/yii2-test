<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%items}}`.
 */
class m230905_051830_create_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%items}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(30)->notNull(), // рандомный текст 10-30 символов
            'category' => $this->integer(2)->notNull(), // рандомное число от 1 до 10
            'price' => $this->decimal()->notNull(), // рандомное число от 1 до 10 000
            'currency' => $this->string(3)->notNull(), // EUR или USD
        ]);

        $this->createIndex(
            'idx-items-category',
            'items',
            'category'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%items}}');
    }
}
