<?php

namespace App\Http\Controllers\admin\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

session_start();

class DashBoardController extends Controller
{
    // Metodo para validar el estado de sesion: 
    public function index()
    {
        // ESTADO: 
        static $active = 'Activa';

        // Si existe el estado, lo enviamos a la vista 'dashboard':
        if($_SESSION['status'] == $active){

            if(isset($_SESSION['user'])){
                // Asignamos el contenido de la sesion 'user' a la variable 'data': 
                $data = $_SESSION['user'];
    
                // Retornamos la vista 'dashboard': 
                return view('dashboard.dashboard', ['data' => $data]);
    
            }else{
                // Retornamos la vista 'dashboard': 
                return view('dashboard.dashboard');
            } 

        }else{

            // Redirigimos a la vista principal porque no ha iniciado sesion: 
            return redirect()->route('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input('data');
        return json_decode( Http::post('https://jsonplaceholder.typicode.com/posts', ['data' => $data]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
