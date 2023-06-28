<?php

class UseCase {
    
    /**
     * 
     * @var int
     */
    protected $usecaseNumber;
    
    /**
     * 
     * @var int[]
     */
    protected $refIdList;
    
    /**
     * 
     * @var int[]
     */
    protected $objIdList;
    
    /**
     * 
     * @var string[]
     */
    protected $titles;
    
    
    
    public function __construct( $usecaseNumber, $refIdList = array(), $objIdList = array(), $titles = array() ) {
        $this->usecaseNumber = $usecaseNumber;
        $this->refIdList     = $refIdList;
        $this->objIdList     = $objIdList;
        $this->titles        = $titles;
    }
    
    /**
     * 
     * @param int $crs_obj_id
     * @return int or 0
     */
    public function getRefId( $crs_obj_id ) {
        if( $this->issetObj( $crs_obj_id ) ) {
            return $this->objIdList[ $crs_obj_id ];
        }
        return 0;
    }
    
    /**
     * 
     * @param int $crs_ref_id
     * @return int or 0
     */
    public function getObjId( $crs_ref_id ) {
        if( $this->issetRef( $crs_ref_id ) ) {
            return $this->refIdList[ $crs_ref_id ];
        }
        return 0;
    }
    
    public function getTitle( $crs_obj_id ) {
        if( isset( $this->titles[ $crs_obj_id ] ) ) {
            return $this->titles[ $crs_obj_id ];
        }
        return "";
    }
    
    /**
     * 
     * @param int $crs_ref_id
     * @return bool
     */
    public function issetRef( $crs_ref_id ) {
        return isset( $this->refIdList[ $crs_ref_id ] ); 
    }
    
    /**
     * 
     * @param int $crs_obj_id
     * @return bool
     */
    public function issetObj( $crs_obj_id ) {
        return isset( $this->objIdList[ $crs_obj_id ] ); 
    }
        
    /**
     * 
     * @return string
     */
    public function getObjIdInstring() {
        return implode( ',', $this->objIdList );        
    }
    
    /**
     * 
     * @return string
     */
    public function getRefIdInstring() {
        return implode( ',', $this->refIdList );
    }
    
    /**
     * 
     * @return int[]
     */
    public function getRefIdList() {
        return $this->refIdList;
    }

    /**
     * 
     * @return int[]
     */
    public function getObjIdList() {
        return $this->objIdList;
    }    
    
    /**
     * 
     * @return int
     */
    public function getUsecaseNumber() {
        return $this->usecaseNumber;
    }
}