<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "role".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property User $user
 * @property RoleAcl[] $roleAcls
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['title'], 'string', 'max' => 30],
            [['description'], 'string', 'max' => 250],
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
            'description' => 'Description',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoleAcls()
    {
        return $this->hasMany(RoleAcl::className(), ['role_id' => 'id']);
    }
    
    /**
     * This method gets all permission IDs for a role id
     * @return array of the permission IDs for the role
     */
    public function getPermissionIDs(){
        //unset($this->roleAcls);
        //$accessList = $this->roleAcls->with('permission');
        $permissionsList = Permission::getPermissionsByRole($this->id);
        $permissionIdList = array();
        foreach($permissionsList as $permission){
            $permissionIdList[] = $permission->id;
        }
        
        return $permissionIdList;
    }
    
    public static function getRolesAsAssocArray(){
        return Role::find()->asArray()->all();
    }
}
