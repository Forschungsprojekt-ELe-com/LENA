<?php

abstract class Renderer {
    
    /**
     * pls implement
     * 
     * @return string
     */
    abstract public function render();
    
    /**
     *
     * @var string
     */
    protected $baseUrl = '';
    
    /**
     *
     * @var CustomerJourney 
     */
    protected $journey;
    
    public function __construct( CustomerJourney $journey ) {
        $this->journey = $journey;
    }
    
    /**
     * 
     * @param string $baseUrl
     */
    public function setBaseUrl( string $baseUrl ) {
        $this->baseUrl = $baseUrl;
        return $this;
    }
}