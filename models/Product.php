<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $product_name
 * @property integer $product_type
 * @property string $dosage_form
 * @property integer $certificate_holder
 * @property integer $production_country
 * @property string $brand_name
 * @property string $generic_name
 * @property string $nrn
 * @property string $manufacturing_date
 * @property string $expiry_date
 * @property integer $mas_code_assigned
 * @property integer $mas_code_status
 * @property string $batch_number
 * @property integer $provider_id
 *
 * @property Batch[] $batches
 * @property Country $productionCountry
 * @property Hcr $certificateHolder
 * @property Provider $provider
 * @property ProductType $productType
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_name', 'product_type', 'dosage_form', 'certificate_holder', 'production_country', 'brand_name', 'generic_name', 'nrn', 'manufacturing_date', 'expiry_date', 'mas_code_assigned', 'mas_code_status', 'batch_number', 'provider_id'], 'required'],
            [['product_type', 'certificate_holder', 'production_country', 'mas_code_assigned', 'mas_code_status', 'provider_id'], 'integer'],
            [['manufacturing_date', 'expiry_date'], 'safe'],
            [['product_name', 'dosage_form', 'generic_name'], 'string', 'max' => 100],
            [['brand_name'], 'string', 'max' => 50],
            [['nrn', 'batch_number'], 'string', 'max' => 10],
            [['production_country'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['production_country' => 'id']],
            [['certificate_holder'], 'exist', 'skipOnError' => true, 'targetClass' => Hcr::className(), 'targetAttribute' => ['certificate_holder' => 'id']],
            [['provider_id'], 'exist', 'skipOnError' => true, 'targetClass' => Provider::className(), 'targetAttribute' => ['provider_id' => 'id']],
            [['product_type'], 'exist', 'skipOnError' => true, 'targetClass' => ProductType::className(), 'targetAttribute' => ['product_type' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_name' => 'Product Name',
            'product_type' => 'Product Type',
            'dosage_form' => 'Dosage Form',
            'certificate_holder' => 'Certificate Holder',
            'production_country' => 'Production Country',
            'brand_name' => 'Brand Name',
            'generic_name' => 'Generic Name',
            'nrn' => 'NAFDAC Reg. Number',
            'manufacturing_date' => 'Manufacturing Date',
            'expiry_date' => 'Expiry Date',
            'mas_code_assigned' => 'Mas Code Assigned',
            'mas_code_status' => 'Mas Code Status',
            'batch_number' => 'Batch Number',
            'provider_id' => 'MAS Provider',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBatches()
    {
        return $this->hasMany(Batch::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductionCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'production_country']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCertificateHolder()
    {
        return $this->hasOne(Hcr::className(), ['id' => 'certificate_holder']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvider()
    {
        return $this->hasOne(Provider::className(), ['id' => 'provider_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductType()
    {
        return $this->hasOne(ProductType::className(), ['id' => 'product_type']);
    }
}
