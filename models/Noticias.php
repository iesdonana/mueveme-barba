<?php

namespace app\models;

/**
 * This is the model class for table "noticias".
 *
 * @property int $id
 * @property string $titulo
 * @property string $noticia
 * @property string $cuerpo
 * @property string $created_at
 * @property int $movimiento
 * @property int $categoria_id
 * @property int $usuario_id
 *
 * @property Comentarios[] $comentarios
 * @property Categorias $categoria
 * @property Usuarios $usuario
 */
class Noticias extends \yii\db\ActiveRecord
{
    public $imagen;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'noticias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'noticia', 'categoria_id', 'usuario_id'], 'required'],
            [['noticia'], 'url'],
            [['cuerpo'], 'string'],
            [['created_at'], 'safe'],
            [['movimiento', 'categoria_id', 'usuario_id'], 'default', 'value' => null],
            [['movimiento', 'categoria_id', 'usuario_id'], 'integer'],
            [['titulo', 'noticia'], 'string', 'max' => 255],
            [['noticia'], 'unique'],
            [['imagen'], 'file', 'extensions' => 'jpg'],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::className(), 'targetAttribute' => ['categoria_id' => 'id']],
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
            'titulo' => 'Titulo',
            'noticia' => 'Noticia',
            'cuerpo' => 'Cuerpo',
            'created_at' => 'Created At',
            'movimiento' => 'Movimiento',
            'categoria_id' => 'Categoria ID',
            'usuario_id' => 'Usuario ID',
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['imagen']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentarios::className(), ['noticia_id' => 'id'])->inverseOf('noticia');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categorias::className(), ['id' => 'categoria_id'])->inverseOf('noticias');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMovimiento()
    {
        return $this->hasMany(Movimientos::className(), ['noticia_id' => 'id'])->inverseOf('noticia');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('noticias');
    }

    /**
     * Devuelve la URL de la imagen de la noticia.
     * @return ?string La URL de la noticia, o null si no tiene
     */
    public function getUrlImagen()
    {
        return $this->tieneImagen() ? Yii::getAlias('@uploadsUrl/' . $this->id . '.jpg') : null;
    }
    public function tieneImagen()
    {
        //return file_exists(Yii::getAlias('@uploads/' . $this->id . '.jpg'));
    }
}
