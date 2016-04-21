<?php
abstract class Agana_Print_Abstract_Report {
    protected $meta = null;
    
    public function __construct(Agana_Print_Meta $metaData) {
        $this->meta = $metaData;
    }
    
    public function getMeta() {
        return $this->meta;
    }

    abstract public function addPage($content);
    
    abstract public function download($filename = '');
    
    public function getHeaderTemplate() {
        return '
            <table width="100%">
                <tr>
                    <td width="60%"><h6>' . strtoupper($this->meta->getTitle()) . '</h6></td>
                    <td width="40%" class="text-right" style="text-align: right"><strong>
                    <h6>' . $this->meta->getAccountName() . '<h6></strong></td>
                </tr>
            </table>
            <table style="margin-top:-2em; border-bottom: 1px solid #999;" width="100%" >
                <tr>
                    <td width="25%"><h6>'. date("d/m/Y G:i") . '</h6></td>
                    <td width="50%" style="text-align:center;"><h6>' . $this->meta->getSystemName() . '</h6></td>
                    <td width="25%" class="text-right" style="text-align:right;"></td>
                </tr>
            </table>            
            ';
    }
    
    public function getFooterTemplate() {
        return '
            <table width="100%" class="report-main-footer">
                <tr>
                    <td width="50%">
                        ' . $this->meta->getSystemName() .' :: <a href="' . $this->meta->getSystemUrl().'" target="_blank">' . $this->meta->getSystemUrl() .'</a>
                    </td>
                    <td width="50%" style="text-align: right;">
                        by Winponta :: <a href="http://www.winponta.com.br"  target="_blank">http://www.winponta.com.br</a>                        
                    </td>
                </tr>
            </table>
            ';
    }
    
    
}