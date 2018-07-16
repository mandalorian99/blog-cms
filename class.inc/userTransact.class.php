<?php 
/**
 * This script handle all the user transaction  
 * Like login , logout , create new account , modify existing acount
 */

 /**
  * imoporting database configuration file 
  */
 include_once('include/config.inc.php')  ;
 include_once('dataObject.class.php') ;
/**
 * class to handle login and authrization 
 */
 class login extends dataObject{
     
     private $tableName = 'cms_users';
     private $redirect ='cms_index.php' ;

     public function checkLogin(){
         #connecting to database
         $dbconn = Parent::connect() ; 
         #die if not connected to db
         if(!$dbconn)
            die("<h2>OOP's Something went wrong !!!</h2>") ;

        #fetching values from form 
        $email    = $_POST['email'] ;
        $password = $_POST['password'] ;

        #sql to check login 
        $sql = "SELECT * FROM cms_users WHERE email = :USER_EMAIL and password=:USER_PASSWORD "  ;

        #preparing and executing query 
        try{
            $st = $dbconn->prepare( $sql ) ;
         
            //$st->bindValue(":TBL_NAME" , $this->tableName , PDO::PARAM_STR) ; //GIVING ERROR
            $st->bindValue(":USER_EMAIL" , $email , PDO::PARAM_STR) ;
            $st->bindValue(":USER_PASSWORD" , $password , PDO::PARAM_STR) ;
    
            $st->execute() ;

            $row = $st->fetch() ;
            extract($row) ;
            /**
             * Authenticating user
             */

             if( $st->rowCount() >=1 ){
                /**
                 * login  is successfull thus writing 
                 * userId , name and acceess level to
                 *  sessions
                 */
                session_start() ;

                $_SESSION['user_id'] = $user_id ;
                $_SESSION['user_name'] = $name ;
                $_SESSION['user_access_level'] = $access_level ;
                $_SESSION['loginFlag'] =1 ;
                print_r($_SESSION) ;
                if(!headers_sent())
                    header('Location:'.$this->redirect) ;
                
             }else{
                die("Authentication failed!!!" );
                $_SESSION = array() ;
                Parent::disconnect() ;
             }
                

            //print_r($row) ;
        }catch(PDOException $errorMsg){
            die("<h2>Query failed to execute: </h2>".$errorMsg->getMessage() ) ;
        }
     }//method end
 }//end of class


 /**
  * class to create new account
  */

  class creatAccount extends dataObject{
      //private $requireFields = array() ;
      private $tableName = 'cms_users' ;
      private $redirect  = 'cms_login.php' ;

      public function processForm(){
          /**
           * connecting to database 
           */
          $dbconn = Parent::connect() ;

          if(!$dbconn)
            die('<h1>something went wrong!!!</h1>') ;

          
          /**
           * fetching and sanitazing form values 
           */
           $name          = $_POST['username'] ;
           $user_email    = $_POST['email'] ;
           $user_password = $_POST['password'] ;

          /**
           * inserting into database 
           */

           $sql = "INSERT INTO cms_users ( email , password , name ) 
                   VALUES(:EMAIL , :PASSWORD , :NAME )
           " ;

           try{

           /**
            * preparing PDO object to work with sql query 
            */
            $st = $dbconn->prepare($sql) ;
            //$st->bindValue(":TBL_NAME" ,$this->tableName) ;
            $st->bindValue(":EMAIL" ,$user_email) ;
            $st->bindValue(":PASSWORD" ,$user_password) ;
            $st->bindValue(":NAME" ,$name) ;

            $st->execute() ;

            echo'<h2>Your account is created successfully!!!login to enjoy content</h2>';
            Parent::disconnect() ;
            /**
             * redirect to login page 
             */
            if(!headers_sent())
                header('Location:'.$this->redirect) ;
          }catch(PDOException $errorMsg){
              die(" query failed - Error message:".$errorMsg->getMessage() );
          }//end catch
          
      }//end method
  }//end of class

 /**
  * Class to modify account 
  */

 
 /**
  * class to send reminder
  */

 
 /**
  * class to change my info 
  */

 
 /**
  * Class to handle logout
  */

 /**
  * class to display list of members 
  */

  class Member extends dataObject{
      private $memberData = array() ;
      const TBL_MEMBER ='cms_users' ;
      private $redirect = 'cms_admin.php' ;

      public function getMembers($startRow , $endRow , $order){
          #connecting to database 
          $dbconn = Parent::connect() ;

          $sql = 'SELECT SQL_CALC_FOUND_ROWS user_id , email , name , access_level 
                  FROM cms_users ORDER BY :ORDER LIMIT :startRow , :endRow 
          ';

          try{
              $st = $dbconn->prepare($sql) ;
              $st->bindValue(':ORDER',$order ,PDO::PARAM_STR) ;
              $st->bindValue(':startRow',$startRow , PDO::PARAM_INT) ;
              $st->bindValue(':endRow',$endRow , PDO::PARAM_INT) ;

              $st->execute() ;

              $row = $st->fetchAll(PDO::FETCH_ASSOC) ;
              Parent::disconnect() ;
              //print_r($row) ;
          }catch(PDOExecption $e){
              echo"query failed to execute:".$e->getMessage() ;
          }

          return $row ;
      }

      public function getMember( $id =1 ){
          /**
           * connecting to database 
           */
          $dbconn = Parent::connect() ;

          //sql 
          $sql = 'SELECT user_id , email , name , access_level 
                  FROM cms_users
                  WHERE user_id = :ID ';
          try{
              //evoking database object to work on sql 
              $st = $dbconn->prepare( $sql ) ;
              $st->bindValue(':ID' , $id ,PDO::PARAM_INT) ;

              $st->execute() ;

              $row = $st->fetch(PDO::FETCH_ASSOC) ;

              return $row ;
          }catch(PDOException $e){
              die( "OOps query failed to execute--".$e->getMessage() ) ;
          }
      }

      public function modifyAccount(){
        /**
         * connecting to database 
         */
        $dbconn = Parent::connect() ;

        if(!$dbconn)
          die('<h1>something went wrong!!!</h1>') ;

        
        /**
         * fetching and sanitazing form values 
         */
         $user_id       = $_POST['user_id'] ;
         $name          = $_POST['username'] ;
         $user_email    = $_POST['email'] ;
         $access_level = $_POST['access_level'] ;
            var_dump($_POST) ;
        /**
         * inserting into database 
         */

         $sql = 'UPDATE cms_users SET name = :NAME , email = :EMAIL , access_level = :AC 
                WHERE user_id = :ID  ' ;

         try{

         /**
          * preparing PDO object to work with sql query 
          */
          $st = $dbconn->prepare($sql) ;
          //$st->bindValue(":TBL_NAME" ,$this->tableName) ;
          $st->bindValue(":EMAIL" ,$user_email) ;
          $st->bindValue(":AC" ,$access_level) ;
          $st->bindValue(":NAME" ,$name) ;
          $st->bindValue(":ID" ,$user_id) ;

          $st->execute() ;

          echo '<h2>Your account is updated successfully </h2>'  ;
          Parent::disconnect() ;
          /**
           * redirect to login page 
           */
          //if(!headers_sent())
              header('Location:'.$this->redirect) ; #redirect not working check later
        }catch(PDOException $errorMsg){
            die(" query failed - Error message:".$errorMsg->getMessage() );
        }//end catch
        
    }//end method

  }//end of class

 /**
  * Main loginc of script
  */

 #evoking transactUser object 
 //$user = new login() ;

 //$user->checkLogin() ;
?>