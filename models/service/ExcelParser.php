<?php

/**
     * Excel file fields
     * A - SN
     * B - Product Name (Good)
     * C - Product Type (Good)
     * D - Dosage form
     * E - NAFDAC Reg Number (Good)
     * F - Country of production
     * G - Brand Name
     * H - Generic Name
     * I - Manu. Date
     * J - Expiry Date
     * K - Batch No. (Good)
     * L - Lats 4 digits of PIN (Good)
     * M - Location of MAS Usage (Good)
     * N - Response Status (Good)
     * N - Response(Genuine)
     * O - Response(Fake)
     * P - Response(Invalid)
     */

namespace app\models\service;

use app\models\Batch;
use app\models\UsageReport;
use app\models\Location;
use app\models\utils\Trailable;
use app\models\Permission;
use app\controllers\services\AlertsService;

/**
 * Description of ExcelParser
 * Used to fetch and parse the usage report excel files
 * Makes use of moonland PHPExcel Yii2 Extension
 *
 * @author Swedge
 */
class ExcelParser {
    //put your code here
    private $_startRow = 10;
    private $_fileName = '';
    private $_rowNumber = 0;
    private $_errors = array();
    
    public function __construct($startRow, $fileName) {
        $this->_startRow = $startRow;
        $this->_fileName = $fileName;
        $this->_rowNumber = $startRow-1;
    }
    
    private function fetchFile($fileName){
        $data = \moonland\phpexcel\Excel::import($fileName, [
                'mode' => 'import',
		'setFirstRecordAsKeys' => false, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel. 
		'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric. 
		'getOnlySheet' => 'sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
	]);
        
        return $data;
    }
    
    public function run(){
        $fileData = $this->fetchFile($this->_fileName);
        $batch = new Batch();
        
        if(!empty($fileData)){
            //chop off the non-content rows 
            for($i = 0; $i < $this->_startRow-1; $i++){
                array_shift($fileData);
            }
            
            foreach($fileData as $row){
                $this->_rowNumber++;
                
                $errorsArray = $this->hasRequiredFields($row);
                if(!empty($errorsArray)){
                    $this->_errors[$this->_rowNumber] = $errorsArray;
                    continue;
                }
                
                //args: product_name, product type title, NRN, batch number
                if(!$batch->hasMatch($row['B'], $row['C'], $row['E'], $row['K'])){
                    $this->_errors[$this->_rowNumber] = 'No matching records found';
                    continue;
                }
            }
            
            //file parse without errors
            if(empty($this->_errors)) { 
                foreach($fileData as $row){
                    if(($createResult = $this->createReport($row)) != true){
                        $this->_errors[$this->_rowNumber] = $createResult;
                    }
                }
            }
                
                
        }//end if fileData
        
        return $this->_errors;
            
    }
    
    private function createReport($row){                
        $model = new UsageReport(); $locationId = 0;
        
        $model->batch_number = $row['K'];
        $model->location_id = Location::find()->where(['UPPER(location_name)' => $row['M']])->one()->id;
        $model->phone = '123456789';
        $model->pin_4_digits = $row['L'] . ''; //convert to string for validation
        $model->date_reported = date('Y-m-d');
        if(strcasecmp($row['N'], 'X') == 0) $model->response = UsageReport::GENUINE_DBVALUE;
        if(strcasecmp($row['O'], 'X') == 0) $model->response = UsageReport::FAKE_DBVALUE;
        if(strcasecmp($row['P'], 'X') == 0) $model->response = UsageReport::INVALID_DBVALUE;

        (new Trailable($model))->registerInsert(); //audit trail
        
        if($model->save()){
            //send email if response is NOT Genuine i.e. fake or invalid
            if($model->getResponseAsText() != UsageReport::GENUINE){
                $permission = Permission::find()->where(['alias'=>'resolution_reminder'])->one();
                $permissionUsers = $permission->getMyUsers();
                (new AlertsService())->sendResolutionRequestEmail($permissionUsers, $model);
            }

            return true;
        } else {
            
            return $model->getErrors();
        }
        return true;
    }
    
    
    /**
     * Check if the row has all the required fields
     * Required Fields: product name, product type, NRN, Batch number, 
     * last 4 digits, location, response
     * 
     * return array (of error messages)
     */
    private function hasRequiredFields($row){
        $errors = array();
        
        if(empty($row['B'])) $errors[] = 'Product name cannot be blank';     //product name
        if(empty($row['C'])) $errors[] = 'Product type cannot be blank';     //product type
        if(empty($row['E'])) $errors[] = 'NAFDAC Reg. number cannot be blank';     //NRN
        if(empty($row['K'])) $errors[] = 'Batch number cannot be blank';     //BAtch number
        if(empty($row['L'])) $errors[] = 'Last 4 digits of PIN cannot be blank';     //last 4 digits
        if(empty($row['M'])) $errors[] = 'Location cannot be blank';     //location
        $location = Location::find()->where(['UPPER(location_name)' => $row['M']])->one();
        if($location == null) $errors[] = 'Location does not exist';
        if(strcasecmp($row['N'], 'X') != 0 && strcasecmp($row['O'], 'X') != 0 && strcasecmp($row['P'], 'X') != 0)
                $errors[] = 'At lease one response type must be selected';
          
        return $errors;
        
    }
    
//    /**
//     * Check if a matching record can be found.
//     */
//    private function hasMatch($row){
//        $obj = Batch::find()
//                ->innerJoinWith(['product', 'product.productType'])
//                ->where([
//                    'product_name' => $row['B'],
//                    'title' => $row['C'],
//                    'nrn' => $row['E'],
//                    'batch_number' => $row['K']
//                ])->one();
//        
//        return is_object($obj);
//    }
}
