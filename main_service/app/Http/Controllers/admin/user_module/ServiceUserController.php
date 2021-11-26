<?php

namespace App\Http\Controllers\admin\user_module;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceUserController extends Controller
{
    // Metodo para retornar todos los servicios de la DB: 
    public function index()
    {
        //
    }

     
    public function store(Request $request)
    {
        //
    }

    // Metodo para retornar todos los servicios de un usuario: 
    public function show($id)
    {
        // Instanciamos el controlador del modelo 'User', para validar que exista el usuario: 
        $userController = new UserController;
        
        // Validamos el usuario: 
        $validateUser = $userController->show($id);

        // Si existe, realizamos la consulta a la DB: 
        if($validateUser['query']){

            // Realizamos la consulta a la entidad: 
            $model = DB::table('service_users', 'service')

                        ->where('user_id', $id)

                        ->join('services', 'services.id_service', '=', 'service.service_id')

                        ->select('services.name')

                        ->get();

            // Si existen registros, retornamos la respuesta: 
            if(count($model) != 0){

                // Retornamos la respuesta: 
                return ['query' => true, 'services' => $model];

            }else{
                // Retornamos el error: 
                return ['query' => false, 'error' => 'No existen servicios para ese usuario.'];
            }

        }else{
            // Retornamos el error: 
            return $validateUser;
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
