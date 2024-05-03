<?php

abstract class Renderer {
    
    /**
     * pls implement
     * 
     * @return string
     */
    abstract public function render();


    
    protected $db;
    
    /**
     *
     * @var string
     */
    protected $baseUrl = '';
    
    /**
     * 
     * @var UseCase
     */
    protected $usecase = null;
    
    /**
     * 
     * @var Visited
     */
    protected $visited = null;
    
    /**
     * 
     * @var int
     */
    protected $backToCourseId;
    
    
    /**
     * 
     * @param type $db
     */
    public function __construct( $db ) {
        $this->db = $db;
    }
    
    /**
     * 
     * @param string $baseUrl
     * @return $this
     */
    public function setBaseUrl( $baseUrl ) {
        $this->baseUrl = $baseUrl;
        return $this;
    }
    
    /**
     * 
     * @param UseCase $usecase
     * @return $this
     */
    public function setUsecase( $usecase ) {
        $this->usecase = $usecase;
        return $this;
    }
    
    /**
     * 
     * @param Visited $visited
     * @return $this
     */
    public function setVisited( $visited ) {
        $this->visited = $visited;
        return $this;
    }
    
    /**
     * 
     * @param int
     * @return $this
     */
    public function setBackToCourseId( $backToCourseId ) {
        $this->backToCourseId = $backToCourseId;
        return $this;
    }

    /**
     *
     * @param int $ref_id
     * @param bool $is_test
     * @return string
     */
    protected function getUrl(int $ref_id , $is_test = false ): string
    {
        if ( $is_test ) {
            return str_replace( 'copa_666666', 'tst_' . $ref_id, $this->baseUrl );
        }
        return str_replace( '666666', $ref_id, $this->baseUrl );
    }
}