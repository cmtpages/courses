<?php  if (! defined('BASEPATH')) {
     exit('No direct script access allowed');
 }

 
if (! function_exists('debug')) {
    function debug($val) {
		echo '<pre>';
		print_r($val);
		echo  '</pre>';
    }       
}
