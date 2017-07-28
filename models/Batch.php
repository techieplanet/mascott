<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "batch".
 *
 * @property integer $id
 * @property string $batch_number
 * @property string $manufacturing_date
 * @property string $expiry_date
 * @property string $quantity
 * @property integer $product_id
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property Product $product
 */
class Batch extends \yii\db\ActiveRecord
{
    const SCENARIO_AJAX = 'ajax';
    const SCENARIO_PRODUCT2 = 'product2';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'batch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['batch_number', 'manufacturing_date', 'expiry_date', 'quantity', 'product_id'], 'safe'],
            [['batch_number', 'manufacturing_date', 'expiry_date', 'quantity', 'product_id'], 'required', 'on' => self::SCENARIO_AJAX],
            [['manufacturing_date', 'expiry_date'], 'date', 'format'=>'php:Y-m-d'],
            [['created_date', 'modified_date'], 'safe'],
            [['quantity', 'product_id', 'created_by', 'modified_by'], 'integer'],
            [['batch_number'], 'string', 'max' => 12],
            [['batch_number'], 'unique', 'message'=>'This batch number already exists'],
            [['quantity'], 'match', 'pattern' => '/^[0-9]+$/'],
            [['quantity'], 'integer', 'min' => 1],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'batch_number' => 'Batch Number',
            'manufacturing_date' => 'Manufacturing Date',
            'expiry_date' => 'Expiry Date',
            'quantity' => 'Quantity',
            'product_id' => 'Product ID',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
    
    /**
     * Get the expiring batches in the system
     * A batch is in this category if it 
     */   
    public function getExpiringBatches($filtersArray){
        $date = date('Y-m-d');
        return Batch::find()
                ->innerJoinWith(['product.productType','product.certificateHolder'])
                ->where("DATEDIFF(expiry_date, '$date') <= 90")
                ->andWhere($filtersArray)
                ->asArray(!empty($filtersArray) ? true : false)
                ->all();
    }
}