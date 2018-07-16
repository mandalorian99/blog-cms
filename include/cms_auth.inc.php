<?php 
/**
 * This script check weather user is authrize to access page or not 
 * It check if a user is logged in or not .If it is not login it redirect
 * to login page 
 */
 if(!isset( $_SESSION['loginFlag'] ) ){
     if(!headers_sent()){
         //header('Location:') ;
         die("you are not authrize to access this .Kindly login ") ;
     }
 }
?>