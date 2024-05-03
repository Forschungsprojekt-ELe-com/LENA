<?php

class BackToStartRenderer extends Renderer {
    
    public function render() {
        $out = '';
                
        $out .= '<a href="goto.php?target=crs_' . $this->backToCourseId . '" class="btn btn-default">Zur Übersicht</a>';
        
        return $out;
    }
}