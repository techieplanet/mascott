<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $email
 * @property string $phone
 * @property string $salt
 * @property string $password
 * @property string $access_token
 * @property integer $role_id
 * @property integer $provider_id
 * @property integer $deleted
 * @property string $created_date
 * @property integer $created_by
 * @property string $modified_date
 * @property integer $modified_by
 *
 * @property Role $role
 * 
 * @property string $authKey;
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $tempPass = '';
    //public $permissions = [];
    
    //public $id;
    //public $username;
    //public $password;
    //public $authKey;
    //public $accessToken;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'email', 'phone' , 'role_id', 'provider_id'], 'required'],
            [['role_id', 'provider_id', 'deleted', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date', 'created_by', 'modified_by'], 'safe'],
            [['firstname', 'middlename', 'lastname'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 100],
            [['email'], 'email'],
            [['email'], 'unique'],
            //[['provider_id'], 'integer', 'min'=>1, 'message'=>'{attribute} must select a provider'],
            [['phone'], 'string', 'max' => 11],
            [['phone'], 'match', 'pattern' => '/^[0-9]+$/'],
            [['salt'], 'string', 'max' => 6],
            [['password'], 'string', 'max' => 128],
            [['access_token'], 'string', 'max' => 15],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'First Name',
            'middlename' => 'Middle Name',
            'lastname' => 'Last Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'salt' => 'Salt',
            'password' => 'Password',
            'access_token' => 'Access Token',
            'role_id' => 'Role',
            'provider_id' => 'Provider',
            'deleted' => 'Deleted',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'modified_date' => 'Modified Date',
            'modified_by' => 'Modified By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvider()
    {
        return $this->hasOne(Provider::className(), ['id' => 'provider_id']);
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return User::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return User::findOne(['access_token' => $token]);
    }
    
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->access_token;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
    
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
    
    public function hashPassword($password){
        return Yii::$app->getSecurity()->generatePasswordHash($password);
    }
    
    public static function findByEmail($email){
        return User::find()->where(['email' => $email])->one(); 
    }
    
    public function getMyPermissions(){
        $userPermissions =  User::find()
                ->select(['alias'])
                ->innerJoinWith(['role.roleAcls.permission'])
                ->where(['user.id' => $this->id])
                ->asArray()
                ->all();
        
        $permissions = array_map(function($value){
                                    return $value['alias'];
                       }, $userPermissions);
                       
        return $permissions;
                                
    }
}