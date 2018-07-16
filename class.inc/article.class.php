<?php 
/**
 * This class display the article except ,article title article texta and its comments
 */

 require_once('include/config.inc.php') ;
 require_once('dataObject.class.php') ;


 class article extends dataObject{
     //private $conn  ;
     private $articleID ;
     private $redirect = 'cms_view_article.php' ;

     /**
      * class methods 
      */
      
      #return the article excerpt , when outuput story function preview = TRUE
      /*public function excerpt( $text , $max_length=20 , $tail='...'){
        echo '<strong>'.rtrim($text).'</strong>' ;
          echo $tail_len = strlen($tail) ;

          if(strlen($text) > $max_length){
             echo strlen($text) ; 
              $temp_text = substr( $text , 0 , $max_length-$tail_len) ;
                echo'<p>-----'.$temp_text.'</p>------';
              if( substr( $text , $max_length-$tail_len , 1  ) == '' ){
                  $text = $temp_text ;
              }else{
                  $pos = strpos($temp_text,' ') ;
                  $text = $text.'<strong>'.$tail.'</strong>' ;
              }
          }
          echo '<em>'.$text.'</em>' ;
          return $text ;
      }//EOF*/

      function excerpt($text, $max_length = 100, $cut_off = '...', $keep_word = false){
            if(strlen($text) <= $max_length) {
                return $text;
            }

            if(strlen($text) > $max_length) {
                  if($keep_word) {
                          $text = substr($text, 0, $max_length + 1);

                         if($last_space = strrpos($text, ' ')) {
                                $text = substr($text, 0, $last_space);
                                $text = rtrim($text);
                                $text .=  $cut_off;
                         }
                  }else{
                        $text = substr($text, 0, $max_length);
                        $text = rtrim($text);
                        $text .=  $cut_off;
                  }
            }

            return $text;
      }

      /**
       * function to return the article text ,on providing artice id 
       */

       public function output_story($article_id=1 , $preview_only=FALSE){
           if( empty($article_id) )
           return ;

           //connecting to database 
           $dbconn = Parent::connect() ;

           $sql = 'SELECT a.article_id , u.name , UNIX_TIMESTAMP(a.publish_date) AS publish_date , a.title , a.article_text
                   FROM cms_article a INNER JOIN cms_users u 
                   ON a.user_id = u.user_id  
                   WHERE a.article_id ='.$article_id.' AND is_published=1
           ';

           try{
               //preparing resource object to work with sql 
               $st = $dbconn->prepare( $sql ) ;
               $st->execute() ;

               $row = $st->fetch(PDO::FETCH_ASSOC) ;
               //var_dump($row) ;
               #if preview is true then fetch article text except
               if($preview_only){
                 $row['article_text']= $this->excerpt($row['article_text']).'<a href="cms_view_article.php?article_id='.$row['article_id'].'">Read Full Story</a>' ;
              
               }
               return $row ;
           }catch(PDOException $e){
               Parent::disconnect() ;
               die("query failed to execute..".$e->getMessage() ) ;
           }
       }//EOF

       /**
        * loop to fetch article id 
        */
        public function loop(){ 
            //connecting to database 
            $dbconn = Parent::connect() ;
 
            $sql = 'SELECT article_id FROM cms_article 
                    WHERE is_published = 1
                    ORDER BY publish_date DESC
                    LIMIT 0,10                    
                    ' ;
 
            try{
                //preparing resource object to work with sql 
                $st = $dbconn->prepare( $sql ) ;
                $st->execute() ;
 
                $row = $st->fetchAll(PDO::FETCH_ASSOC) ;
                //var_dump($row) ;
                return $row ;
            }catch(PDOException $e){
                Parent::disconnect() ;
                die("query failed to execute..".$e->getMessage() ) ;
            }
        }//EOF

        /**
         * Insert comment to database comment table
         */

        public function addComment(){
            //connecting to databse 
            $dbconn = Parent::connect() ;         
            var_dump($_POST) ;
            //die() ;
            //fetching form data 
            $user_id  = $_POST['user_id'] ;
            $article_id = $_POST['article_id'] ;
            $text = $_POST['comment_text'] ;
            $submit_date = date('F j Y') ;
            
   
            //var_dump($_POST) ;
            //die("stop") ;
            $sql = 'INSERT INTO cms_comments ( article_id , user_id , comment_date , comment_text )
                    VALUES(:ARTICLE_ID , :ID ,:SUBMIT_DATE  , :COMMENT_TEXT)
            ';
   
            try{
               //preparing statement object
               $st = $dbconn->prepare($sql) ;
               $st->bindValue(':ARTICLE_ID' , $article_id ,PDO::PARAM_INT ) ;
               $st->bindValue(':ID' , $user_id ,PDO::PARAM_INT ) ;
               $st->bindValue(':SUBMIT_DATE' , $submit_date ,PDO::PARAM_STR ) ;
               //$st->bindValue(':TITLE' , title ,PDO::PARAM_STR) ;
               $st->bindValue(':COMMENT_TEXT' , $text ,PDO::PARAM_STR ) ;
   
               if( !$st->execute() ){
                   Parent::disconnect() ;
                   die("<h2>oops something went wrong...</h2>") ;
               }
               Parent::disconnect() ;
               articleTransact::displayThanks("Your comment submitted successfully .Awaiting for admin approvel") ;
   
            }catch(PDOException $e){
                die("query failed to execute..".$e->getMessage() ) ;
            }
        }//EOF

        /**
         * Display comment related to article 
         */

         public function showComment($articleId){
            //connecting to databse 
            $dbconn = Parent::connect() ;         
            //die() ;     

            $sql = 'SELECT u.name , UNIX_TIMESTAMP(comment_date) as comment_date , comment_text
                    FROM cms_comments c INNER JOIN cms_users u
                    ON c.user_id = u.user_id 
                    WHERE c.article_id = :ARTICLE_ID
            ';
            
   
            try{
               //preparing statement object
               $st = $dbconn->prepare($sql) ;
               $st->bindValue(':ARTICLE_ID' , $articleId ,PDO::PARAM_INT ) ;
   
               if( !$st->execute() ){
                   Parent::disconnect() ;
                   die("<h2>oops something went wrong...</h2>") ;
               }

               $commentData = $st->fetchAll(PDO::FETCH_ASSOC) ;

               //var_dump($commentData) ;
               //die() ;
               Parent::disconnect() ;
               return $commentData ;
   
            }catch(PDOException $e){
                die("query failed to execute..".$e->getMessage() ) ;
            }
         }
   

 }//EOC
?>