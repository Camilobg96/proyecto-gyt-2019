/*
              -------Creado por-------
             \(x.x )/ Anarchy \( x.x)/
              ------------------------
 */

//    Yo tengo un sueño. El sueño de que mis hijos vivan en un mundo con un único lenguaje de programación.  \\
/** Valida los campos requeridos en un formulario
 * Returns flag Devuelve true si el form cuenta con los datos mínimos requeridos
 */
var EMPRESA="";
var USUARIO="";
var PASSWORD="";
function login(){
    EMPRESA=document.getElementById("InputEmpresa").value;
    USUARIO=document.getElementById("InputUsuario").value;
    PASSWORD=document.getElementById("InputPassword").value;    
    //window.location.href = "Main.html";
    cargaContenido('main','Main.php')
}


function validarForm(idForm){
	var form=$('#'+idForm)[0];
	for (var i = 0; i < form.length; i++) {
		var input = form[i];
		if(input.required && input.value==""){
			return false;
		}
	}
	return true;
}

var rutaBack = '../back/Router.php';

function listarTerceros(){
  var formData = {};
  formData["ruta"]="listarTerceros";
  enviar(formData,rutaBack,postListarTerceros);
}

function postListarTerceros(result,state) {
  $("#cuerpo").append(result);  
}

function listarMovimientos(){
  var cod = CodCliente.value+"STRING";
  var codSuc = CodSucursal.value+"STRING";
  var formData = {"ruta":"listarMovimientos","cod":cod,"CodSucursal":codSuc};
  enviar(formData,rutaBack,postlistarMovimientos);
}

function postlistarMovimientos(result,state) {
  $("#cuerpo").append(result);  
}

function buscarTercero(OTERID){    
    formData={"oterid":OTERID,"ruta":"buscarTercero"};
    enviar(formData,rutaBack,postBuscarTercero);
}
function postBuscarTercero(result,state){
 		if(state=="success"){                     
 			$("#tablaModal").empty();
    		$("#tablaModal").append(result);
 			document.getElementById("botonTercero").click();
 		}
}
function carteraPorTercero(cod){	
	formData={"cod":cod,"ruta":"carteraPorTercero"};
  enviar(formData,rutaBack,postcarteraPorTercero);    
}
function postcarteraPorTercero(result,state){
 		if(state=="success"){
 			$("#tablaModal2").empty();
    		$("#tablaModal2").append(result);		
 			document.getElementById("botonCartera").click();
 		}
}

function cargarViewPedidos () {
  cargaContenido('container','pedidos.html');
  setTimeout(function(){ 
    $( "#datepicker" ).datepicker();
  }, 500);
}

var productosPedido=[];

function addProducto() {

  if(validarForm("productoNuevo")){
    var producto = {};
    producto["OCODMAT"] = OCODMAT.value;
    producto["OCODBODEGA"] = OCODBODEGA.value;
    producto["OCANTIDAD"] = OCANTIDAD.value;
    producto["OTIPOUNIDAD"] = OTIPOUNIDAD.value;
    producto["OVALOR"] = OVALOR.value;

    productosPedido.push(producto);
    productosBody.appendChild(createTR(producto));
    cerrarModal.click();
  }else{
    alert("Por favor, complete todos los campos");
  }
}

function insertarPedido() {
  if(validarForm("insertarPedido") && productosPedido.length > 0){
    var formData = {};
    formData["OCODCOMP"]=OCODCOMP.value;
    formData["OCODPREFIJO"]=OCODPREFIJO.value;
    formData["ONUMERO"]=ONUMERO.value;
    formData["OFECHA"]=datepicker.value;
    formData["OPERIODO"]=OPERIODO.value;
    formData["OCODCLIENTE"]=OCODCLIENTE.value;
    formData["OCODFORMAPAGO"]=OCODFORMAPAGO.value;

    formData["OITEMSPEDIDO"]=productosPedido;
    var json = {"obj":formData,"ruta":"insertarPedido"};
    enviar(json,rutaBack,postinsertarPedido);
  }else{
    alert("Por favor, complete todos los campos");
  }
}
function postinsertarPedido (result,state) {
  console.log(state);
  console.log(result);
  if(state=="success"){

    var json=JSON.parse(result);
    alert(json.status+"\n "+json.results);
    productosPedido=[];
    removeAllChildren(productosBody);
  }else{
       alert("Hubo un herror interno ( u.u)\n"+result);
   }
}
//That´s all, folks!