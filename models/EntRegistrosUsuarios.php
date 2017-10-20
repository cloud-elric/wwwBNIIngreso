<?php

namespace app\models;

use Yii;
use app\modules\ModUsuarios\models\EntUsuarios;

/**
 * This is the model class for table "ent_registros_usuarios".
 *
 * @property string $id_registro_usuario
 * @property string $id_usuario
 * @property string $id_tipo_pago
 * @property string $fch_registro
 *
 * @property ModUsuariosEntUsuarios $idUsuario
 * @property CatTiposPagos $idTipoPago
 */
class EntRegistrosUsuarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_registros_usuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_tipo_pago'], 'required','message'=>'Campo requerido'],
            [['fch_registro'], 'safe'],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => EntUsuarios::className(), 'targetAttribute' => ['id_usuario' => 'id_usuario']],
            [['id_tipo_pago'], 'exist', 'skipOnError' => true, 'targetClass' => CatTiposPagos::className(), 'targetAttribute' => ['id_tipo_pago' => 'id_tipo_pago']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_registro_usuario' => 'Id Registro Usuario',
            'id_usuario' => 'Id Usuario',
            'id_tipo_pago' => 'Tipo de pago',
            'fch_registro' => 'Fch Registro',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario()
    {
        return $this->hasOne(EntUsuarios::className(), ['id_usuario' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoPago()
    {
        return $this->hasOne(CatTiposPagos::className(), ['id_tipo_pago' => 'id_tipo_pago']);
    }
}
