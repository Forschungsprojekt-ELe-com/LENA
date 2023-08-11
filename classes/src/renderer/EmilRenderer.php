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
        $out = '';
        
        $this->controller();
        $out .= '<script type="text/javascript">'
                . 'let QU_LENA_BASEURL="' . $this->baseUrl . '";'
                . 'let QU_LENA_TOKEN="' . $_SESSION[ 'qu_lena_token' ] . '";'
                . '</script>';                        
        
        $out .= '<div id="emil">';        
        $out .= '<div id="suggestions"><div class="customBG">';            
        
        
        $response = 'Aufgrund deine aktuellen Einstellungen schlage ich folgendes vor:'; // data->reason
        
        
        $out .= '<div id="response">';
        $out .= '</div>';

        $out .= '<ul id="list">';
        /*
        foreach( $suggestions as $id ) {            
            $out .= // JS-PART
                  '<li class="suggestion">'                
                . '<a href="' . $this->baseUrl . '?add=' . $itemId . '">'
                . 'MLE' . $itemId                 
                . '</a>'
                . '</li>'
                // /JS
            ;
        }
        */
        $out .= '</ul>';
        
        $out .= '</div></div>';
        $out .= '</div>';

	$out .= '<script>';
	$out .= 'let endpoint = "./Customizing/global/plugins/Services/COPage/PageComponent/LENA/classes/api.php";';
	$out .= 'let url = endpoint + "?token=' . $_SESSION[ 'qu_lena_token' ] . '";';  // TODO params
        
	$out .= 'console.log(url);';
	$out .= '$.get(url, function(response) {';
	$out .=     'console.log(response);';
        $out .= '})';
	$out .= '</script>';

        return $out;
    }

    protected function controller() {
        global $DIC;
        $user = $DIC->user();
        $userId = $user->getId();        

        $access = new AccessToken( $userId );
        
        if( isset( $_SESSION[ 'qu_lena_token' ] ) ) {
            $access->destroyToken( $_SESSION[ 'qu_lena_token' ] );
        }
        $token = $access->createToken();
        $_SESSION[ 'qu_lena_token' ] = $token; 
    }
}
