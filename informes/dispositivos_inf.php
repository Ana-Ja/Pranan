<?php
$raiz="../";

require_once($raiz."modelo/comun.php");

$html = '<header class="clearfix">
      <div id="logo">
        <img src="'.$raiz.'img/logo.png">
      </div>
      <h1>DESGLOSE DISPOSITIVOS</h1>
      <div id="company" class="clearfix">
        <div>PRANAN</div>
        <div>C/ Chapinerias 9,<br /> 31500, Tudela - NAVARRA</div>
        <div>948 98 76 14</div>
        <div><a href="mailto:chema@pranan.es">chema@pranan.es</a></div>
      </div>
      <div id="project">
        <div><span>PROJECT</span> Website development</div>
        <div><span>CLIENT</span> John Doe</div>
        <div><span>ADDRESS</span> 796 Silver Harbour, TX 79273, US</div>
        <div><span>EMAIL</span> <a href="mailto:john@example.com">john@example.com</a></div>

      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr id="borde">
            <th class="desc">Id</th>
            <th class="desc">Dispositivo</th>
            <th class="desc">Unidad</th>
            <th>Foto</th>
          </tr>
        </thead>
        <tbody>';
 list($productos, $totalRows) = Producto::getProductos(0, PAGE_SIZE,"nombre");
 foreach ($productos as $fila) {
     $html .='
          <tr id="linea">
            <td class="desc">'.   $fila->getValueEncoded("id") .'</td>
            <td class="desc">'.   $fila->getValueEncoded("nombre") .'</td>
            <td class="desc">'.$fila->getValueEncoded("unidades").'</td>
            <td class="desc"><img src="'.$raiz.'recursos/images/'.$fila->getValueEncoded("foto").'" width="30" style="vertical-align: middle;" /></td>

          </tr>';
         $html .='
          <tr>
            <th  class="art">Id</th>
            <th  class="art">Articulos</th>
            <th class="art">Unidad</th>
            <th class="art">Foto</th>
          </tr>';
          $compo = Composicion::getComposicionesInforme($fila->getValueEncoded("id"));
          foreach ($compo as $filacompo) {
               $html .='
                    <tr >
                      <td class="art">'.   $filacompo["idarticulo"] .'</td>
                      <td class="art">'.   $filacompo["nombre"]  .'</td>
                      <td class="art">'. $filacompo["unidades"] .'</td>
                      <td class="art"><img src="'.$raiz.'recursos/images/'. $filacompo["foto"] .'" width="20" style="vertical-align: middle;" /></td>

                    </tr>';
                  }
}
        $html .= '


        </tbody>
      </table>

    </main>';



//==============================================================
//==============================================================

//echo $html; exit;
//==============================================================
$path = (getenv('MPDF_ROOT')) ? getenv('MPDF_ROOT') : __DIR__;
require_once $raiz. '/vendor/autoload.php';

//$mpdf = new \Mpdf\Mpdf();
$mpdf = new mPDF('c', 'A4');
//$mpdf->SetDisplayMode('fullpage');
// LOAD a stylesheet
$stylesheet = file_get_contents($raiz.'css/stylempdf.css');

//$stylesheet = file_get_contents('css/mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet,1);  // The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html);

//$mpdf->list_number_suffix = ')';

$mpdf->Output();

exit;
//==============================================================
//==============================================================
//==============================================================
?>