<?php

class RendererList extends Renderer {
    
    /**
     *
     * @var array
     */
    protected $rendererList = array();
    
    public function render() {
        $out = '';
        $out .= '<div id="quLenaPlugin">';
        foreach( $this->rendererList as $renderer ) {
            $out .= $renderer->render();
        }        
        $out .= '</div>';
        return $out;
    }
    
    public function setBaseUrl( $baseUrl ) {
        parent::setBaseUrl( $baseUrl );
        foreach( $this->rendererList as $renderer ) {
            $renderer->setBaseUrl( $baseUrl );
        }    
        return $this;
    }
        
    public function setUsecase( $usecase ) {
        parent::setUsecase( $usecase );
        foreach( $this->rendererList as $renderer ) {
            $renderer->setUsecase( $usecase );
        }
        return $this;
    }
    
    public function setVisited( $visited ) {
        parent::setVisited( $visited );
        foreach( $this->rendererList as $renderer ) {
            $renderer->setVisited( $visited );
        }
        return $this;
    }
    
    /**
     * 
     * @param Renderer $renderer
     */
    public function add( $renderer ) {
        $this->rendererList[] = $renderer;
    }
    
    
    // convenience methods
    public function addPlanned() {
        $this->rendererList[] = new PlannedRenderer( $this->db );
        return $this;
    }

    public function addVisited() {
        $this->rendererList[] = new VisitedRenderer( $this->db );
        return $this;
    }
    
    public function addEmil() {
        $this->rendererList[] = new EmilRenderer( $this->db );
        return $this;
    }        
}