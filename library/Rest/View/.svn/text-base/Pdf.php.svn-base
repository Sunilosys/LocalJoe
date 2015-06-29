<?php
/**
 * A view that uses the Dompdf library for rendering
 * HTML content as PDF.
 * 
 * @author David Luecke (daff@neyeon.de)
 */
class Rest_View_Pdf extends Zend_View
{
	public function render($name)
	{
		$html = parent::render($name);
    	$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->set_base_path($_SERVER['DOCUMENT_ROOT']);
		$dompdf->render();
	}
}