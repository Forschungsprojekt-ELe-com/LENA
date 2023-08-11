<?php

class EmilRenderer extends Renderer {    
    
    protected function getSuggestionsList() {
        $suggestions = array();
        
        $plan = Planned::getInstance();
        
        $idList = $plan->getObjIdList();
        for( $i=0; $i<3; ++$i ) {
            $rand = rand( 0, ( count( $idList ) -1 ) );
            $suggestions[] = $this->usecase->getRefId( $rand );
        }
        return $suggestions;
    }
    
    
    public function render() {
        $suggestions = $this->getSuggestionsList(); // array( 1,2,3 );
        $out = '';
        $out .= '<div id="emil">';        
        $out .= '<div id="suggestions"><div class="customBG">';            
        
        $response = 'Aufgrund deine aktuellen Einstellungen schlage ich folgendes vor:';
//        if( count( $notVisited ) == 1 ) {
//            $response = '<b>finished</b>';
//        }         
        $out .= '<div id="response">';
        $out .= $response;
        $out .= '</div>';

        $out .= '<ul id="list">';
        foreach( $suggestions as $id ) {            
            $out .= '<li class="suggestion"><a href="' . $this->baseUrl . '?add=' . $itemId . '">'
                 . 'MLE' . $itemId 
                . '</a></li>'
            ;
        }
        $out .= '</ul>';
        
        $out .= '</div></div>';
        $out .= '</div>';

	$out .= '<script>';
	$out .= 'let endpoint = "./Customizing/global/plugins/Services/COPage/PageComponent/LENA/classes/api.php";';
	$out .= 'let url = endpoint;';  // TODO params
	$out .= 'console.log(url);';
	$out .= '$.get(url, function(response) {';
	$out .=     'console.log(response);';
        $out .= '})';
	$out .= '</script>';

        return $out;
    }

}
