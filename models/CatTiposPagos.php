<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_tipos_pagos".
 *
 * @property string $id_tipo_pago
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property string $b_habilitado
 *
 * @property EntRegistrosUsuarios[] $entRegistrosUsuarios
 */
class CatTiposPagos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_tipos_pagos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre'], 'required'],
            [['b_habilitado'], 'integer'],
            [['txt_nombre', 'txt_descripcion'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_pago' => 'Id Tipo Pago',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntRegistrosUsuarios()
    {
        return $this->hasMany(EntRegistrosUsuarios::className(), ['id_tipo_pago' => 'id_tipo_pago']);
    }
}
