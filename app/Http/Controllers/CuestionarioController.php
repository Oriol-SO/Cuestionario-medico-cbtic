<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CuestionarioController extends Controller
{
    use traitservicio;
    
    public function obtenerdatos(Request $request){
        //
        try{
            $request->validate([
                'dni'=>'required|numeric',
            ]);
            $params=[
                'dni'=>$request->dni,
                'op'=>'obtener_pacientedni',
                'usuariows'=>'app',
                'clavews'=>'fa0801',
            ];
            $response=$this->requestdata($params);
            $userdata=$response['obtener_pacientedni'][0];
        
            
            if($userdata['nombre']==null || $userdata['aten_numero']==null || $userdata['aten_establecimiento']==null){
                return response()->json(['message'=>'No se encontraron datos del paciente'],405);
            }

            $credentials=[
                "user"=>$userdata['nombre'],
                "dni"=>$userdata['documento_identidad'],
                'empresa'=>$userdata['empresa_razon_social'],
                'fecha'=>$userdata['fecha'],
                'atencion'=>$userdata['numatencion'],
                'plan'=>$userdata['plan_denominacion'],
                'num_atencion'=>$userdata['aten_numero'],
                'num_establecimiento'=>$userdata['aten_establecimiento'],
                'ocupacion'=>$userdata['ocupacion'],
                'edad'=>$userdata['edad'],
                'sexo'=>$userdata['sexo'],
            ];
            $request->session()->put($credentials);
            ///$request->session()->put(['dni'=>$request->dni]);
            return $request->session()->all();
        }catch(Exception $e){
            return response()->json(['message'=>'Error al obtener datos'],405);
        }
        
    }

    public function logout(Request $request){
        //Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
