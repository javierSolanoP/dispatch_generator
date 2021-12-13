<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
session_start();

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Inicializamos la propiedad que define la autorizacion de una peticion: 
    protected $authorization = false;
    
    // Metodo para validar permisos: 
    public function validatePermission($permissions, string $key)
    {
        // Iteramos la matriz de respuesta de la validacion: 
        foreach($permissions as $permission){

            // Iteramos los arrays que contienen los permisos: 
            foreach($permission as $value){

                // Si posee el permiso, autorizamos:
                if($value == $key){
                    $this->authorization = true; 
                }
            }
        }
    }
}
