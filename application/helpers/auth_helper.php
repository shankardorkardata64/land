<?php
function auth_check()
{
   $CI=&get_instance();
   $id=$CI->session->userdata('id');
   if(!$id)
   {
    $type='error';
    $message='Please Login to Continue';
    setalert($message,$type);
    redirect('login');

   }
   else
   {
       
   $is_admin=$CI->session->userdata('is_admin');
   if($is_admin!=0)
   {
   //  $type='error';
   //  $message='Please login as User to continue';
   //  setalert($message,$type);
   //  redirect('login');
   //  redirect('login');
  
   }

   }
}