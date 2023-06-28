<?php

class VisitedRenderer extends Renderer {
    
    
    public function render() {
        $out     = '';
        $data    = $this->visited->getVisitedList();
//        $out .= '<pre>' . print_r( $data, true ) . '</pre>';        

        $temp = array();
        for( $i=( count( $data ) - 1); $i >= 0 ; $i-- ) {
            $id = $data[ $i ];
            if( ! isset( $temp[ $id ] ) ) {
                $temp[ $id ] = $id;
            }
        }
//        $out .= '<pre>' . print_r( $temp, true ) . '</pre>';
        $out .= '<div id="visitedBox">';
        //$out .= '<b>visited</b>';
        $out .= '<ul id="visitedList">';
        foreach( $temp as $id ) {
            $out .= '<li class="visitedItem">'
                    . '<a href="' . $this->baseUrl . '?add=' . $id . '">'
                    . 'MLE' . $id 
                    . '</a>'
                    . '</li>'
            ;
        }
        $out .= '</ul>';
        $out .= '</div>';
        
        return $out;
    }
}