<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
    
    protected function enviar_resultado(Request $request){
        $request->validate([
            'pregunta'=>'required|numeric',
            'respuesta'=>'required',
            'modulo'=>'required|numeric',
            'submodulo'=>'required|numeric',
            'tipo'=>'required'
        ]);
        $result=$request->respuesta;
        $observacion='';
        if($request->tipo==2){
            $observacion='hola';
            $result='';
        }
        $array=[
            'op'=>'editar_pregunta',
            'usuariows'=>'app',
            'clavews'=>'fa0801',
            'atencion'=>"$this->atencion",
            'establecimiento'=>"$this->establecimiento",
            'pregunta'=>"$request->pregunta",
            'resultado'=>"$result",
            'observacion'=>$observacion,
            'modulo'=>"$request->modulo",
            'submodulo'=>"$request->submodulo",    
        ];
        //dd($array);
        $response=$this->requestdata($array);
        return $response;
    }


    protected function enviar_resuestas(Request $request){
        $request->validate([
            'preguntas'=>'required',
        ]);
        try{
            json_encode($request);
            $array=[];
            foreach($request->preguntas as $pre){
                if($pre['pregunta']=='' || $pre['respuesta']=='' || $pre['pregunta']==null || $pre['respuesta']==null){
                    return response()->json(['message'=>'Error al verificar respuestas'],405);
                }
                else{
                    $array[]=[
                        'atencion'=>$this->atencion,
                        'establecimiento'=>$this->establecimiento,
                        'pregunta'=>$pre['pregunta'],
                        'respuesta'=>$pre['respuesta'],
                    ];
                }
            }
           return response()->json(['message'=>'enviado','preguntas'=>$array]);
        }catch(Exception $e){
            response()->json(['message'=>'Error en el servidor'],405);
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
        $descripcion='Resuelva el test correctamente';
        $preguntas=$this->obtener_preguntas($datos['modulo'],$id);
        if(count($preguntas)>0){
            $des=$preguntas[0]['descripcion'];
            if($des!=''){
                $descripcion=$des;
            }
        }
        
        //return $preguntas;
        return view('test',['preguntas'=>$preguntas,'desc'=>$descripcion,'test'=>$datos,'user'=>$this->user,'dni'=>$this->dni]);
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
        $opciones=$this->obtener_opciones($modulo,$submodulo);
        $opciones=$opciones['listar_examenpsicologicoopciones'];
        
        foreach($preguntas['listar_examenpsicologicopreguntas'] as $pre){
            $opcion =$this->buscar_opcione($pre['numpregunta'],$opciones);
            $pregu[]=[
                'id'=>$pre['numpregunta'],
                'pregunta'=>$pre['denominacion'],
                'numopcion'=>$pre['numopcion'],
                'respuesta'=>$pre['respuesta'],
                'descripcion'=>$pre['descripcion'],
                'tipo'=>$pre['tipo_respuesta'],
                'opciones'=>$opcion,
            ];
        }
        return $pregu;
    }
    public function buscar_opcione($preg,$opciones){
        $option=[];
        foreach($opciones as $op){
            if($op['numpregunta']==$preg){
                $option[]=[
                    'id'=>$op['idopcion'],
                    'denominacion'=>$op['denominacion'],
                    'valor'=>$op['valor'],
                ];
            }
        }
        return $option;
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
