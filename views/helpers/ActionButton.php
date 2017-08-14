<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ActionButton
 *
 * @author Swedge
 */

namespace app\views\helpers;

use yii\helpers\Html;

class ActionButton {
    //put your code here    
    public static function updateButton($entity, $id){
        return Html::a(
                '<i class="glyphicon glyphicon-pencil" aria-hidden="true"></i>', 
                [$entity.'/update/', 'id' => $id], 
                ['class' => '']
               );
    }
    
    public static function deleteButton($entity, $id){
        return Html::a(
                        '<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>',
                        [$entity.'/delete/', 'id' => $id],
                        [   
                            'data-method' => 'post', 
                            'data-confirm' => 'Are you sure you want to delete this item?',
                            'aria-label' => 'Delete',
                            'title' => 'Delete',
                            'data-pjax' => '0'
                         ]
                        );
    }       
    
    
}
