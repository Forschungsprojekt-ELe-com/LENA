<?php

class UseCase {
    
    /**
     * 
     * @var int
     */
    protected $usecaseNumber;
    
    /**
     * 
     * @var int[] $ref => $obj
     */
    protected $refIdList;
    
    /**
     * 
     * @var int[] $obj => $ref
     */
    protected $objIdList;
    
    /**
     * 
     * @var string[] $obj => $title
     */
    protected $titles;
    
    /**
     * 
     * @var int[] child_obj_id => parent_obj_id
     */
    protected $parentList;
    
    
    /**
     * 
     * @param int $usecaseNumber
     * @param int[] $refIdList $ref => $obj
     * @param int[] $objIdList $obj => $ref
     * @param string[] $titles
     */
    public function __construct( $usecaseNumber, $refIdList = array(), $objIdList = array(), $titles = array(), $parentList = array() ) {
        $this->usecaseNumber = $usecaseNumber;
        $this->refIdList     = $refIdList;
        $this->objIdList     = $objIdList;
        $this->titles        = $titles;
        $this->parentList    = $headings;
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
    
    /**
     * 
     * @param int $crs_obj_id
     * @return string
     */
    public function getTitle( $crs_obj_id ) {
        if( isset( $this->titles[ $crs_obj_id ] ) ) {
            return $this->titles[ $crs_obj_id ];
        }
        return 'NO_TITLE_FOR:' . $crs_obj_id . '!';
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
        return implode( ',', array_keys( $this->objIdList ) );        
    }
    
    /**
     * 
     * @return string
     */
    public function getRefIdInstring() {
        return implode( ',', array_keys( $this->refIdList ) );
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
    
    /**
     * 
     * @return int[]
     */
    public function getParents() {
        return $this->parentList;
    }
}
