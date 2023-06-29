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
                        . '<a href="' . $this->baseUrl . '?add=' . $id . '">'
                        . 'MLE' . $id
                        . '</a>'
                        . '</li>'
                ;
                $notfound = false;
            }
            
            if( $this->visited->isVisited( $id ) ) {
                $out .= '<li class="visitedItem">'
                        . '<a href="' . $this->baseUrl . '?add=' . $id . '">'
                        . 'MLE' . $id
                        . '</a>'
                        . '</li>'
                ;
                $notfound = false;
            }
            
            if( $notfound ) {
                $out .= '<li><span>'
                        . 'MLE' . $id 
                        . '</span></li>'
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
    protected function next() {
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