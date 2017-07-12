<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "complaint".
 *
 * @property string $id
 * @property string $report_id
 * @property string $validation_result
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property UsageReport $report
 */
class Complaint extends \yii\db\ActiveRecord
{
    const UNRESOLVED = 'UNRESOLVED';
    const CONFIRMED = 'TRUE';
    const UNCONFIRMED = 'FALSE';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'complaint';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['report_id', 'validation_result'], 'required'],
            [['report_id', 'validation_result', 'created_by', 'modified_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['report_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsageReport::className(), 'targetAttribute' => ['report_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'report_id' => 'Report ID',
            'validation_result' => 'Validation Result',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReport()
    {
        return $this->hasOne(UsageReport::className(), ['id' => 'report_id']);
    }
    
    
    
     public function getResultAsText(){
        switch($this->validation_result){
            case 1: return self::CONFIRMED;
            case 2: return self::UNCONFIRMED;
            case 3: return self::UNRESOLVED;
        }
    }
    
    public function getComplaintStatuses(){
        return [
            1 => self::CONFIRMED,
            2 => self::UNCONFIRMED,
            3 => self::UNRESOLVED
         ];
    }
}
