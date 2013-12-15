<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


if ( ! function_exists('convert_db_result_to_dropdown'))
{
    function convert_db_result_to_dropdown($db_result,$key_name,$value_name)
    {
        $result=array();
       
        if (isset($db_result)):
            foreach ($db_result as $db_item):
                $result[$db_item[$key_name]]=$db_item[$value_name];
            endforeach;
        endif;
        return $result;
    }    
}
