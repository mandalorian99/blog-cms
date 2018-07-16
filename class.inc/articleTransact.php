<?php 
/**
 * This script have classes to handle all the article realted operation
 * Each class is called by cms_transact_article page Based upon what 
 * type of request is coming
 */

 require_once('include/config.inc.php') ;
 require_once('dataObject.class.php') ;


 /**
  * Class to handle all the article transactions 
  */
 class articleTransact extends dataObject{
     private $article_id ;
     private $user_id ;
     private $title ;
     private $text ;
     private $submit_date ;
     private $publish_date ;
     private $is_published ;
     const  TBL_NAME = 'cms_article' ;
     /**
      * methods of class
      */

     public function compose(){
         //connecting to databse 
         $dbconn = Parent::connect() ;         

         //fetching form data 
         $this->user_id = $_POST['user_id'] ;
         $this->title  = $_POST['article_title'] ;
         $this->text = $_POST['article_txt'] ;
         $this->submit_date = date('Y-m-d H:i:s') ;

         //var_dump($_POST) ;
         //die("stop") ;
         $sql = 'INSERT INTO cms_article ( user_id , submit_date , title , article_text )
                 VALUES(:ID , :SUBMIT_DATE , :TITLE , :ARTICLE_TEXT)
         ';

         try{
            //preparing statement object
            $st = $dbconn->prepare($sql) ;
            $st->bindValue(':ID' , $this->user_id ,PDO::PARAM_INT ) ;
            $st->bindValue(':SUBMIT_DATE' , $this->submit_date ,PDO::PARAM_STR ) ;
            $st->bindValue(':TITLE' , $this->title ,PDO::PARAM_STR) ;
            $st->bindValue(':ARTICLE_TEXT' , $this->text ,PDO::PARAM_STR ) ;

            if( !$st->execute() ){
                Parent::disconnect() ;
                die("<h2>oops something went wrong...</h2>") ;
            }
            Parent::disconnect() ;
            articleTransact::displayThanks("Your article submitted successfully .Awaiting for admin approvel") ;

         }catch(PDOException $e){
             die("query failed to execute..".$e->getMessage() ) ;
         }
     }

     /**
      * edit article
      */

      public function editArticle(){
         //connecting to databse 
         $dbconn = Parent::connect() ;         

         //fetching form data 
         $this->article_id = $_POST['article_id'] ;
         $this->user_id = $_POST['user_id'] ;
         $this->title  = $_POST['article_title'] ;
         $this->text = $_POST['article_text'] ;
         //$this->submit_date = date('Y-m-d H:i:s') ;

         //var_dump($_POST) ;
         //die("stop") ;
         $sql = 'UPDATE cms_article  
                 SET 
                     title = :TITLE ,
                     article_text = :ARTICLE_TEXT 
                 WHERE article_id =:ARTICLE_ID
         ';

         try{
            //preparing statement object
            $st = $dbconn->prepare($sql) ;
           // $st->bindValue(':ID' , $this->user_id ,PDO::PARAM_INT ) ;
           // $st->bindValue(':SUBMIT_DATE' , $this->submit_date ,PDO::PARAM_STR ) ;
            $st->bindValue(':TITLE' , $this->title ,PDO::PARAM_STR) ;
            $st->bindValue(':ARTICLE_TEXT' , $this->text ,PDO::PARAM_STR ) ;
            $st->bindValue(':ARTICLE_ID',$this->article_id) ;

            if( !$st->execute() ){
                Parent::disconnect() ;
                die("<h2>oops something went wrong...</h2>") ;
            }
            Parent::disconnect() ;
            articleTransact::displayThanks("your article edited successfully") ;

         }catch(PDOException $e){
             die("query failed to execute..".$e->getMessage() ) ;
         }
 
      }//EOF

      /**
       * Publishing article 
       */
      public function publishArticle(){
        //connecting to databse 
        $dbconn = Parent::connect() ;         

        //fetching form data 
        $this->article_id = $_POST['article_id'] ;
        $this->user_id = $_POST['user_id'] ;
        $this->is_published = 1 ;
        $this->publish_date = date('Y-m-d H:i:s') ;

        $sql = 'UPDATE cms_article  
                SET 
                    is_published = :IS_PUBLISHED ,
                    publish_date = :PUBLISH_DATE
                WHERE article_id =:ARTICLE_ID
        ';

        try{
           //preparing statement object
           $st = $dbconn->prepare($sql) ;
           $st->bindValue(':ARTICLE_ID' , $this->article_id ,PDO::PARAM_INT ) ;
           $st->bindValue(':PUBLISH_DATE' , $this->publish_date ,PDO::PARAM_STR ) ;
           $st->bindValue(':IS_PUBLISHED',$this->is_published) ;

           if( !$st->execute() ){
               Parent::disconnect() ;
               die("<h2>oops something went wrong...</h2>") ;
           }
           Parent::disconnect() ;
           articleTransact::displayThanks("your article published successfully") ;

        }catch(PDOException $e){
            die("query failed to execute..".$e->getMessage() ) ;
        }

      }//EOF

     /**
       * retract or unpublish article
       */
      public function retractArticle(){
        //connecting to databse 
        $dbconn = Parent::connect() ;         

        //fetching form data 
        $this->article_id = $_POST['article_id'] ;
        $this->user_id = $_POST['user_id'] ;
        $this->is_published = 0 ;
        $this->publish_date = '0000-00-00 00:00:00' ;

        $sql = 'UPDATE cms_article  
                SET 
                    is_published = :IS_PUBLISHED ,
                    publish_date = :PUBLISH_DATE
                WHERE article_id =:ARTICLE_ID
        ';

        try{
           //preparing statement object
           $st = $dbconn->prepare($sql) ;
           $st->bindValue(':ARTICLE_ID' , $this->article_id ,PDO::PARAM_INT ) ;
           $st->bindValue(':PUBLISH_DATE' , $this->publish_date ,PDO::PARAM_STR ) ;
           $st->bindValue(':IS_PUBLISHED',$this->is_published) ;

           if( !$st->execute() ){
               Parent::disconnect() ;
               die("<h2>oops something went wrong...</h2>") ;
           }
           Parent::disconnect() ;
           articleTransact::displayThanks("your article unpublished successfully") ;

        }catch(PDOException $e){
            die("query failed to execute..".$e->getMessage() ) ;
        }

      }//EOF

      /**
       * Delete article 
       */

       public function deleteArticle(){
           //connecting to database 
           $dbconn = Parent::connect() ;
           $this->article_id = $_POST['article_id'] ;
           var_dump($_POST) ;

           if( isset( $_POST['action'] ) ){
               $sql = 'DELETE c , a FROM cms_comments c 
                       LEFT JOIN cms_article a 
                       ON c.article_id = a.article_id AND a.is_published =0
                       WHERE c.article_id = '.$this->article_id.' 
               '; 

               try{
                   //preparing statement to work with sql 
                   $st = $dbconn->prepare( $sql ) ;
                   if($st->execute() )
                     echo'<h2>article deleted successfully....</h2>' ;
               }catch(PDOException $e){
                   Parent::disconnect() ;
                   die( "something went wrong..".$e->getMessage() ) ;
               }
           }
       }//EOF


     static function displayThanks( $message){
         echo'<div style="width:700px ;height:150px;margin:0 auto ;background-color:red;padding:0 auto">';
            echo'<h2>'.$message.'</h2>';
         echo'</div>';
     }

     /**
      * method to display the list of pending article and published article
      */

      public function displayArticleList(){
          $dbconn = Parent::connect() ;

          $sql = 'SELECT SQL_CALC_FOUND_ROWS
                    article_id , user_id , is_published , title , UNIX_TIMESTAMP( submit_date ) AS submit_date 
                  FROM cms_article ORDER BY submit_date DESC
                 ';
          try{
              /**
               * Preparing statement object to work with sql
               */
              $st = $dbconn->prepare( $sql ) ;
              $st->execute() ;

              $row = $st->fetchAll(PDO::FETCH_ASSOC) ;
              Parent::disconnect() ;

              return $row ;
          }catch( PDOException $e ){
              Parent::disconnect() ;
              die("query failed to execute::".$e->getMessage() ) ;
          }
      }//EOF

      /**
       * method to retrieve article via article ID 
       */

       public function getArticle( $articleId ){
           //connecting to database
           $dbconn = Parent::connect() ;

           //sql to get article data from cms_article
           $sql = 'SELECT u.name , a.article_id ,a.user_id , a.is_published , UNIX_TIMESTAMP( a.submit_date) as submit_date, a.title ,a.article_text
                    FROM cms_article a
                    INNER JOIN cms_users u ON a.user_id = u.user_id 
                    WHERE a.article_id=:ID
           ';

           try{
               /**
                * Preparing statement to work with sql 
                */
                $st = $dbconn->prepare( $sql ) ;
                $st->bindValue( ':ID' , $articleId ) ;
                
                $st->execute() ;
                $row = $st->fetch(PDO::FETCH_ASSOC) ;
                Parent::disconnect() ;

                return $row ;                

           }catch(PDOException $e){
               Parent::disconnect() ;
               die("query failed to parse ...".$e->getMessage() ) ;
           }
       }//EOF
 }//end of class
 
?>