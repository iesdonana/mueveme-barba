<?php

namespace app\models;

/**
 * This is the model class for table "categorias".
 *
 * @property int $id
 * @property string $categoria
 *
 * @property Noticias[] $noticias
 */
class Categorias extends \yii\db\ActiveRecord
{
    public $numNoticias;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categorias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categoria'], 'required'],
            [['categoria'], 'string', 'max' => 255],
            [['categoria'], 'unique'],
            [['numNoticias'], 'safe'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['numNoticias']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'categoria' => 'Categoria',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoticias()
    {
        return $this->hasMany(Noticias::className(), ['categoria_id' => 'id'])->inverseOf('categoria');
    }

    public function afterFind()
    {
        $this->numNoticias = count($this->noticias);
    }

    public function getNumNoticias()
    {
        if (empty($this->_numNoticias)) {
            $this->numNoticias = count($this->noticias);
        }
        return $this->numNoticias;
    }
}
