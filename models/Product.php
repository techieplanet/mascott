<?php

namespace app\models;

use Yii;
use app\models\reports\ProductReport;

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
 * @property integer $deleted
 * @property string $created_date
 * @property integer $created_by
 * @property string $modified_date
 * @property integer $modified_by
 * 
 * @property Batch[] $batches
 * @property Country $productionCountry
 * @property HCR $certificateHolder
 * @property Provider $provider
 * @property ProductType $productType
 * 
 */
class Product extends \yii\db\ActiveRecord
{
    const SCENARIO_PRODUCT = 'product';
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
            [['product_name', 'product_type', 'dosage_form', 'certificate_holder', 'production_country', 'brand_name', 'generic_name', 'nrn', 'mas_code_assigned', 'mas_code_status', 'provider_id'], 'required'],
            [['product_type', 'certificate_holder', 'production_country', 'mas_code_assigned', 'mas_code_status', 'provider_id'], 'integer'],
            [['deleted', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date', 'created_by', 'modified_by'], 'safe'],
            [['product_name', 'dosage_form', 'generic_name'], 'string', 'max' => 100],
            [['brand_name'], 'string', 'max' => 50],
            [['nrn'], 'string', 'max' => 10],
            [['production_country'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['production_country' => 'id']],
            [['certificate_holder'], 'exist', 'skipOnError' => true, 'targetClass' => HCR::className(), 'targetAttribute' => ['certificate_holder' => 'id']],
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
            'mas_code_assigned' => 'Mas Code Assigned',
            'mas_code_status' => 'Mas Code Status',
            'provider_id' => 'MAS Provider',
            'deleted' => 'Deleted',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'modified_date' => 'Modified Date',
            'modified_by' => 'Modified By'
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
        return $this->hasOne(HCR::className(), ['id' => 'certificate_holder']);
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
    
    public static function getProductsAsAssocArray(){
        return Product::find()->asArray()->all();
    }
    
    public function getUniqueDosageForms(){
        return Product::find()->select('dosage_form')->distinct()->all();
    }
    
    public function getProductReport($filtersArray){
        $pr = new ProductReport();
        $whereArray = $pr->getReportWhereClause($filtersArray);
        return Product::find()
                ->where($whereArray)
                ->with('productType', 'certificateHolder')
                ->asArray()
                ->all();
    }
}