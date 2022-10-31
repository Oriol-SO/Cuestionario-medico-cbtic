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
    


    public function test(Request $request,$id){
        
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
        $datos=[];
        foreach($cuestionario as $cuest){
            if($cuest['id']==$id){
                $datos=$cuest;
            }
        }
        $preguntas=[
            [
                'pregunta'=>'Pregunta 1',
                'tipo'=>'opcion',
                'opciones'=>[
                    'Si',
                    'No',   
                ]
            ],
            [
                'pregunta'=>'Pregunta 2',
                'tipo'=>'opcion',
                'opciones'=>[
                    'opcion 1',
                    'opcion 2',
                    'opcion 3',
                    'opcion 4'
                ]
            ],[
                'pregunta'=>'Pregunta 3',
                'tipo'=>'libre',
                'opciones'=>[
                    
                ]
            ],[
                'pregunta'=>'Pregunta 4',
                'tipo'=>'opcion',
                'opciones'=>[
                    'Nunca',
                    'A veces',
                    'Casi siempre',
                    'Siempre'
                ]
            ]
        ];
        return view('test',['preguntas'=>$preguntas,'test'=>$datos,'user'=>$this->user,'dni'=>$this->dni]);
    }
}
