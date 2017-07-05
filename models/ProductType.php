<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_type".
 *
 * @property integer $id
 * @property string $title
 *
 * @property Product[] $products
 */
class ProductType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 50],
            [['title'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['product_type' => 'id']);
    }
    
    public static function getProductTypesAsAssocArray(){
        return ProductType::find()->asArray()->all();
    }
}
