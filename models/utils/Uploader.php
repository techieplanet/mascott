<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\utils;

use yii\base\Model;

/**
 * Description of UploadFile
 *
 * @author Swedge
 */
class Uploader extends Model {
    //put your code here
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $excelFile;
    
    const SCENARIO_IMAGE = 'image';
    const SCENARIO_EXCEL = 'excel';

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxSize' => 2*1024*1024, 'on' => self::SCENARIO_IMAGE],
            [['excelFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, xlsx', 'maxSize' => 2*1024*1024, 'on' => self::SCENARIO_EXCEL],
        ];
    }
    
    public function uploadExcelFile()
    {
        if ($this->validate()) {
            $this->excelFile->saveAs('uploads/' . $this->excelFile->baseName . '.' . $this->excelFile->extension);
            return true;
        } else {
            return false;
        }
    }
}
