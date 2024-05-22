<?php

class RendererList extends Renderer {
    
    /**
     *
     * @var Renderer[]
     */
    protected $rendererList = array();
    
    public function render() {
        $out = '';
        $out .= '<script>
$(document).ready(function () {
    $("div.ilc_section_ElecomBlockWrapper").prepend($("#lena_teaser"));
    $("div.ilc_section_ElecomBlockWrapper").prepend($("#lena_spricht"));
    setTimeout(function(){
      $("#delayed_text").show();
    }, 3000);
    setTimeout(function(){
      $("#lena_spricht").remove();
    }, 6000);
	$("#lena_teaser").click(function (event) {
		event.preventDefault();
        $("#lena_teaser").hide();//"slide", {direction: "right" },"1000");
        $("#lena_spricht").detach();
        
		$("#quLenaPluginWrapper").show("slide", {direction: "right" },"1000");
		return false;
	});
    $("#close").click(function (event) {
		event.preventDefault();
		$("#quLenaPluginWrapper").hide("slide", {direction: "right" },"1000");
        $("#lena_teaser").show();//"slide", {direction: "right" },"1000");
		return false;
	});
});
</script>';
        $out .= '<a id="lena_teaser" href="#" class="UC-'
                . $this->usecase->getUsecaseNumber()
                . '"></a>';
        $out .= '<div id="lena_spricht">Hallo!<br/>Ich bin LENA!<br/>';
        $out .= '<span id="delayed_text">Deine persönliche<br/>Assistentin</span></div>';
        $out .= '<div id="quLenaPluginWrapper">';
        $out .= '<div id="quLenaPlugin">';
        $out .= '<a href="#" id="close"></a>';
        foreach( $this->rendererList as $renderer ) {
            $out .= $renderer->render();
        }        
        $out .= '</div>';
        $out .= '</div>';
        return $out;
    }
    
    /**
     * 
     * @param string $baseUrl
     * @return $this
     */
    public function setBaseUrl( $baseUrl ) {
        parent::setBaseUrl( $baseUrl );
        foreach( $this->rendererList as $renderer ) {
            $renderer->setBaseUrl( $baseUrl );
        }    
        return $this;
    }
        
    /**
     * 
     * @param UseCase $usecase
     * @return $this
     */
    public function setUsecase( $usecase ) {
        parent::setUsecase( $usecase );
        foreach( $this->rendererList as $renderer ) {
            $renderer->setUsecase( $usecase );
        }
        return $this;
    }
    
    /**
     * 
     * @param int
     * @return $this
     */
    public function setBackToCourseId( $backToCourseId ) {
        parent::setBackToCourseId( $backToCourseId );
        foreach( $this->rendererList as $renderer ) {
            $renderer->setBackToCourseId( $backToCourseId );
        }             
        return $this;
    }
    
    /**
     * 
     * @param Visited $visited
     * @return $this
     */
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
    
    /**
     * re-sets usecase, baseUrl, visited ...  
     */
    public function reInit() {
        $this->setBaseUrl( $this->baseUrl );
        $this->setUsecase( $this->usecase );
        $this->setVisited( $this->visited );
    }
    
    
    // -------------- convenience methods -----------------------------
    /**
     * 
     * @return $this
     */
    public function addPlannedRenderer() {
        $this->rendererList[] = new PlannedRenderer( $this->db );
        return $this;
    }

    /**
     * 
     * @return $this
     */
    public function addVisitedRenderer() {
        $this->rendererList[] = new VisitedRenderer( $this->db );
        return $this;
    }
    
    /**
     * 
     * @return $this
     */
    public function addEmilRenderer() {
        $this->rendererList[] = new EmilRenderer( $this->db );
        return $this;
    }  
    
    public function addBackRenderer() {
        $this->rendererList[] = new BackToStartRenderer( $this->db );
        return $this;
    }
}