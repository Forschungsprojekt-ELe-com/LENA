<?php

class VisitedRenderer extends Renderer {
    
    /**
     * 
     * @return string
     */
    public function render() {
        $out     = '';
        $data    = $this->visited->getVisitedList();
//        $out .= '<pre>' . print_r( $data, true ) . '</pre>';        

        $temp = array();
        $inArray = array();
        foreach( $data as $id ) {
            if( ! isset( $inArray[ $id ] ) ) {
                $inArray[ $id ] = $id;
                $temp[] = $id;
            }
        }
        /*
        for( $i=( count( $data ) - 1); $i >= 0 ; $i-- ) {
            $id = $data[ $i ];
            if( ! isset( $temp[ $id ] ) ) {
                $temp[] = $id;
            }
        }
        // */
//        $out .= '<pre>' . print_r( $temp, true ) . '</pre>';
        $out .= '<div id="visitedBox">';
        //$out .= '<b>visited</b>';
        $out .= '<ul id="visitedList">';
        foreach( $temp as $id ) {
            $out .= '<li class="visitedItem"><div class="visitedItem">'
                    . '<img src="./data/elecom/custom_icons/obj_' . $id . '/icon_custom.svg" />'
                        
                    . '<a href="' . $this->getUrl( $this->usecase->getRefId( $id ) ) . '">'
                    . $this->usecase->getTitle( $id ) 
                    . '</a>'
                    . '</div>'
                    . '</li>'
            ;
        }
        $out .= '</ul>';
        $out .= '</div>';
        
        return $out;
    }
}