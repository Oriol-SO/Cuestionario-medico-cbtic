<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @extends('layouts')

    @section('cuerpo')
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
        <span class="dot"></span>
        <div class="dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
        </div>
    </div>
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="{{url('/inicio')}}" class="logo">
                            <img src="{!! asset('assets/images/logo.png')!!}" alt="">
                    
                        </a>
                        
                        <ul class="nav">
                            <li>
                                <a href="{{url('/')}}">Terminar sesión</a> 
                            </li> 
                        </ul>

                        <a class="menu-trigger">
                            <span>Menu</span>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <div class="amazing-deals">
        <div class="container">
          <div class="row">
            <div class="col-lg-1 ">
                <div class=" text-center " >
                    <a class="btn btn-primary" href="{{url('/inicio')}}" role="button">Atras</a>
                </div>
              </div>
            <div class="col-lg-9 ">
              <div class="section-heading text-center " >
                <h2>{{$test['nombre']}}</h2>
                <p class="mb-3 pb-4">Responda las preguntas de la forma mas sincera posible.</p>
              </div>
            </div>
            <div class="col-lg-2 ">
                <div class=" text-center " >
                    <p>Duracion</p>
                  <h5><i class="fa fa-clock"></i> {{$test['tiempo']}} min</h5>
                </div>
              </div>
          </div>
        </div>
       
      </div>
      <div class="more-info reservation-info" style="overflow: auto; max-height:700px;">
        <div class="container">
          <div class="row">
            <small style="color:transparent">{{$i=1}}</small>
            @foreach($preguntas as $pre)
            <div class="col-lg-12 mt-3">
              <div class="info-item">
                <h4>( {{$i++}} ): {{$pre['pregunta']}}</h4>
                @if($pre['tipo']=='opcion')
                    <div>
                        <ul>
                            <form >
                            @foreach($pre['opciones'] as $op)
                            
                            <li>
                                <div class="custom-control custom-radio">
                                    <input type="radio"  name="respuesta" value="{{$op}}" class="custom-control-input">
                                    <label class="custom-control-label">{{$op}}</label>
                                  </div>
                            </li>
                        
                            @endforeach
                        </form>
                        </ul>
                    </div>
                @else
                    <div>
                        <input type="email" class="form-control" name="respuesta"  placeholder="Escriba su respuesta">
                    </div>
                @endif
                
              </div>
            </div>
            @endforeach
            <div>
                <fieldset>
                    <button class="mt-2 mb-3" style="    
                    font-size: 14px;
                    color: #fff;
                    background-color: #22b3c1;
                    border: 1px solid #22b3c1;
                    padding: 12px 30px;
                    width: 100%;
                    text-align: center;
                    display: inline-block;
                    border-radius: 25px;
                    font-weight: 500;
                    text-transform: capitalize;
                    letter-spacing: 0.5px;
                    transition: all .3s;
                    position: relative;
                    overflow: hidden;" class="main-button">Finalizar</button>
                </fieldset>
            </div>
          </div>
        </div>
      </div>

    @stop
</body>
</html>