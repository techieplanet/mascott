<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hcr".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property Product[] $products
 */
class HCR extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hcr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'created_by'], 'required'],
            [['created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['name'], 'string', 'max' => 120],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['certificate_holder' => 'id']);
    }
    
    public static function getHCRAsAssocArray(){
        return HCR::find()->asArray()->all();
    }
}
