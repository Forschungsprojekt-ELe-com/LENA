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
	$out .= 'let url = endpoint + "?token=' . $_SESSION[ 'qu_lena_token' ] . '&t=' . microtime() . '";';  // TODO params
	$out .= 'console.log(url);';
	$out .= 'document.onload = function () {';

	$out .= 'var getSuggestions = function() {';
	$out .=     '$.get(url, function(response) {';
	$out .=         'console.log(response);';
	$out .=         'if (response.meta.status == "NOK") {';
	$out .=             'setTimeout(function() { getSuggestions(); }, 3000);';
	$out .=             'return;';
	$out .=         '}';
	$out .=         '$("#response").text(response.data.reason);';
	$out .=         'let ulElem = $("#list");';
	$out .=         'ulElem.empty();';
	$out .=         'for (let refid in response.data.titles) {';
	$out .=             'let link = "' . $this->baseUrl . '".replace("666666", refid);';
	$out .=             'let path = "./data/elecom/custom_icons/obj_" + response.data.titles[refid].objid + "/icon_custom.svg";';
	$out .=             'if (response.data.titles[refid].type == "tst") {';
	$out .=                 'link = link.replace("copa", "tst");';
	$out .=                 'path = "./Customizing/global/skin/elecom/images/icon_tst.svg";';
	$out .=             '}';
	$out .=             'let icoElem = $("<img src=\"" + path + "\"/>");';
	$out .=             'let aElem = $("<a href=\"" + link + "\">" + response.data.titles[refid].title + "</a>");';
	$out .=             'let liElem = $("<li class=\"suggestion\"></li>");';
	$out .=             'liElem.append(icoElem);';
	$out .=             'liElem.append(aElem);';
	$out .=             'liElem.children().wrapAll("<div class=\"suggestion\" />");';
	$out .=             'ulElem.append(liElem);';
	$out .=         '}';
	$out .=     '});';
	$out .= '};';

	$out .= 'getSuggestions();';
	$out .= '};';
	$out .= '</script>';

        return $out;
    }

    protected function controller() {
        global $DIC;
        $user = $DIC->user();
        $userId = $user->getId();        

        $access = new AccessToken( $userId, $this->usecase->getUsecaseNumber() );
        
        if( isset( $_SESSION[ 'qu_lena_token' ] ) ) {
            $access->destroyToken( $_SESSION[ 'qu_lena_token' ] );
        }
        $token = $access->createToken();
        $_SESSION[ 'qu_lena_token' ] = $token; 
    }
}
