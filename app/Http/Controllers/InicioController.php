<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class InicioController extends Controller
{
    private $user;
    private $dni;
    public function __construct(Request $request)
    {
       //$this->middleware('auth');
       if(!$request->session()->has('user') ) {
        Redirect::to('/')->send();
        throw new Exception('error al autenticar');
       }else{
        $this->user=$request->session()->get('user');
        if(!$request->session()->has('dni')){
            Redirect::to('/')->send();
            throw new Exception('error al autenticar');
        }else{
            $this->dni=$request->session()->get('dni');
        } 
       }
    }
    
    public function inicio(Request $request){

        $cuestionario=[
            [
                'nombre'=>'TEST DE EPWORT',
                'preguntas'=>14,
                'estado'=>0,
                'tiempo'=>'10',
                'id'=>1,
            ],
            [
                'nombre'=>'TEST DE ZUNG',
                'preguntas'=>18,
                'estado'=>1,
                'tiempo'=>'30',
                'id'=>2,
            ],
            [
                'nombre'=>'TEST DE AUDIT',
                'preguntas'=>20,
                'estado'=>0,
                'tiempo'=>'25',
                'id'=>3
            ],
            

        ];
        return view('inicio',['user'=>$request->session()->all(),'cuestionario'=>$cuestionario]);

    }


    public function test(Request $request){

    }
}
