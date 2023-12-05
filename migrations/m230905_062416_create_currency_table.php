<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%currency}}`.
 */
class m230905_062416_create_currency_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%currency}}', [
            'id' => $this->primaryKey(),
            'date' => $this->date()->notNull(), // дата
            'currency' => $this->string(3)->notNull(), // валюта, EUR или USD
            'value' => $this->decimal()->notNull(), // рандомное число в диапазоне от 10 до 100
        ]);

        $this->createIndex(
            'idx-currency-date',
            'currency',
            'date'
        );

        $this->createIndex(
            'idx-currency-currency',
            'currency',
            'currency'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%currency}}');
    }
}
