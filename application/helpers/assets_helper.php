<?php


function lv($page,$data='')   //Load View
{
    $CI=&get_instance();
    $folder='user/';
    if($CI->session->userdata('role')==1) { $folder='admin/';}
    $CI->load->view('layouts/app',$data);
    $CI->load->view($folder.$page,$data);
    $CI->load->view('layouts/footer',$data);
}


function alv($page,$data='')   //Load View
{
    $CI=&get_instance();
    $CI->load->view('authlayouts/app',$data);
    $CI->load->view($page,$data);
    $CI->load->view('authlayouts/footer',$data);
}


function asset($file)     //load files from folder 
{
    echo base_url($file);
}

function url($file)     //return string as it is 
{
    echo $file;
}
function escape($string)
{      return $string;
      $CI=&get_instance();
    return $CI->db->escape($string);
}

function subs($temp,$le=10)
{
   return substr($temp, 0, $le).'...';
}
function setalert($message,$type='')
{ 
    $CI=&get_instance();
   
    if($type=='')
    {
        $co='success';
    
    }
    else
    {
    if($type=='error')
    {
        $co='danger';
    }
    if($type=='warning')
    {
        $co='warning';
    }
    if($type=='success')
    {
        $co='success';
    }
    }
    
    $ms='<div class="alert border-0 alert-dismissible fade show"
    style="background-color: rgb(0 32 59);"
    ><div class="text-'.$co.'"><b>'.$message.'!</b></div><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    $CI->session->set_flashdata('flash', $ms);
 
}
function getalert()
{
    $CI=&get_instance();
   echo $CI->session->flashdata('flash');
}

?>