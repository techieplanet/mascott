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

use Yii;
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
    private $_startRow = 2;
    private $_fileName = '';
    private $_rowNumber = 0;
    private $_errors = array();
    private $_rowCoreValues = array();
    
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
		'getOnlySheet' => 'MAS REQUEST REPORT FORM', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
	]);
        
        return $data;
    }
    
    public function run(){
        ini_set('max_execution_time', 600);
        ini_set('memory_limit', '2048M');
        
        $fileData = $this->fetchFile($this->_fileName);
        $batch = new Batch();
                
        if(!empty($fileData)){
            //chop off the non-content rows 
            for($i = 0; $i < $this->_startRow-1; $i++){
                array_shift($fileData);
            }
            //var_dump($fileData); exit;
            foreach($fileData as $row){
                $this->_rowNumber++;

                if(empty($row['A'])) continue; //assume the row is not filled with data at all. Just a blank field that excel did not clear
                
                $this->_rowCoreValues = array();
                
                $errorsArray = $this->hasRequiredFields($row);
                if(!empty($errorsArray)){
                    $this->_errors[$this->_rowNumber] = $errorsArray;
                    continue;
                }
                
                //args: product_name, product type title, NRN, batch number
                if(!$batch->hasMatch($this->_rowCoreValues['product_name'], 
                                     $this->_rowCoreValues['product_type'], 
                                     $this->_rowCoreValues['nrn'], 
                                     $this->_rowCoreValues['batch_number'])){
                    $this->_errors[$this->_rowNumber] = array('No matching records found: <br/>' .
                                                            'Product Name: ' . $row['B'] . '<br/>' .
                                                            'Product Type: ' . $row['C'] . '<br/>' .
                                                            'NRN: ' . $row['E'] . '<br/>' .
                                                            'Batch Number: ' . $row['K']
                                                    ); //make array for easy/uniform procesing on view
                    continue;
                }
            }
            
            
            
            //file parsed without errors
            if(empty($this->_errors)) { 
                ///reset($fileData);
                foreach($fileData as $row){
                    if(empty($row['A'])) continue;
                    $createResult = $this->createReport($row);
                    if($createResult !== true){
                        $this->_errors[$this->_rowNumber] = $createResult;
                    }
                }
            }
                
                
        }//end if fileData
        
        return $this->_errors;
            
    }
    
    private function createReport($row){                
        $model = new UsageReport(); $locationId = 0;
        //echo $row['M']; exit;
        $row = array_values($row);
        
        $model->batch_number = $row[10];
        $model->location_id = Location::find()->where([
            'UPPER(location_name)' => strtoupper($row[12])
        ])->one()->id;
        //echo $row[12],'oya1'; exit;
        $model->phone = '12345678901';
        $model->pin_4_digits = $row[11] . ''; //convert to string for validation
        $model->date_reported = date('Y-m-d');
        
        if(strtoupper($row[13]) === UsageReport::GENUINE) 
            $model->response = UsageReport::GENUINE_DBVALUE;
        else if(strtoupper($row[13]) == UsageReport::FAKE) 
            $model->response = UsageReport::FAKE_DBVALUE;
        else if(strtoupper($row[13]) == UsageReport::INVALID) 
            $model->response = UsageReport::INVALID_DBVALUE;
        else 
            $model->response = UsageReport::INVALID_DBVALUE;
        
        //Initial modus
        //if(strcasecmp($row['N'], 'X') == 0) $model->response = UsageReport::GENUINE_DBVALUE;
        //if(strcasecmp($row['O'], 'X') == 0) $model->response = UsageReport::FAKE_DBVALUE;
        //if(strcasecmp($row['P'], 'X') == 0) $model->response = UsageReport::INVALID_DBVALUE;

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
        
        if(empty($row['B'])) $errors[] = 'Product name cannot be blank'; else $this->_rowCoreValues['product_name'] = $row['B'];     //product name
        if(empty($row['C'])) $errors[] = 'Product type cannot be blank'; else $this->_rowCoreValues['product_type'] = $row['C'];    //product type
        if(empty($row['E'])) $errors[] = 'NAFDAC Reg. number cannot be blank'; else $this->_rowCoreValues['nrn'] = $row['E'];    //NRN
        if(empty($row['K'])) $errors[] = 'Batch number cannot be blank'; else $this->_rowCoreValues['batch_number'] = $row['K'];     //BAtch number
        if(empty($row['L'])) $errors[] = 'Last 4 digits of PIN cannot be blank'; else $this->_rowCoreValues['last4digits'] = $row['L'];    //last 4 digits
        if(empty($row['M'])) $errors[] = 'Location cannot be blank';     //location
        $location = Location::find()->where(['UPPER(location_name)' => strtoupper($row['M'])])->one();
        if($location === null) {
            $errors[] = 'Location does not exist'; 
        } else {
            $this->_rowCoreValues['location_name'] = $location->location_name;
            $row['M'] = $location->location_name;
        }
        if(empty($row['N'])) $errors[] = 'At lease one response type must be selected'; else $this->_rowCoreValues['response'] = $row['N'];
        
        //if(strcasecmp($row['N'], 'X') != 0 && strcasecmp($row['O'], 'X') != 0 && strcasecmp($row['P'], 'X') != 0)
          //      $errors[] = 'At lease one response type must be selected';
          
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
