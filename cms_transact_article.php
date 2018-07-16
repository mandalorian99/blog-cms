<?php 
/**
 * This script all the article related transactions that is all CRUD ops
 * which include following 
 *  - Submit New Article
 *  - Edit New Article
 *  - Publish New Article
 *  - Retract Article
 *  - Delete Article
 */

 require_once('class.inc/articleTransact.php') ;
 require_once('class.inc/article.class.php') ;

 if( isset( $_REQUEST['action'] ) ){
     
    /**
     * switching to valid block of code
     */
    switch( $_REQUEST['action'] ){

        case 'Submit New Article':
            $article = new articleTransact() ;
            $article->compose() ;
        break ;

        case 'Edit':
            /**
             * evoking articleTransact class object to call edit function
             */
            $editArticle = new articleTransact() ;
            $editArticle->editArticle() ;
        break ;

        case 'Publish':
            /**
             * evoking articleTransact class object to call publishArticle method
             */

             $publishArticle = new articleTransact() ;
             $publishArticle->publishArticle() ;
        break ;

        case 'Retract':
            /**
             * evoking articleTransact class object to call retractArticle method
             */

            $publishArticle = new articleTransact() ;
            $publishArticle->retractArticle() ;

        break ;

        case 'Delete':
            $delete = new articleTransact() ;
            $delete->deleteArticle() ;
        break ;

        case 'Add comment':
            $add = new article() ;
            $add->addComment()  ;
        break ;

        default:
        die("you silly human") ;
    }
 }
?>