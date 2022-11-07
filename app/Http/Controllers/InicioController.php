<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class InicioController extends Controller
{
    private $user;
    private $dni;
    private $atencion;
    private $establecimiento;
    use traitservicio;
    
    public function __construct(Request $request)
    {
       //$this->middleware('auth');
       if(!$request->session()->has('user') ) {
        Redirect::to('/')->send();
        throw new Exception('error al autenticar');
       }else{
        $this->user=$request->session()->get('user');
        $this->atencion=$request->session()->get('num_atencion');
        $this->establecimiento=$request->session()->get('num_establecimiento');
        if(!$request->session()->has('dni')){
            Redirect::to('/')->send();
            throw new Exception('error al autenticar');
        }else{
            $this->dni=$request->session()->get('dni');
        } 
       }
    }
    
    public function inicio(Request $request){
     
        $params=[
            'op'=>'listar_examenpsicologico',
            'usuariows'=>'app',
            'clavews'=>'fa0801',
            'atencion'=>$this->atencion,
            'establecimiento'=>$this->establecimiento, 
        ];
        
        $datos=$this->requestdata($params);
        $prueba= $datos['listar_examenpsicologico'][0];
        if($prueba['atencion']==null || $prueba['establecimiento']==null || $prueba['denominacion']==null){
            throw new Exception('error al obtener los test');
        }
        $cuestionario=[];

        foreach($datos['listar_examenpsicologico'] as $cuest){
            $cuestionario[]=[
                'nombre'=>$cuest['denominacion'],
                'preguntas'=>14,
                'estado'=>$cuest['estado']=='PENDIENTE'?0:1,
                'id'=>$cuest['submodulo'],
                'tiempo'=>$cuest['tiempo'],
                'modulo'=>$cuest['modulo'],
                'tipo'=>1,
            ];
        }
       // return $cuestionario;
  
        return view('inicio',['user'=>$request->session()->all(),'cuestionario'=>$cuestionario]);

    }


    public function test(Request $request){

    }
}
