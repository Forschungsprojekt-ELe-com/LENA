<?php

class EmilRenderer extends Renderer {
    
    /**
     * 
     * @return int[]
     */
    protected function getEmil( $count, $optionCount) {
        if( $count < $optionCount ) {
            $optionCount = $count;
        }
        $out = array();
        for( $i=0; $i<$optionCount; ++$i ) {
         
            $notFound = true;
            while( $notFound ) {
                $random = rand( 0, $count );
                if( ! isset( $out[ $random ] ) ) {
                    $out[ $random ] = $random;
                    $notFound = false;
                }
            }
        }
        
        return $out;
    }
    
    public function render() {
        $out = '';
        $out .= '<div id="emil">';

        $notVisited = array();
        for( $i=1; $i<21; ++$i ) {
            if( ! $this->journey->isVisited( $i ) ) {
                $notVisited[] = $i;
            }
        }   
        
        $out .= '<div id="suggestions"><div class="customBG">';            
        //$out .= '<b>emil</b>';
        
        $response = 'Aufgrund deine aktuellen Einstellungen schlage ich folgendes vor:';
        if( count( $notVisited ) == 1 ) {
            $response = '<b>finished</b>';
        }         
        $out .= '<div id="response">';
        $out .= $response;
        $out .= '</div>';
        
        
        
        //echo '<pre>', print_r( $notVisited, true ), '</pre>';
        if( count( $notVisited ) > 1 ) {
            
            $out .= '<ul id="list">';

            $suggestions = $this->getEmil( ( count( $notVisited ) - 1 ), 3 );
            foreach( $suggestions as $id ) {
                $itemId = $notVisited[ $id ];
                $out .= '<li class="suggestion"><a href="' . $this->baseUrl . '?add=' . $itemId . '">'
                     . 'MLE' . $itemId 
                    . '</a></li>'
                ;
            }
            
            
            $out .= '</ul';
            
        }
        
        $out .= '</div></div>';
        $out .= '</div>';
        
        return $out;
    }

}