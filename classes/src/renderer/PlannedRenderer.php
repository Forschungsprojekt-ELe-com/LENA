<?php

class PlannedRenderer extends Renderer {
    


    /**
     * 
     * @return string
     */
    public function render() {
        $out = '';
        $data = $this->journey->getPlanned()->getRefIdList();
        $next = $this->journey->nextElement();
        
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
            
            if( $this->journey->isVisited( $id ) ) {
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
}