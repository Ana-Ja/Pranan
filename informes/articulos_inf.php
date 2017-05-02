<?php
$raiz="../";

require_once($raiz."modelo/comun.php");

$html = '<header class="clearfix">
      <div id="logo">
        <img src="'.$raiz.'img/logo.png">
      </div>
      <h1>LISTADO ARTICULOS</h1>
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
        <div><span>DATE</span> August 17, 2015</div>
        <div><span>DUE DATE</span> September 17, 2015</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="art">Nombre</th>
            <th class="art">Proveedor</th>
            <th class="art">Unidad</th>
            <th class="art">Foto</th>
            <th class="art">TOTAL</th>
          </tr>
        </thead>
        <tbody>';
$articulos = Articulo::getAllArticulos();
 foreach ($articulos as $fila) {
     $html .='
          <tr >
            <td class="art">'.   $fila->getValueEncoded("nombre") .'</td>
            <td class="art">'.Articulo::getProveedor($fila->getValueEncoded("idproveedor")). '</td>
            <td class="art">'.$fila->getValueEncoded("unidades").'</td>
            <td class="art"><img src="'.$raiz.'recursos/images/'.$fila->getValueEncoded("foto").'" width="30" style="vertical-align: middle;" /></td>
            <td class="total">$1,040.00</td>
          </tr>';


}
        $html .= '

          <tr>
            <td colspan="4">SUBTOTAL</td>
            <td class="total">$5,200.00</td>
          </tr>
          <tr>
            <td colspan="4">TAX 25%</td>
            <td class="total">$1,300.00</td>
          </tr>
          <tr>
            <td colspan="4" class="grand total">GRAND TOTAL</td>
            <td class="grand total">$6,500.00</td>
          </tr>
        </tbody>
      </table>
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div>
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