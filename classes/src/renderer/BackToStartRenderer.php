<?php

class BackToStartRenderer extends Renderer {
    
    public function render() {
        $out = '';

        $out .= '<a class="btn btn-bulky" id="back_to_course" ';
        $out .= 'href="goto.php?target=crs_' . $this->backToCourseId . '">';
        $out .= '<img class="icon small" alt="Zur Übersicht" ';
        $out .= 'src="./Customizing/global/plugins/Services/COPage/PageComponent/LENA/templates/css/images/course.svg">';
        $out .= '<span class="bulky-label">Zur Übersicht</span></a>';
        
        //$out .= '<a href="goto.php?target=crs_' . $this->backToCourseId . '" class="btn btn-default">Zur
        // Übersicht</a>';
        
        return $out;
    }
}