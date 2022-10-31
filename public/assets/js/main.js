
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
