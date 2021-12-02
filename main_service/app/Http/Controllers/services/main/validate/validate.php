<?php

namespace App\Http\Controllers\services\main\validate; 

class Validate {

    // Constructor: 
    public function __construct(){}

    // Metodo para validar datos de tipo texto:
    public function validateText(array $array){

        if(isset($array[0])){

            for($i = 0; $i < count($array); $i++){

                $validate = preg_match("/[0-9]/", $array[$i]);

                if($validate){

                    // Retornamos el error: 
                    return ['validate' => false, 'error' => "Campo $array[$i]: No debe tener caracteres numericos"];

                }
            }

            // Retornamos la respuesta: 
            return ['validate' => true];

        }else{

            foreach($array as $value ){

                $validate = preg_match("/[0-9]/", $value);

                if($validate){

                    // Retornamos el error: 
                    return ['validate' => false, 'error' => "Campo $value: No debe tener caracteres numericos"];
                   
                }
            }

            // Retornamos la respuesta: 
            return['validate' => true];

        }
    } 

    // Metodo para validar datos de tipo texto:
    public function validateNumber(array $array){

        if(isset($array[0])){

            for($i = 0; $i < count($array); $i++){

                $validate = preg_match("/[a-zA-Z]/", $array[$i]);

                if($validate){

                    // Retornamos el error: 
                    return ['validate' => false, 'error' => "Campo $array[$i]: No debe tener caracteres alfanumericos"];

                }
            }

            // Retornamos la respuesta: 
            return ['validate' => true];

        }else{

            foreach($array as $value ){

                $validate = preg_match("/[a-zA-Z]/", $value);

                if($validate){

                    // Retornamos el error: 
                    return ['validate' => false, 'error' => "Campo $value: No debe tener caracteres alfanumericos"];
                   
                }
            }

            // Retornamos la respuesta: 
            return['validate' => true];

        }
    } 

}