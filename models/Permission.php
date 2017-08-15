<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permission".
 *
 * @property integer $id
 * @property string $entity
 * @property string $alias
 * @property string $title
 * @property string $description
 * @property integer $weight
 * @property integer $active
 *
 * @property RoleAcl[] $roleAcls
 */
class Permission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'permission';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity', 'alias', 'title', 'description', 'weight', 'active'], 'required'],
            [['weight', 'active'], 'integer'],
            [['entity'], 'string', 'max' => 50],
            [['alias'], 'string', 'max' => 60],
            [['title'], 'string', 'max' => 60],
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
            'entity' => 'Entity',
            'alias' => 'Alias',
            'title' => 'Title',
            'description' => 'Description',
            'weight' => 'Weight',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoleAcls()
    {
        return $this->hasMany(RoleAcl::className(), ['permission_id' => 'id']);
    }
    
    /*
     * get the users that have this permission 
     */
    public function getMyUsers(){
        return User::find()
                ->innerJoinWith(['role', 'role.roleAcls'])
                ->where(['permission_id'=>$this->id])
                ->all();
    }
}
