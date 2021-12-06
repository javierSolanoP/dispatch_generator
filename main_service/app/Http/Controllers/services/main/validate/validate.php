<?php

namespace App\Http\Controllers\services\main\validate; 

class Validate {

    public static $const = 'Const';

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

    public function validateEmail(array $array){

        if(isset($array[0])){

            for($i = 0; $i < count($array); $i++){

                $validate = filter_var($array[$i], FILTER_VALIDATE_EMAIL);

                if(!$validate){
                    // Retornamos el error: 
                    return ['validate' => false, 'error' => "Campo $array[$i]: No es un email valido"];
                }
            }

            // Retornamos la respuesta: 
            return ['validate' => true];

        }else{

            foreach ($array as $value) {

                $validate = filter_var($value, FILTER_VALIDATE_EMAIL);

                if(!$validate){
                    // Retornamos el error: 
                    return ['validate' => false, 'error' => "Campo $value: No es un email valido"];
                }
                
            }

            // Retornamos la respuesta: 
            return ['validate' => true];

        }
    }

    public function validatePassword($password, $confirmPassword){

        if(!empty($password) && !empty($confirmPassword)){
            
            if($password == $confirmPassword){
                // Retornamos la respuesta: 
                return ['validate' => true];
            }else{
                // Retornamos el error: 
                return ['validate' => false, 'error' => 'No coinciden las contrasenias'];
            }

        }else{
            // Retornamos el error: 
            return ['validate' => false, 'error' => 'No puede haber ningun dato vacio'];
        }
    }

    public function validateHash($hash, $data){

        if(!empty($hash) && !empty($data)){

            $validate = password_verify($data, $hash);
            
            if($validate){
                // Retornamos la respuesta: 
                return ['validate' => true];
            }else{
                // Retornamos el error: 
                return ['validate' => false, 'error' => 'No coincide el hash'];
            }

        }else{
            // Retornamos el error: 
            return ['validate' => false, 'error' => 'No puede haber ningun dato vacio'];
        }
    }
}