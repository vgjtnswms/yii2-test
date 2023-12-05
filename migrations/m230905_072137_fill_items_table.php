<?php

use yii\db\Migration;

/**
 * Class m230905_072137_insert_items_data
 */
class m230905_072137_fill_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $rows = [];
        
        for ($i = 1; $i <= 400000; $i++) {
            $rows[] = [
                $this->generateRandomString(10, 30), // Генерация случайного текста от 10 до 30 символов
                $this->generateRandomNumber(1, 10), // Генерация случайного числа от 1 до 10
                $this->generateRandomNumber(1, 10000), // Генерация случайного числа от 1 до 10,000
                $this->generateRandomCurrency() // Генерация случайной валюты (EUR или USD)
            ];
        }

        $this->batchInsert(
            'items',
            ['name', 'category', 'price', 'currency'],
            $rows
        );
    }
    
    /**
     * Генерирует случайную строку заданной длины
     * @param int $minLength Минимальная длина строки
     * @param int $maxLength Максимальная длина строки
     * @return string Сгенерированная строка
     */
    private function generateRandomString($minLength, $maxLength)
    {
        $length = rand($minLength, $maxLength);
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    /**
     * Генерирует случайное число.
     * @return int Сгенерированное случайное число
    */
    private function generateRandomNumber($minNumber, $maxNumber)
    {
        return rand($minNumber, $maxNumber);
    }

    /**
     * Генерирует случайную валюту (EUR или USD).
     * @return string Сгенерированная случайная валюта
    */
    private function generateRandomCurrency()
    {
        $currencyOptions = ['EUR', 'USD'];
        return $currencyOptions[array_rand($currencyOptions)];
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230905_072137_fill_items_table cannot be reverted.\n";

        return false;
    }

}
