<?php

namespace App\Http\Controllers\services\main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
       // Asignamos los datos recibidos: 
       $identification = $request->input('identification');
       $userName = $request->input('userName');
       $name = $request->input('name');
       $lastName = $request->input('lastName');
       $password = $request->input('password');
       $confirmPassword = $request->input('confirmPassword');
       $role = $request->input('role');
       $gender = $request->input('gender');

       // Validamos que no existan datos vacios: 
       if(!empty($identification)
       && !empty($userName)
       && !empty($name)
       && !empty($lastName)
       && !empty($password)
       && !empty($confirmPassword)
       && !empty($role)
       && !empty($gender)){

           

       }else{
           // Retornamos el error: 
           return response(['register' => false, 'error' => "No pueden existir campos vacios"]);
       }
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
