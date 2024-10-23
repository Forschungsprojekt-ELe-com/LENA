<?php

class UseCase {
    
    /**
     * 
     * @var int
     */
    protected int $usecaseNumber;
    
    /**
     * 
     * @var int[] $ref => $obj
     */
    protected array $refIdList;
    
    /**
     * 
     * @var int[] $obj => $ref
     */
    protected array $objIdList;
    
    /**
     * 
     * @var string[] $obj => $title
     */
    protected array $titles;
    
    /**
     * 
     * @var int[] child_obj_id => parent_obj_id
     */
    protected array $parentList;

    /**
     * 
     * @var int[]
     */
    protected array $testList;
    
    
    /**
     * 
     * @param int $usecaseNumber
     * @param int[] $refIdList $ref => $obj
     * @param int[] $objIdList $obj => $ref
     * @param string[] $titles
     */
    public function __construct( 
              int $usecaseNumber
            , array $refIdList = array()
            , array $objIdList = array()
            , array $titles = array()
            , array $parentList = array() 
            , array $testList = array() 
        ): void {
        $this->usecaseNumber = $usecaseNumber;
        $this->refIdList     = $refIdList;
        $this->objIdList     = $objIdList;
        $this->titles        = $titles;
        $this->parentList    = $parentList;
        $this->testList      = $testList;
    }
    
    /**
     * 
     * @param int $ref_id
     * @return bool
     */
    public function isTest( int $ref_id = 0 ): bool {
        return isset( $this->testList[ $ref_id ] );
    }
    
    /**
     * 
     * @param int $crs_obj_id
     * @return int or 0
     */
    public function getRefId( int $crs_obj_id ): int {
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
    public function getObjId( int $crs_ref_id ): int {
        if( $this->issetRef( $crs_ref_id ) ) {
            return $this->refIdList[ $crs_ref_id ];
        }
        return 0;
    }
    
    /**
     * 
     * @param int $crs_ref_id
     * @param string $emil_id
     * @return string
     */
    public function getTitle( int $crs_ref_id, string $emil_id='' ): string {
        if( isset( $this->titles[ $crs_ref_id ] ) ) {
            return $this->titles[ $crs_ref_id ];
        }
        return 'NO_TITLE_FOR:' . $emil_id . '!';
    }
    
    /**
     * 
     * @param int $crs_ref_id
     * @return bool
     */
    public function issetRef( int $crs_ref_id ): bool {
        return isset( $this->refIdList[ $crs_ref_id ] ); 
    }
    
    /**
     * 
     * @param int $crs_obj_id
     * @return bool
     */
    public function issetObj( int $crs_obj_id ): bool {
        return isset( $this->objIdList[ $crs_obj_id ] ); 
    }
        
    /**
     * 
     * @return string
     */
    public function getObjIdInstring(): string {
        return implode( ',', array_keys( $this->objIdList ) );        
    }
    
    /**
     * 
     * @return string
     */
    public function getRefIdInstring(): string {
        return implode( ',', array_keys( $this->refIdList ) );
    }
    
    /**
     * 
     * @return int[]
     */
    public function getRefIdList(): array {
        return $this->refIdList;
    }

    /**
     * 
     * @return int[]
     */
    public function getObjIdList(): array {
        return $this->objIdList;
    }    
    
    /**
     * 
     * @return int
     */
    public function getUsecaseNumber(): array {
        return $this->usecaseNumber;
    }
    
    /**
     * 
     * @return int[]
     */
    public function getParents(): array {
        return $this->parentList;
    }
    
    /**
     * 
     * @param int $ref_id
     * @return bool
     */
    public function isCurrent(int $ref_id = 0 ): bool
    {
        return ( ( isset( $_REQUEST[ 'ref_id' ] ) )
                && ( $_REQUEST[ 'ref_id' ] == $ref_id ) )
        ;
    }

    public function getType(int $ref_id): string
    {
        if ($this->isTest($ref_id)) {
            return "tst";
        }
        return "";
    }
}
