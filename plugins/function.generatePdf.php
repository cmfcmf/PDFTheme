<?php

/**
 * Generates the pdf file.
 */
function smarty_function_generatePdf($params, $view)
{
    if (!ModUtil::available('PDF')) {
        return "Please install the cmfcmf/PDF module!";
    }
    $html = $params['html'];

    $elementsToHide = explode(',', ThemeUtil::getVar('elementsToHide', array()));
    array_walk($elementsToHide, 'trim');

    $html = ModUtil::apiFunc('PDF', 'PDF', 'removeHTMLElements', array('html' => $html, 'elements' => $elementsToHide));
    $html = ModUtil::apiFunc('PDF', 'PDF', 'makeLinksAbsolute', array('html' => $html));


    /** @var PDF_TCPDF_Handler $tcpdf */
    $tcpdf = ModUtil::apiFunc('PDF', 'PDF', 'getTCPDFHandler');
    $pdf = $tcpdf->createPdf();
    $pdf->AddPage();
    $pdf->writeHTML($html);
    $pdf->Output(PageUtil::getVar('title') . '.pdf', 'I');

    exit;
}
