<?php

class PlannedRenderer extends Renderer {
    
    /**
     * 
     * @return string
     */
    public function render() {
        $planned = Planned::getInstance();
        $out = '';
        $data = $planned->getObjIdList();
        $next = $this->next();
        
        $out .= '<div id="plannedBox">';
        //$out .= '<b>planned</b>';
        $out .= '<ul id="plannedList">';
        foreach( $data as $id ) {
            $notfound = true;
            if( $id == $next ) {
                $out .= '<li class="nextItem">'
                    . '<div class="visitedItem">'
                    . '<img src="./data/elecom/custom_icons/obj_' . $id . '/icon_custom.svg" />'
                    . '<a href="' . $this->getUrl( $this->usecase->getRefId( $id ) ) . '">'
                    . $this->usecase->getTitle( $id ) 
                    . '</a>'
                    . '</div>'
                    . '</li>'
                ;
                $notfound = false;
            }
            
            if( $this->visited->isVisited( $id ) ) {
                $out .= '<li class="visitedItem">'
                    . '<div class="visitedItem">'
                    . '<img src="./data/elecom/custom_icons/obj_' . $id . '/icon_custom.svg" />'
                    . '<a href="' . $this->getUrl( $this->usecase->getRefId( $id ) ) . '">'
                    . $this->usecase->getTitle( $id ) 
                    . '</a>'
                    . '</div>'
                    . '</li>'
                ;
                $notfound = false;
            }
            
            if( $notfound ) {
                $out .= '<li>'
                    . '<div class="visitedItem">'
                    . '<img src="./data/elecom/custom_icons/obj_' . $id . '/icon_custom.svg" />'
                    . '<span>'
                    . $this->usecase->getTitle( $id ) 
                    . '</span>'
                    . '</div></li>'
                ;
            }
        }
        $out .= '</ul>';
        $out .= '</div>';
        return $out;
    }
     
    /**
     * 
     * @return int
     */
    public function next() {
        $next = 0;
        $planned = Planned::getInstance();
        $allIds = $planned->getObjIdList();
        foreach( $allIds as $id ) {
            if( $next > 0 ) {
                continue;
            }
            if( ! $this->visited->isVisited( $id ) ) {
                $next = $id;
            }
        }
        return $next;
    }
}