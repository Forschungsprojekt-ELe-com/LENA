<?php

class PlannedRenderer extends Renderer {
    
    /**
     * 
     * @return string
     */
    public function render() {
        $planned = Planned::getInstance();
        $out = '';
//        $data = $planned->getObjIdList();
        $data = $planned->getPlannedList();
        $next = $this->next();
        $parentList = $this->usecase->getParents();
        
        $oldTitle = '';
        $out .= '<div id="plannedBox">';
        //$out .= '<b>planned</b>';
        $out .= '<ul id="plannedList">';
//        foreach( $data as $id ) {
        foreach( $data as $id => $ref_id ) {
            $title = $this->usecase->getTitle( $parentList[ $id ] );
            if( $oldTitle != $title ) {
                if( strlen( $oldTitle ) > 0 ) {
                    $out .= '</ul></div></li>';
                }
                $out .= '<li class="heading"><div><span class="block_heading">' . $title . '</span><ul>';
            }
            $oldTitle = $title;
            
            $notfound = true;
            
            if(    $notfound 
                && ( $this->usecase->isCurrent( $ref_id ) )
            ) {
                $out .= $this->renderElement( $id, $ref_id, 'currentItem' );                
                $notfound = false;
            }
            
            if(    $notfound 
                && ( $id == $next )
            ) {
                $out .= $this->renderElement( $id, $ref_id, 'nextItem' );                
                $notfound = false;
            }
            
            if(    $notfound 
                && ( $this->visited->isVisited( $id ) )
            ) {
                $out .= $this->renderElement( $id, $ref_id, 'visitedItem' );                                
                $notfound = false;
            }
            
            if( $notfound ) {
                $out .= '<li>'
                    . '<div class="visitedItem">';
                
                if( $this->usecase->isTest( $ref_id ) ) {
                    $out .= '<img src="./Customizing/global/skin/elecom/images/icon_tst.svg">';
                } else {
                    $out .= '<img src="./data/elecom/custom_icons/obj_' . $id . '/icon_custom.svg" />';
                }
                
                $out .= '<span>'
                    . $this->usecase->getTitle( $ref_id )
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
    
    /**
     * 
     * @param int $id
     * @param int $ref_id
     * @param string $title
     * @return string
     */
    protected function renderElement( $id, $ref_id, $title ) {
        $out = '';
        $out .= '<li class="' . $title . '">'
            . '<div class="visitedItem">';                                    
        if( $this->usecase->isTest( $ref_id ) ) {
            $out .= '<img src="./Customizing/global/skin/elecom/images/icon_tst.svg">';
        } else {
            $out .= '<img src="./data/elecom/custom_icons/obj_' . $id . '/icon_custom.svg" />';
        }

        $out .= '<a href="' . $this->getUrl( $ref_id, $this->usecase->isTest( $ref_id ) ) . '">'
            . $this->usecase->getTitle( $ref_id )
            . '</a>'
            . '</div>'
            . '</li>'
        ;
        return $out;
    }
}