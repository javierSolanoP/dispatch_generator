<?php

namespace App\Http\Controllers\services\main\validate; 

class Validate {

    // Constructor: 
    public function __construct(){}

    // Metodo para validar datos de tipo texto:
    public function validateText(array $array){

        if($array[0]){

            for($i = 0; $i < count($array); $i++){

                $validate = preg_match("/[0-9]/", $array[$i]);

                if(!$validate){
                    // Retornamos la respuesta: 
                    return ['validate' => true];
                }else{
                    // Retornamos el error: 
                    return ['validate' => false, 'error' => "Campo $array[$i]: No debe tener caracteres numericos"];
                }
            }

        }else{

            foreach($array as $value ){

                $validate = preg_match("/[0-9]/", $value);

                if(!$validate){
                    // Retornamos la respuesta: 
                    return['validate' => true];
                }else{
                    // Retornamos el error: 
                    return ['validate' => false, 'error' => "Campo $value: No debe tener caracteres numericos"];
                }

            }

        }
    } 

}

$validate = new Validate;
print_r($validate->validateText(['user' => 'sdf567', 'hello' => 'asdf', 'world' => 'asdfasdf']));