<?php 
/**
 * script to create tables 
 * Database: comic_site_cms 
 */
 include_once('config.inc.php') ;

 #connecting to database 

 /**
  * handling database connecting error
  */
  try{
       $conn = new PDO(DB_DSN , DB_USERNAME , DB_PASSWORD) ;
       $conn->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION) ;
  }catch( PDOException $errorMsg ){
      echo"error: connection failed to established..".$errorMsg->getMessage() ;
  }

  $sql ='CREATE TABLE IF NOT EXISTS cms_access_level(
      access_level      TINYINT     UNSIGNED        NOT NULL        AUTO_INCREMENT ,
      access_name       VARCHAR(50)                 NOT NULL        DEFAULT ""     ,  

      PRIMARY KEY(access_level)
  )';

  #quering above sql using PDO 
  $row = $conn->query($sql) ;
  if(!$row)
    echo"table cms_access_level not created" ;

 $sql='CREATE TABLE IF NOT EXISTS cms_users(
     user_id    INTEGER    UNSIGNED    NOT NULL    AUTO_INCREMENT ,
     email      VARCHAR(60) NOT NULL    UNIQUE  ,
     password   VARCHAR(20) NOT NULL , 
     name       VARCHAR(50) NOT NULL , 
     access_level   TINYINT UNSIGNED    NOT NULL    DEFAULT 1 ,

     PRIMARY KEY(user_id)
 )';

 if( !$conn->query($sql) ) 
    echo"<br/>table cms_users not created...";
 
 $sql ='CREATE TABLE IF NOT EXISTS cms_article(
     article_id  INTEGER     UNSIGNED   NOT NULL AUTO_INCREMENT ,
     user_id     INTEGER    UNSIGNED    NOT NULL ,
     is_published BOOLEAN   NOT NULL    DEFAULT FALSE ,
     submit_date  DATETIME  NOT NULL , 
     publish_date DATETIME  ,
     title        VARCHAR(255)  NOT NULL ,
     article_text MEDIUMTEXT , 

     PRIMARY KEY(article_id) ,
     FOREIGN KEY(user_id)   REFERENCES  cms_users(user_id) ,
     INDEX(user_id , submit_date ) ,
     FULLTEXT INDEX(title ,article_text)    
 )';

 if( !$conn->query($sql) )
 echo"table cms_article not created.." ;

 $sql='CREATE TABLE IF NOT EXISTS cms_comments(
     comment_id     INTEGER     UNSIGNED    NOT NULL    AUTO_INCREMENT ,
     article_id     INTEGER     UNSIGNED    NOT NULL  ,
     user_id        INTEGER     UNSIGNED    NOT NULL  ,
     comment_date   DATETIME    ,
     comment_text   MEDIUMTEXT  , 

     PRIMARY KEY(comment_id),
     FOREIGN KEY(article_id) REFERENCES cms_article(article_id) ,
     FOREIGN KEY(user_id)   REFERENCES  cms_users(user_id)
 )';

 if( !$conn->query($sql) )
 echo"table cms_comments not created...";

?>