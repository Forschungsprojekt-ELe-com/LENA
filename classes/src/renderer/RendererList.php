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
    
    public function setBaseUrl( string $baseUrl ) {
        foreach( $this->rendererList as $renderer ) {
            $renderer->setBaseUrl( $baseUrl );
        }    
        return $this;
    }
    
    public function addPlanned() {
        $this->rendererList[] = new PlannedRenderer( $this->journey );
        return $this;
    }

    public function addVisited() {
        $this->rendererList[] = new VisitedRenderer( $this->journey );
        return $this;
    }
    
    public function addEmil() {
        $this->rendererList[] = new EmilRenderer( $this->journey );
        return $this;
    }
}