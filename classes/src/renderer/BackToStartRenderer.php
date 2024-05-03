<?php

class BackToStartRenderer extends Renderer {
    
    public function render() {
        $out = '';
                
        $out .= '<a href="goto.php?target=crs_' . $this->backToCourseId . '">back</a>';
        
        return $out;
    }
}