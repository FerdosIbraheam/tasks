<?php 

function Clean($input)
{

    return stripslashes(strip_tags(trim($input)));
}



function validate($input, $flag,$length = 6)
{

    $status = true;

    switch ($flag) {
        case 'required':
           
            if (empty($input)) {
                $status = false;
            }
            break;

        case 'email':
            # code ... 
            if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                $status = false;
            }
            break;

        case 'int':
            # code ... 
            if (!filter_var($input, FILTER_VALIDATE_INT)) {
                $status = false;
            }
            break;



        case 'min':
            # code ... 
            if (strlen($input) < $length) {
                $status = false;
            }
            break;


        case 'phone':
            # code ... 
            if (!preg_match('/^01[0-2,5][0-9]{8}$/', $input)) {
                $status = false;
            }
            break;

            case 'number':
                # code ... 
                if (!preg_match('/^[0-9]{1,3}$/', $input)) {
                    $status = false;
                }
                break;
                case 'carnumber':
                    # code ... 
                    if (!preg_match('/^[0-9]{1,6}$/', $input)) {
                        $status = false;
                    }
                    break;

                case 'bool':
                    # code ... 
                    if (!preg_match('/^[0-1]$/', $input)) {
                        $status = false;
                    }
                    break;

                    case 'num':
                        # code ... 
                        if (!preg_match('/^[0-9]{14}$/', $input)) {
                            $status = false;
                        }
                        break;
               
                        # code ... 
                 

        case 'image':
            # Case 

            $typesInfo  =  explode('/', $input['image']['type']);   // convert string to array ... 
            $extension  =  strtolower(end($typesInfo));      // get last element in array .... 

            $allowedExtension = ['png', 'jpeg', 'jpg'];   // allowed Extension    // PNG JPG 

            if (!in_array($extension, $allowedExtension)) {

                $status = false;
            }

            break; 



          case 'date': 
                    
            $date = explode('-',$input); 
             
            if(!checkdate( $date[1],$date[2],$date[0])){
               $status = false; 
            }
            
            break;   


            case 'DateNext': 
                    if(time() > strtotime($input)){
                       $status = false;    
                    }
                break;
                case 'time':
                    if(!preg_match("/^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$/", $input))
                    {
                        $status=false;
                    }
                    break;

          /*
             01  0 - 8 
             01  1 - 8 
             01  2 - 8 
             01  5 - 8
          */



    }

    return $status;
}



   
function isgreater($input1,$input2)
{
    if(strtotime($input1)>strtotime($input2))
    {
        return true;
    }
    else{
        return false;
    }
}

function Messages($text = null )
{
    if (isset($_SESSION['Message'])) {
        foreach ($_SESSION['Message'] as $key => $value) {
            echo ' * ' . $key . ' : ' . $value . '<br>';
        }

        unset($_SESSION['Message']);
    }else{
        echo '  <li class="breadcrumb-item active">'.$text.'</li>';  
    }
}






function removeFile($file){
   
    if(unlink('uploads/'.$file)){
        $status = true;
    } else{
        $status = false; 
    }

    return $status;
}



function url($input){

    return 'http://'.$_SERVER['HTTP_HOST'].'/parking/Admin/'.$input; 
}

############################################################################################################### 



?>