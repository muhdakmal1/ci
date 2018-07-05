<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once('assets/PHPJasperXML2-master/lib/tcpdf/tcpdf.php');
include_once("assets/PHPJasperXML2-master/PHPJasperXML.inc.php");
// $this->load->library('PHPJasperXML');

include_once ('setting.php');

$path = 'application/views/report/sample1.jrxml';

$PHPJasperXML = new PHPJasperXML();
//$PHPJasperXML->debugsql=true;
$PHPJasperXML->arrayParameter=array("parameter1"=>1);
$PHPJasperXML->load_xml_file($path);

$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
$PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file

?>