<?php 
/**
 * The dataObject class handles the connection methods 
 * It also communicate with database directly .
 */
//include('../include/config.inc.php') ;

 abstract class dataObject{
     protected $conn ;

     #function to establish connection 
     public function connect(){
         #connection to database using PDO
         try{
             $this->conn = new PDO(DB_DSN , DB_USERNAME , DB_PASSWORD) ;
             $this->conn->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION) ;
         }catch(PDOException $errorMsg){
             echo '<h2>Failed to connect to database .</h2>'.$errorMsg ;
         }

         return $this->conn ;
     }
     #function to destroy connection after use
     public function disconnect(){
         $this->conn = "" ;
         //die("connection died") ;
     }
 }//end of class

 class demo extends dataObject{
     public $dbconn ;

     public function testConnection(){
         $this->dbconn = Parent::connect() ;
         
         if($this->dbconn)
            echo "connection established..." ;
        else
            echo "connection not established..." ;

         print_r( $this->dbconn );
     }
 }//end of class 

 //$test = new demo() ;
 //$test->testConnection() ;
 //$test->disconnect() ;
?>