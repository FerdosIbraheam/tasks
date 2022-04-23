<?php
require 'dbClass.php';
require 'validatorClass.php';

class blog{
    var $title;
    var $content;


    public function create($input)
    {
      $validator=new validator;
      $this->title=$validator->clean($input['title']);
      $this->content=$validator->clean($input['content']);

      $Errors=[];
      $result = null;
      if(!$validator->validate($this->title,'required')){
        $Errors['title']="field Required"; 
        
       }
       
       if(!$validator->validate($this->content,'required')){
           $Errors['content']="field Required";
       }elseif(!$validator->validate($this->content,'min')){
           $Errors['content']="length must be >=6 chars";   
       }


       if(!$validator->validate($_FILES['image']['name'],'required')){
        $Errors['image']="field Required";
    }elseif(!$validator->validate($_FILES,'image')){
        $Errors['image']="invalid extention";   
    }


       if(count($Errors)>0){
        $result=$Errors;
       }else{

        $typeInfo=explode('/',$_FILES['image']['type']);
        $extention=strtolower(end($typeInfo));
        $FinalName=uniqid().'.'.$extention;
        $dispath='uploads/'.$FinalName;
        $tempath=$_FILES['image']['tmp_name'];
        if(move_uploaded_file($tempath,$dispath))
        {
            $sql = "insert into blog (title,content,image) values ('$this->title','$this->content','$FinalName')";
            $dbObj = new db; 

            $op = $dbObj->doQuery($sql);
            
            if($op){
                $result = ["success" => "Raw Inserted"];
            }else{
    
                $result = ["error" => "Error Try Again"];
            }

        }
        return $result; 
        
       }

    }


    public function show()
    {

        # DB OBJ ... 
        $dbObj = new db;

        # QUERY .... 
        $sql = "select * from blog";

        $op = $dbObj->doQuery($sql);

        return $op;
    }





    

    

    public function delete()
    {
          $id=$_GET['id'];

        # DB OBJ ... 
        $dbObj = new db;

        # QUERY .... 
        $sql = "delete from blog where id=$id";

        $op = $dbObj->doQuery($sql);

        return $op;
    }


  
    



}







?>