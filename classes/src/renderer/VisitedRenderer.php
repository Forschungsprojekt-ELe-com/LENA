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

//        $out .= '<pre>' . print_r( $temp, true ) . '</pre>';
        $out .= '<div id="visitedBox">';
        //$out .= '<b>visited</b>';
        $out .= '<ul id="visitedList">';
        foreach( $temp as $id ) {
            $out .= '<li class="visitedItem"><div class="visitedItem">';
            if( $this->usecase->isTest( $this->usecase->getRefId( $id ) ) ) {
                $out .= '<img src="./Customizing/global/skin/elecom/images/icon_tst.svg">';
            } else {
                $out .= '<img src="./data/elecom/custom_icons/obj_' . $id . '/icon_custom.svg" />';
            }                
                        
            $out .= ''
                    . '<a href="' . $this->getUrl( $this->usecase->getRefId( $id ) ) . '">'
                    . $this->usecase->getTitle( $this->usecase->getRefId( $id ) )
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