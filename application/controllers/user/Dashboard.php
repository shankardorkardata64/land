<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller 
{

    public function __construct()
    {
        parent::__construct();
        auth_check();
       
	  }



    
    public function listemp()
    {
        $data['users']=select('users',array('role'=>4));
        lv('users/list',$data);
    }

     public function ajaxadminsetrate()
     {
      /************************** */
      $base_url=base_url();
      $max_select=20;
      $setting=setting();
      $max_select=$setting['max_tile_rate_select'];

      $cur='XEMXLINK';
$this->db->select('code');
$this->db->select('prize');
$p=$this->db->get('landprize')->result_array();
$r=array();
foreach($p as $key=>$vl)
{
$r=array_merge($r,array($vl['code']=>$vl['prize']));
}
// print_r($r);
$pricelist=$r;
$pricelist1 =array('4VJPWHRH+5V'=>5,'4VJPWHRH+4V'=>4,'4VJPWHRH+3V'=>3,'4VJPWHRH+2W'=>10,'4VJPWHRH+3W'=>42,'4VJPWHRH+2V'=>10);

      $restricted_code=array('4VJPWHRH+6V');
      $json_array=array('north'=>-34.36,'south'=>-47.35,'west'=>166.28,'east'=>175);
      
      /************************* */
      $total=0;
      $selected_code=$_POST['code'];
      $codearray=$_POST['codearray'];
      $table=$error=$limit_error=$success='';
      $sc=0;  $list=array(); 
      $sc=count($codearray);
      if($sc>$max_select)
      {
        $limit_error='limit Reacheder';
      }
      $table='<form action="'.base_url('saverate').'" method="post"><table class="table"><tr> <th>Land Code</th>  <th>Prize</th> </tr><tbody>';  
      // if (!array_key_exists($selected_code, $pricelist))  {
       $list=array(); 
        $io=0;
      foreach($codearray as $co)
      {  
          $price=@$pricelist[$co];
          //if(!$price){
            array_push($list,$co);
          $error='';
          $success='ok';
          $total=$total+$price;
          if(!$price OR $price=='')
          {
            $price=rand(1,100);
          }
          $table .= '<tr>';
          // $table .= '<td>';
          // $table .= ++$io;
          // $table .= '</td>';
          $table .= '<td>';
          $table .= '<input type="text" class="form-control" required readonly value="'.$co.'" name="code[]">';
          $table .= '</td>';
          $table .= '<td>';
          $table .= '<input type="text"  class="form-control" value="'.$price.'"  required  name="prize[]">';
          $table .= '</td>';
          $table .= '</tr>';
        //  }
        //  else
        //  {
        //   $error='<p style="color:red;">This Land '.$co.' Is not for Sell</p>';
        //  }
      }
      // }
      // else
      // {
      
      //   $error='<p style="color:red;">This Land  '.$selected_code.'  Is not for Sell</p>';
      // }
      
      $table .= '</tbody>';  
      $table .='</table>  <input class="btn btn-info" type="submit"  style="float: right;" value="Save Prize"></form>';
      
      $t='<h4>'.$sc.'/'.$max_select.' Tiles Selected '.$limit_error.' </h4><br>';
      if($limit_error!='') { $t =$t.$limit_error.'<br>'; }
      $table=$t.$table;
      $array=array('table'=>$table,'list'=>json_encode($list),'total'=>$total,'error'=>$error,'sc'=>$sc,'limit_error'=>$limit_error,'success'=>$success);
      echo json_encode($array);

     }  


     function saverate()
     {
     
$data=$_POST;
foreach($data['code'] as $key=>$val)
{
$index=$key;
$code=$val;
$prixeof_code=$data['prize'][$index];
$num=$this->db->get_where('landprize',array('code'=>$code))->num_rows();
if($num==0)
{
  $this->db->insert('landprize',array('code'=>$code,'prize'=>$prixeof_code));
}
else
{
  $this->db->where('code',$code);
  $this->db->update('landprize',array('prize'=>$prixeof_code));
}
}
redirect('dashboard');

     }














    public function index()
    {
      lv('dashboard/index');
    }
public function ajaxusermaprate()
{
/****************************** */
$base_url=base_url();
$max_select=20;
$setting=setting();
$max_select=$setting['max_buy_limit'];
$cur='XEMXLINK';
$this->db->select('code');
$this->db->select('prize');
$p=$this->db->get('landprize')->result_array();
$r=array();
foreach($p as $key=>$vl)
{
$r=array_merge($r,array($vl['code']=>$vl['prize']));
}
// print_r($r);
$pricelist=$r;
$pricelist1 =array('4VJPWHRH+5V'=>5,'4VJPWHRH+4V'=>4,'4VJPWHRH+3V'=>3,'4VJPWHRH+2W'=>10,'4VJPWHRH+3W'=>42,'4VJPWHRH+2V'=>10);

$restricted_code=array('4VJPWHRH+6V');
$json_array=array('north'=>-34.36,'south'=>-47.35,'west'=>166.28,'east'=>175);
/****************************** */

$total=0;
$selected_code=$_POST['code'];
$codearray=$_POST['codearray'];
$table=$error=$limit_error=$success='';
$sc=0;  $list=array(); 
$sc=count($codearray);
if($sc>$max_select)
{
  $limit_error='limit Reacheder';
}
$table='<table class="table"><tr><th>Sr.No</th> <th>Land Code</th>  <th>Prize</th> </tr><tbody>';  
if (array_key_exists($selected_code, $pricelist)) 
{
// $list=array(); 
  $io=0;
foreach($codearray as $co)
{  
    $price=@$pricelist[$co];
    if($price)
    {
      array_push($list,$co);
    $error='';
    $success='ok';
    $total=$total+$price;
    $table .= '<tr>';
    $table .= '<td>';
    $table .= ++$io;
    $table .= '</td>';
    $table .= '<td>';
    $table .= $co;
    $table .= '</td>';
    $table .= '<td>';
    $table .= $price .' '.$cur;
    $table .= '</td>';
    $table .= '</tr>';
   }
   else
   {
    $error='<p style="color:red;">This Land '.$co.' Is not for Sell</p>';
   }
}
}
else
{

  $error='<p style="color:red;">This Land  '.$selected_code.'  Is not for Sell</p>';
}

$table .= '</tbody><tr><th></th> <th>Total</th>  <th>'.$total.' '.$cur.' </th> </tr>';  
$table .='</table>';

$t='<h4>'.$sc.'/'.$max_select.' Tiles Selected '.$limit_error.' </h4><br>';
if($limit_error!='') { $t =$t.$limit_error.'<br>'; }
$table=$t.$table;
$array=array('table'=>$table,'list'=>json_encode($list),'total'=>$total,'error'=>$error,'sc'=>$sc,'limit_error'=>$limit_error,'success'=>$success);
echo json_encode($array);
    }

function placeorder()
{

$area=$this->input->post('area');
$area=explode(",",$area);
$inv_id=time();
foreach($area as $a)
{
  $a=str_replace('["','',$a);
  $a=str_replace('"]','',$a);
  $a=str_replace('"','',$a);
$sale_id=$this->add_record_in_sale($a,$inv_id);
  if($sale_id)
  {
  $this->db->where('code',$a);
  $this->db->update('landprize',array('sold'=>1,'sale_id'=>$sale_id));
  }
}
redirect('dashboard');
}

private function add_record_in_sale($a,$inv_id)
    {
      $codedetail=$this->db->get_where('landprize',array('code'=>$a))->result_array();
      $codedetail=@$codedetail[0];
      if(@$codedetail['id'])
      {
       $sale_record=array('inv_id'=>$inv_id,'land_id'=>$codedetail['id'],'user_id'=>$this->session->userdata('id'),'price'=>$codedetail['prize']);
       return insert('sale_record',$sale_record);
      }

    }







}