<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."third_party/PhpWord/Autoloader.php");
// include_once(APPPATH."core/Front_end.php");

use PhpOffice\PhpWord\Autoloader;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Style\TablePosition;
Autoloader::register();
Settings::loadConfig();

class Reports extends CI_Controller
{
    public function phpwordtemplate()  {
		//$this->load->library('phpword');

		$news = $this->phpword_model->get_news();

		//  create new file and remove Compatibility mode from word title
		$iteration = 1;
		$templateProcessor = new \PhpOffice\PhpWord\PhpWord();
		$temp = $templateProcessor->loadTemplate('application\third_party\PhpWord\template_memo.docx');
		$temp->setValue('pic_name', 'hey');
		
		$temp->cloneRow('vehicle_no','5');

		foreach ($news as $data)
		{
			$temp->setValue('vehicle_no#'.$iteration,$data['odo_vehicle_number']);
			$iteration++;
		}

		//$phpWord = new \PhpOffice\PhpWord\PhpWord();
		// $section = $temp->addSection();
		// $header = array('size' => 16, 'bold' => true);
		// //1. Basic table
		// $rows = 10;
		// $cols = 5;
		// //$section->addText('Basic table', $header);
		// $table = $section->addTable();
		// for ($r = 1; $r <= 8; $r++) {
		// 	$table->addRow();
		// 	for ($c = 1; $c <= 5; $c++) {
		// 		$table->addCell(1750)->addText("Row {$r}, Cell {$c}");
		// 	}
		// }

		$temp->saveAs('MyWordFile.docx');
		// send results to browser to download
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.'MyWordFile.docx');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize('MyWordFile.docx'));
		flush();
		readfile('MyWordFile.docx');
		unlink('MyWordFile.docx'); // deletes the temporary file
		exit;
    }
    
    public function index()
    {
    $this->odometer_model->reportShow("application/views/report/odometer_rep.jrxml");
    // $this->odometer_model->reportShow_sub("application/views/report/odometer_rep_subreport1.jrxml");
    // $this->load->view("report/sample1.php");
    }

    public function odometer()
    {
    // $this->odometer_model->odometer_report("application/views/report/odometer.jrxml");
    $this->load->view("report/odometer_report.php");
    }

}
?>