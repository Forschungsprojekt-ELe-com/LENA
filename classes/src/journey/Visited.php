<?php


class Visited {
    
    /**
     * 
     * @var int[]
     */
    protected $visited;
    
    /**
     * 
     * @var int[]
     */
    protected $lookup;
    
    /**
     * 
     * @param int[] $visited
     */
    public function __construct( $visited = array() ) {
        $this->setRawData( $visited );
    }
    
    /**
     * 
     * @param int[] $visited
     * @return Visited $this
     */
    public function setRawData( $visited = array() ) {
        $this->visited = $visited;
        $temp = array();
        foreach( $this->visited as $item ) {
            $temp[ $item ] = $item;
        }
        $this->lookup = $temp;
        return $this;
    }
    
    /**
     * 
     * @param int $course_obj_id
     * @return bool
     */
    public function isVisited( $course_obj_id ) {
        return isset( $this->lookup[ $course_obj_id ] );
    }
    
    /**
     * 
     * @return int[]
     */
    public function getVisitedList() {
        return $this->visited;
    }    
}