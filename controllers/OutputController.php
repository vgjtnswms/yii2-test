<?php

namespace app\controllers;

use \yii\db\Query;
use \app\models\Item;
use \app\models\Currency;

class OutputController extends \yii\web\Controller
{
    /**
     * Выборка из базы данных с вычислением значения в рублях на уровне БД.
     * @return Response formatted as JSON
     */
    public function actionVariant1()
    {
        $items = (new Query())
            ->select([
                'items.name',
                'items.category',
                'items.price',
                'items.currency',
                '(items.price * currency.value) AS priceRUB',
                'currency.date AS dateCurrency'
            ])
            ->from('items')
            ->leftJoin('currency', 'items.currency = currency.currency AND currency.date = (SELECT MAX(date) FROM currency WHERE currency.currency = items.currency)')
            ->where(['items.category' => 3])
            ->orderBy(['items.id' => SORT_DESC])
            ->limit(10)
            ->all();

        // Время выполнения с момента запуска Yii
        $executionTime = \Yii::getLogger()->getElapsedTime();

        $result = [
            'time' => $executionTime,
            'result' => $items
        ];

        return $this->asJson($result);
    }

    /**
     * Выборка сформированная на основе отдельных запросов.
     * @return Response formatted as JSON
     */
    public function actionVariant2()
    {   
        $items = Item::find()
            ->select(['name', 'category', 'price', 'currency'])
            ->where(['category' => 3])
            ->limit(10)
            ->all();

        $subquery = (new \yii\db\Query())
            ->select(['currency', 'MAX(date) as max_date'])
            ->from('currency')
            ->groupBy('currency');

        $currencies = Currency::find()
            ->select(['c.date', 'c.currency', 'c.value'])
            ->from(['c' => 'currency'])
            ->innerJoin(['s' => $subquery], 'c.currency = s.currency AND c.date = s.max_date')
            ->all();

        $currencyValues = [];
        foreach ($currencies as $currency) {
            $currencyValues[$currency['currency']] = [
                'value' => $currency['value'],
                'date' => $currency['date'],
            ];
        }

        $resultItems = [];
        foreach ($items as $item) {
            $resultItem = $item->toArray();
            $resultItem['priceRUB'] = isset($currencyValues[$resultItem['currency']]['value']) ? $resultItem['price'] * $currencyValues[$resultItem['currency']]['value'] : null;
            $resultItem['dateСurrency'] = $currencyValues[$resultItem['currency']]['date'] ?? null;
            $resultItems[] = $resultItem;
        }

        // Время выполнения с момента запуска Yii
        $executionTime = \Yii::getLogger()->getElapsedTime();
        
        $result = [
            'time' => $executionTime,
            'result' => $resultItems
        ];

        return $this->asJson($result);
    }

}
