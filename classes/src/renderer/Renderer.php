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
}