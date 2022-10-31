<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CuestionarioController extends Controller
{

    

    public function obtenerdatos(Request $request){
        //
        $request->validate([
            'dni'=>'required|numeric',
        ]);

        

        if($request->dni!='72852803'){
            return response()->json(['message'=>'No se encontró al paciente'],405);
        }

        $credentials=[
            "user"=>'Oriol Nelson',
            "dni"=>$request->dni,
            'empresa'=>'marcobre sac',
            'fecha'=>'12-04-2022',
            'atencion'=>'19032-1',
            'plan'=>'Basico F.MARG.GES1'
        ];
        $request->session()->put($credentials);
        ///$request->session()->put(['dni'=>$request->dni]);
        return $request->session()->all();
        
    }

    public function logout(Request $request){
        //Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
