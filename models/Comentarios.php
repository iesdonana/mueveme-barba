<?php

namespace app\models;

/**
 * This is the model class for table "comentarios".
 *
 * @property int $id
 * @property string $cuerpo
 * @property string $created_at
 * @property int $noticia_id
 * @property int $padre_id
 * @property int $usuario_id
 *
 * @property Comentarios $padre
 * @property Comentarios[] $comentarios
 * @property Noticias $noticia
 * @property Usuarios $usuario
 */
class Comentarios extends \yii\db\ActiveRecord
{
    public $_positivos;
    public $_negativos;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cuerpo'], 'string'],
            [['created_at'], 'safe'],
            [['noticia_id', 'usuario_id'], 'required'],
            [['noticia_id', 'padre_id', 'usuario_id'], 'default', 'value' => null],
            [['noticia_id', 'padre_id', 'usuario_id'], 'integer'],
            [['padre_id'], 'exist', 'skipOnError' => true, 'targetClass' => self::className(), 'targetAttribute' => ['padre_id' => 'id']],
            [['noticia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Noticias::className(), 'targetAttribute' => ['noticia_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cuerpo' => 'Cuerpo',
            'created_at' => 'Created At',
            'noticia_id' => 'Noticia ID',
            'padre_id' => 'Padre ID',
            'positivos' => 'Votos positivos',
            'negativos' => 'Votos negativos',
            'usuario_id' => 'Usuario ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPadre()
    {
        return $this->hasOne(self::className(), ['id' => 'padre_id'])->inverseOf('comentarios');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(self::className(), ['padre_id' => 'id'])->inverseOf('padre');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoticia()
    {
        return $this->hasOne(Noticias::className(), ['id' => 'noticia_id'])->inverseOf('comentarios');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('comentarios');
    }

    public function getPositivos()
    {
        return $this->_positivos;
    }
    public function getNegativos()
    {
        return $this->_negativos;
    }
}
