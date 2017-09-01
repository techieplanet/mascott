<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provider".
 *
 * @property integer $id
 * @property string $provider_name
 * @property string $street
 * @property string $city
 * @property string $state
 * @property string $contact_person
 * @property string $contact_phone
 * @property string $contact_email
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property Product[] $products
 */
class Provider extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'provider';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provider_name', 'street', 'city', 'state', 'contact_person', 'contact_phone', 'contact_email', 'created_by'], 'required'],
            [['street'], 'string'],
            [['created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['provider_name', 'contact_person', 'contact_email'], 'string', 'max' => 100],
            [['contact_email'], 'email'],
            [['contact_email'], 'unique'],
            [['contact_phone'], 'match', 'pattern' => '/^[0-9]+$/'],
            [['contact_phone'], 'string', 'min' => 11],
            [['city', 'state'], 'string', 'max' => 50],
            [['contact_phone'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'provider_name' => 'Provider Name',
            'street' => 'Street',
            'city' => 'City',
            'state' => 'State',
            'contact_person' => 'Contact Person',
            'contact_phone' => 'Contact Phone',
            'contact_email' => 'Contact Email',
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
        return $this->hasMany(Product::className(), ['provider_id' => 'id']);
    }
    
    public static function getProvidersAsAssocArray(){
        $roleConditionArray = Provider::myRoleACL();
        return Provider::find()->where($roleConditionArray)->asArray()->all();
    }
    
    public static function myRoleACL() {
        $userId = Yii::$app->user->id;
        $user = User::find()->with(['role', 'provider'])->where(['id' => $userId])->one();
        
       if(strtoupper($user->role->title) ==  'MAS PROVIDER'){
            return ['id' => $user->provider->id];
       }
       
      return [];
   }
}
