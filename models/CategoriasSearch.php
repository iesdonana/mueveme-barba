<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CategoriasSearch represents the model behind the search form of `app\models\Categorias`.
 */
class CategoriasSearch extends Categorias
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['categoria'], 'safe'],
            [['numNoticias'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Categorias::find()
            ->select('categorias.*, count(noticias.id) AS numNoticias')
            ->joinWith('noticias')
            ->groupBy('categorias.id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterHaving([
            'count(noticias.id)' => $this->numNoticias,
        ]);

        $query->andFilterWhere(['ilike', 'categoria', $this->categoria]);

        return $dataProvider;
    }
}
