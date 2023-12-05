<?php

use yii\db\Migration;

/**
 * Class m230905_082248_fill_currency_table
 */
class m230905_082248_fill_currency_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $startDate = strtotime('2022-01-01');
        $endDate = strtotime('2023-07-01');
        $currencyOptions = ['EUR', 'USD'];
        $rows = [];

        for ($date = $startDate; $date <= $endDate; $date += 86400) { // 86400 секунд в дне
            foreach ($currencyOptions as $currency) {
                $rows[] = [
                    date('Y-m-d', $date), // Дата
                    $currency, // Валюта (EUR или USD)
                    rand(10, 100) // Генерация случайного числа от 10 до 100
                ];
            }
        }

        $this->batchInsert(
            'currency',
            ['date', 'currency', 'value'],
            $rows
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230905_082248_fill_currency_table cannot be reverted.\n";

        return false;
    }

}
