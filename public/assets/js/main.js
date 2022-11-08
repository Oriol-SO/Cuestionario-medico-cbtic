
var form=document.getElementById('formulariodni')



var datodni=''

form.addEventListener('submit',e=>{
    e.preventDefault();
    datodni = Object.fromEntries(new FormData(e.target));
    console.log(JSON.stringify(datodni))
    validardni();
})
     
function validardni(){ 
    axios.post('/api/obtenerdatos',datodni).then(function (response) {
        window.location.href = '/inicio';
        console.log(response.data);
        })
        .catch(function (error) {
        Swal.fire({icon: 'error',text:error.response.data.message})
        console.log(error.response.data.message);
        });      
}

var form_respuesta=[];
function enviar(p,o){
    console.log(p+' '+o)

    rellenar_form(p,o)
}
function rellenar_form(p,o){
    
    b=0;
    if(form_respuesta){
        //evaluar si ya existe en el array 
        form_respuesta.forEach(pre=>{
            if(pre.pregunta==p){
                b++;
            }
        })
        if(b>0){
            //remplazar la respuesta   
            let indice=form_respuesta.findIndex( (element) => element.pregunta==p);
            form_respuesta.splice(indice, 1)
            form_respuesta.push({pregunta:p,respuesta:o});
        }else{
            form_respuesta.push({pregunta:p,respuesta:o});
        }
        
    }else{
        form_respuesta=[{pregunta:p,respuesta:o}];
    }
}   


function enviar_form(){
    if(form_respuesta){
        form_respuesta.sort(function (a, b){
            return (a.pregunta - b.pregunta)
        })
        console.table(
         form_respuesta
        )
        enviar_respuestas(form_respuesta)
    }else{
        Swal.fire({icon: 'error',text:'Responda al menos una pregunta'})
    }
    
}

function enviar_respuestas(request){
        let form={
            _csrf:window.CSRF_TOKEN,
            preguntas:request,
        }
        axios.post('/api/enviarrespuestas', form).then(function (response) {
        // window.location.href = '/inicio';
        Swal.fire({icon: 'success',text:response.data.message})
        console.log(response.data.preguntas)
        })
        .catch(function (error) {
             Swal.fire({icon: 'error',text:error.response.data.message})
        });   
}