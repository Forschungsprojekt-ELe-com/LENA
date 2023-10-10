<?php

class VisitedRenderer extends Renderer {
    
    /**
     * 
     * @return string
     */
    public function render() {
        $out     = '';
        $data    = $this->fetchData(); // $this->visited->getVisitedList();
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

        // add debug
        $debug = '';
//        global $DIC;
//        $nav = $DIC["ilNavigationHistory"];
//        $itemList = $nav->getItems();
        $debug .= '<h1>itemlist</h1><pre>' . print_r( $temp, true ) . '</pre>';


        
        return $debug . $out;
    }
    
    protected function fetchData() {
        global $DIC;
        $nav = $DIC["ilNavigationHistory"];
        $itemList = $nav->getItems();
        $refIdList = array();
        foreach( $itemList as $item ) {
            $refIdList[] = $item[ 'id' ];
        }
        return $refIdList;
        
        $usecaseList = array();
        $usecaseList[ 0 ] = UseCaseFactory::createByUsecaseNumber( 1 );
        $usecaseList[ 1 ] = UseCaseFactory::createByUsecaseNumber( 2 );
        $usecaseList[ 2 ] = UseCaseFactory::createByUsecaseNumber( 3 );
        $usecaseList[ 3 ] = UseCaseFactory::createByUsecaseNumber( 4 );
        
        $objIdList = array();
        foreach( $refIdList as $refId ) {
            $found = false;
            foreach( $usecaseList as $usecase ) {
//                if( $found ) {
//                    continue;
//                }
                if( $usecase->issetRef( $refId ) ) {
                    $found = true;
                    $objIdList[] = $usecase->getObjId( $refId );
                }
            }
        }
        return $objIdList;
    }
}