<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// include autoloader
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

class Pdf extends Dompdf
{
    protected $ci;
    function __construct()
    {
        parent::__construct();
        $this->ci =& get_instance();
    }

    function createpdf($view, $data=array(), $filename='', $download=TRUE, $paper='A4', $orientation='portrait'){
        // echo '<pre>';print_r($data); die;
        $html = $this->ci->load->view($view, $data, true);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        // $dompdf->set_paper($paper, $orientation);
        $dompdf->render();
        
        if($download)
            $dompdf->stream($filename.'.pdf', array('Attachment' => 1));
        else
            $dompdf->stream($filename.'.pdf', array('Attachment' => 0));
    }

    function createpdf2($html, $filename='', $download=FALSE, $paper='A4', $orientation='portrait'){
        $dompdf = new Dompdf();
        $dompdf->load_html($html);
        $dompdf->set_paper($paper, $orientation);
        $dompdf->render();
        if($download)
            $dompdf->stream($filename.'.pdf', array('Attachment' => 1));
        else
            $dompdf->stream($filename.'.pdf', array('Attachment' => 0));
    }
    
}
?>