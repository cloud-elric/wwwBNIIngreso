<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "view_fechas_disponibles".
 *
 * @property string $fch_disponible
 */
class ViewFechasDisponibles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'view_fechas_disponibles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fch_disponible'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fch_disponible' => 'Fch Disponible',
        ];
    }
}
