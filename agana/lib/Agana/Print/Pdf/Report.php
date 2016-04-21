<?php

class Agana_Print_Pdf_Report extends Agana_Print_Abstract_Report {

    private $mpdf;
    private $wkpdf;

    public function __construct(Agana_Print_Meta $metaReport, $theme_path, $watermark = '', $subject = 'System report') {
        parent::__construct($metaReport);

        $cssBootstrap = file_get_contents($theme_path . '/../vendor/twitter-bootstrap/css/bootstrap.min.css');
        $cssBootstrapResponsive = file_get_contents($theme_path . '/../vendor/twitter-bootstrap/css/bootstrap-responsive.min.css');
        $cssFontAwesome = file_get_contents($theme_path . '/../css/font-awesome.min.css');
        $cssAgana = file_get_contents($theme_path . '/../vendor/agana/css/agana.css');
        $cssAgana = file_get_contents($theme_path . '/../vendor/agana/css/agana.mpdf.css');
        $cssCustom = file_get_contents($theme_path . '/../css/custom.css');

        $this->mpdf = new mPDF('c', 'A4', '', '', 5, 5, 15, 10, 5, 5);

        $this->mpdf->SetTitle($this->meta->getTitle());
        $this->mpdf->SetAuthor('Winponta Software');
        $this->mpdf->SetCreator('Winponta Software');
        $this->mpdf->SetSubject($subject);

//        $this->mpdf->simpleTables = true;
        $this->mpdf->useOnlyCoreFonts = true;
        $this->mpdf->SetDisplayMode('fullpage');

        $this->mpdf->defaultheaderfontsize = 7;

        $this->mpdf->SetHTMLHeader($this->getHeaderTemplate());
        $this->mpdf->SetHTMLFooter($this->getFooterTemplate());

        $this->mpdf->WriteHTML($cssBootstrap, 1);
        $this->mpdf->WriteHTML($cssBootstrapResponsive, 1);
        $this->mpdf->WriteHTML($cssFontAwesome, 1);
        $this->mpdf->WriteHTML($cssAgana, 1);
        $this->mpdf->WriteHTML($cssCustom, 1);

        $this->mpdf->SetWatermarkText($watermark);
        $this->mpdf->showWatermarkText = filter_var($watermark, FILTER_VALIDATE_BOOLEAN) ? true : false;

        $this->mpdf->AliasNbPageGroups('{PAGETOTAL}');

        // Create a new WKHtmlToPdf object with some global PDF options
        //$r = new Agana_Print_Report('TITULO', 'ACC NOME', 'SIS NOME', 'SIS URL');
//        $this->wkpdf = new WkHtmlToPdf(array(
//            'no-outline', // Make Chrome not complain
//            'margin-top' => 0,
//            'margin-right' => 0,
//            'margin-bottom' => 0,
//            'margin-left' => 0,
//        ));
//
//        // Set default page options for all following pages
//        $this->wkpdf->setPageOptions(array(
//            'disable-smart-shrinking',
//            'user-style-sheet' => 'pdf.css',
//        ));
    }

    public function getHeaderTemplate() {
        return '
            <table width="100%" class="report-main-header-row">
                <tr>
                    <td width="60%">' . strtoupper($this->meta->getTitle()) . '</td>
                    <td width="40%" class="text-right" style="text-align: right"><strong>' . $this->meta->getAccountName() . '</strong></td>
                </tr>
            </table>
            <table width="100%" class="report-main-header-end-row">
                <tr>
                    <td width="25%">{DATE d/m/Y - H:i}</td>
                    <td width="50%" style="text-align:center;"><h6>' . $this->meta->getSystemName() . '</h6></td>
                    <td width="25%" class="text-right" style="text-align:right;">p. {PAGENO} of {PAGETOTAL}</td>
                </tr>
            </table>            
            ';
    }

    public function addPage($content) {
        $this->mpdf->AddPage();
        $this->mpdf->WriteHTML($content, 2);

//        $this->wkpdf->addPage($content);
    }

    public function download($filename = '') {
        if (trim($filename) == '') {
            $filename = uniqid('Report_');
            $filename .= '_' . str_replace(' ', '_', $this->meta->getTitle());
            $filename .= '_' . date('Ymd_Hm') . '.pdf';
        }
        $this->mpdf->Output($filename, 'D');

//        $this->wkpdf->send($filename);
    }

}
