<?php
/**
* 
*/
class Controller{
  
  function __construct(){}

  public function listarTerceros(){
    $url = "https://tns.net.co:726/api/Tercero?empresa=1090496800&usuario=ADMIN&password=A0DPV3&tnsapitoken=12345&filtro=";
    $apijson = file_get_contents($url);
    $apiarray = json_decode($apijson,true);
    
    $satus = $apiarray["status"];
    $results = $apiarray["results"];
    $tabla = '';

    if($satus === "OK"){
      if(count($results) > 0){
        foreach ($results as $v) {          
           $tabla .= '<tr>'.
               '<td>'.$v["OCODIGO"].'</td>'.
               '<td>'.$v["ONOMBRE"].'</td>'.
               "<td><a href=\"JavaScript:buscarTercero(".$v["OTERID"].")\"><span class=\"glyphicon glyphicon-plus-sign\"></span></a></td>".
               "<td><a href=\"JavaScript:carteraPorTercero('".$v["OCODIGO"]."STRING')\"><span class=\"glyphicon glyphicon-zoom-in\"></span></a></td>".
               '</tr>';
        }
      }
      else{
        $tabla = '<tr><td colspan="5">NO SE ENCONTRARON REGISTROS</td></tr>';
      }
    }
    else{
      $tabla = '<tr><td colspan="5">'.$results.'</td></tr>';
    }
    echo($tabla);
  }    

  public function listarMovimientos(){

    $COD = $_POST['cod'];
    $COD=str_replace("STRING","",$COD);

    $SUC = $_POST['CodSucursal'];
    $SUC=str_replace("STRING","",$SUC);
    

    $url = "https://tns.net.co:726/api/Tercero?empresa=1090496800&usuario=ADMIN&password=A0DPV3&tnsapitoken=12345&codcliente=$COD&codsucursal=$SUC";
    $apijson = file_get_contents($url);
    $apiarray = json_decode($apijson,true);
    
    $satus = $apiarray["status"];
    $results = $apiarray["results"];
    $tabla = '';
    $documentos = $results["Documentos"];

    if($satus === "OK"){
      if(count($results["Documentos"])>0){
        for ($i=0; $i < count($documentos) ; $i++) { 
          $ocodcomp = $documentos[$i] ["OCODCOMP"];
          $ofecha = $documentos[$i] ["OFECHA"];
          $ofechaven = $documentos[$i] ["OFECVENCE"];
          $otelefono = $documentos[$i] ["OTELEFONO"];

          $tabla .= '<tr>'.
               '<td>'.$ocodcomp.'</td>'.
               '<td>'.$ofecha.'</td>'.
               '<td>'.$ofechaven.'</td>'.
               '<td>'.$otelefono.'</td>'.
               '</tr>';
        }
      }
      else{
        $tabla = '<tr><td colspan="5">NO SE ENCONTRARON REGISTROS</td></tr>';
      }
    }
    else{
      $tabla = '<tr><td colspan="5">'.$results.'</td></tr>';
    }
    echo($tabla);
  }    

  public function carteraPorTercero(){
    $COD = $_POST['cod'];
    $COD=str_replace("STRING","",$COD);

    $url = "https://tns.net.co:726/api/Tercero?empresa=1090496800&usuario=ADMIN&password=A0DPV3&tnsapitoken=12345&codcliente=$COD&codsuc=00";

    $apijson = file_get_contents($url);
    $apiarray = json_decode($apijson,true);

    $satus = $apiarray["status"];
    $results = $apiarray["results"];
    $tabla = '';

    if($satus === "OK"){
      if(count($results) > 0){
        foreach ($results as $v) {
           $tabla .= '<tr>'.
               '<td>'.$v["NOMBRE"].'</td>'.
               '<td>'.$v["DETALLE"].'</td>'.
               '<td>'.$v["FECHA"].'</td>'.
               '<td>'.$v["VALOR"].'</td>'.
               '<td>'.$v["PAGADO"].'</td>'.
               '<td>'.$v["SALDO"].'</td>'.
               '<td>'.$v["ANTICIPO"].'</td>'.
               '</tr>';
        }
      }
      else{
        $tabla = '<tr><td colspan="5">NO SE ENCONTRARON REGISTROS</td></tr>';
      }
    }
    else{
      $tabla = '<tr><td colspan="5">'.$results.'</td></tr>';
    }
    echo($tabla);
  }

  public function buscarTercero(){
    $OTERID = $_POST['oterid'];

    $url = 'https://tns.net.co:726/api/Tercero/'.$OTERID.'?empresa=1090496800&usuario=ADMIN&password=A0DPV3&tnsapitoken=12345';
    $apijson = file_get_contents($url);
    $apiarray = json_decode($apijson,true);
    
    $satus = $apiarray["status"];
    $v = $apiarray["results"];
    $tabla = '';    
           $tabla .= '<tr>'.
               '<td>'.$v["OCODIGO"].'</td>'.
               '<td>'.$v["ONIT"].'</td>'.
               '<td>'.$v["ONOMBRE"].'</td>'.
               '<td>'.$v["ODIRECC1"].'</td>'.              
               '<td>'.$v["OTELEF1"].'</td>'.
               '<td>'.$v["OEMAIL"].'</td>'.              
               '</tr>';
            
    echo($tabla);
  }

  public function insertarPedido(){
    $url="https://tns.net.co:726/api/Pedido?empresa=1090496800&usuario=ADMIN&password=A0DPV3&tnsapitoken=12345&codsucursal=00";
    $data = $_POST['obj'];
    //return json_encode($data,true); 
    return self::file_post_contents($url,$data);
    //return $data;
  }


  public function file_post_contents($url, $data){
    $data_string = json_encode($data);
    $ch = curl_init($url);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                    
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string))                                                                       
    );                                                                                                                   
                                                                                                                         
    return curl_exec($ch);
  }
}
?>
