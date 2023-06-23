<?php
class MyIliasPDOStatement extends PDOStatement {
    
    /**
     * 
     * @var PDOStatement
     */
    protected $result;
    
    /**
     * 
     * @param PDOStatement $pdoResult
     */
    public function __construct( $pdoResult ) {
        $this->result = $pdoResult;
    }
    
    /**
     * 
     * @return PDOStatement
     */
    public function getPDOStatement() {
        return $this->result;
    }
    
    /**
     * 
     * @return array(key => value)
     */
    public function fetchAssoc() {
        return $this->result->fetch( PDO::FETCH_ASSOC );
    }    
    
    /**
     * delegate to $this->result
     */
    public function __call( $name, $args ) {
        if( count( $args ) == 0 ) {
            return $this->result->$name();
        }
        if( count( $args ) == 1 ) {
            return $this->result->$name( $args[ 0 ] );
        }
        if( count( $args ) == 2 ) {
            return $this->result->$name( $args[ 0 ], $args[ 1 ] );
        }
        if( count( $args ) == 3 ) {
            return $this->result->$name( $args[ 0 ], $args[ 1 ], $args[ 2 ] );
        }
    }
}


class MyIliasPDO extends PDO {
    
    /**
     * 
     * @param string $sql
     * @return \MyIliasPDOStatement
     */
    public function query( $sql ) {
        $result = parent::query( $sql );
        return new MyIliasPDOStatement( $result );
    }
    
    /**
     * factory for MyIliasPDOs from dic-connections
     * 
     * @param ilDB $dicDatabaseConnection
     * @return \MyIliasPDO
     */
    public static function fromDICdatabase( $dicDatabaseConnection ) {
        return new MyIliasPDO( 
              $dicDatabaseConnection->getDsn()
            , $dicDatabaseConnection->getUsername()
            , $dicDatabaseConnection->getPassword()            
        );
    }
}

