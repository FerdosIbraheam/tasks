<?php
class Validator{
 function clean($input){

     return stripslashes(strip_tags(trim($input)));

 }

 function validate($input,$flag,$length=6)
 {
$status=true;
switch($flag){


    case'required':
        if(empty($input)){
            $status=false;

        }
        break;
    case 'min':
        if(strlen($input)<$length){
            $status=false;
        } 
        break; 
    case 'image':
        $typesInfo=explode('/',$input['image']['type']);
        $extension=strtolower(end($typesInfo));
        $allowExtension=['png','jpeg','jpg'];
        if(!in_array($extension,$allowExtension)){
            $status=false;
        }  
        break;    


 }
 return $status;

}

}


?>