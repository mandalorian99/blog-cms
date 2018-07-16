<?php 
/**
 * This script called by when user login ,create account ,modify account etc
 * Fist this script identify what type of request is it ,then called its class
 */

 /**
  * Imorting user transact class file 
  */
 require_once('class.inc/userTransact.class.php') ;
 if( isset($_REQUEST['action']) ){

    /**
     * using switch case to redirect to valid block
     */

     switch( $_REQUEST['action'] ){
         case 'Login':
             $user = new login() ;
             $user->checkLogin() ;
         break;

         case 'Create Account':
             $createAcn = new creatAccount() ;
             $createAcn->processForm() ;
         break ;

         case 'Modify Account':
            $member = new Member() ;
            $member->modifyAccount() ;
            break ;

         default:
            die('watch your action you shilly human!!!') ;
     }//end of switch
 }
?>