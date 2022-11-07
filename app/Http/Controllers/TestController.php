<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\Return_;

class TestController extends Controller
{
    public $user;
    public $dni;
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
    
    public function test(Request $request,$id){
        

        $params=[
            'op'=>'listar_examenpsicologico',
            'usuariows'=>'app',
            'clavews'=>'fa0801',
            'atencion'=>$this->atencion,
            'establecimiento'=>$this->establecimiento, 
        ];
        $cuestionario=$this->requestdata($params);

        $cuestionario=$cuestionario['listar_examenpsicologico'];

       // return $cuestionario;
 
        $datos=[];
        foreach($cuestionario as $cuest){
            if($cuest['submodulo']==$id){
                $datos=[
                    'nombre'=>$cuest['denominacion'],
                    'preguntas'=>14,
                    'estado'=>$cuest['estado']=='PENDIENTE'?0:1,
                    'id'=>$cuest['submodulo'],
                    'tiempo'=>$cuest['tiempo'],
                    'modulo'=>$cuest['modulo'],
                    'tipo'=>1,
                    'atencion'=>$cuest['atencion'],
                    'establecimiento'=>$cuest['establecimiento'],
                ];   
            }
        }

        if($datos['atencion']!=$this->atencion || $datos['establecimiento']!=$this->establecimiento){
            throw new Exception('La atencion no coincide');
        }

        $preguntas=$this->obtener_preguntas($datos['modulo'],$id);
       //return $preguntas;
        return view('test',['preguntas'=>$preguntas,'test'=>$datos,'user'=>$this->user,'dni'=>$this->dni]);
    }


    public function obtener_preguntas($modulo,$submodulo){
        $params=[
            'op'=>'listar_examenpsicologicopreguntas',
            'usuariows'=>'app',
            'clavews'=>'fa0801',
            'atencion'=>$this->atencion,
            'establecimiento'=>$this->establecimiento, 
            'modulo'=>$modulo,
            'submodulo'=>$submodulo,
        ];
        $preguntas=$this->requestdata($params);
        $pregu=[];
        $prueba=$preguntas['listar_examenpsicologicopreguntas'][0];
        if($prueba['numpregunta']==null || $prueba['denominacion']==null ){
            return [];
        }
        foreach($preguntas['listar_examenpsicologicopreguntas'] as $pre){
            $pregu[]=[
                'id'=>$pre['numpregunta'],
                'pregunta'=>$pre['denominacion'],
                'numopcion'=>$pre['numopcion'],
                'respuesta'=>$pre['respuesta'],
                'descripcion'=>$pre['descripcion'],
                'tipo'=>'opcion',
                'opciones'=>[
                    'Si',
                    'No',   
                ]
            ];
        }
        return $pregu;
    }

    public function obtener_opciones($modulo,$submodulo){
        $params=[
            'op'=>'listar_examenpsicologicoopciones',
            'usuariows'=>'app',
            'clavews'=>'fa0801',
            'atencion'=>$this->atencion,
            'establecimiento'=>$this->establecimiento, 
            'modulo'=>$modulo,
            'submodulo'=>$submodulo,
        ];
       
        $opciones=$this->requestdata($params);

        return $opciones;
    }
}


