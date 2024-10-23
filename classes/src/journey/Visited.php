<?php


class Visited {
    
    /**
     * 
     * @var int[]
     */
    protected array $visited;
    
    /**
     * 
     * @var int[]
     */
    protected array $lookup;
    
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
    public function setRawData( array $visited = array() ): Visited {
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
    public function isVisited( int $course_obj_id ): bool {
        return isset( $this->lookup[ $course_obj_id ] );
    }
    
    /**
     * 
     * @return int[]
     */
    public function getVisitedList(): array {
        return $this->visited;
    }    
}