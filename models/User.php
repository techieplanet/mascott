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
 * @property string $designation
 * @property string $email
 * @property string $phone
 * @property string $salt
 * @property string $password
 * @property string $access_token
 * @property integer $role_id
 * @property integer $deleted
 * @property string $created_date
 * @property integer $created_by
 * @property string $modified_date
 * @property integer $modified_by
 *
 * @property Role $role
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
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
            [['firstname', 'middlename', 'lastname', 'designation', 'email', 'phone' , 'role_id'], 'required'],
            [['role_id', 'deleted', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['firstname', 'middlename', 'lastname', 'designation'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 11],
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
            'firstname' => 'Firstname',
            'middlename' => 'Middlename',
            'lastname' => 'Lastname',
            'designation' => 'Designation',
            'email' => 'Email',
            'phone' => 'Phone',
            'salt' => 'Salt',
            'password' => 'Password',
            'access_token' => 'Access Token',
            'role_id' => 'Role ID',
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
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
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
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
}
