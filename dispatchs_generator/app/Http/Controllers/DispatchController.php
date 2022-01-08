<?php

namespace App\Http\Controllers;

use App\Imports\DispatchController as ImportsDispatchController;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DispatchController extends Controller
{
    public function import(Request $request){
        
        $request->file('dispatch')->storeAs('public', $request->file('dispatch')->getClientOriginalName());

       
        $collection = Excel::toCollection(new ImportsDispatchController, 'public/'.$request->file('dispatch')->getClientOriginalName());

        return $collection;
    }
}
