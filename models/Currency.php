<?php

namespace app\models;

/**
 * This is the model class for table "currency".
 *
 * @property int $id
 * @property string|null $date
 * @property string|null $currency
 * @property float|null $value
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['value'], 'number'],
            [['currency'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'currency' => 'Currency',
            'value' => 'Value',
        ];
    }
}
