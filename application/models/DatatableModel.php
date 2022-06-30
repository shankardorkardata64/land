<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DatatableModel extends CI_Model {

   function getuserjson($table,$searchQuery='',$postData=null,$id='')
   {
    $response = array();
    $table='users';
    ## Read value
    $draw = $postData['draw'];
    $start = $postData['start'];
    $rowperpage = $postData['length']; // Rows display per page
    $columnIndex = $postData['order'][0]['column']; // Column index
    $columnName = $postData['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
    $searchValue = $postData['search']['value']; // Search value
 
    ## Search 
    $searchQuery = "";
    if($searchValue != ''){
     }
 
    ## Total number of records without filtering
    $this->db->select('count(*) as allcount');
    $records = $this->db->get($table)->result();
    $totalRecords = $records[0]->allcount;
  
    ## Total number of record with filtering
    $this->db->select('count(*) as allcount');
    if($searchValue != '')
      {
   $this->db->like('fname',$searchValue);
   $this->db->or_like('lname',$searchValue);
   $this->db->or_like('username',$searchValue);
   $this->db->or_like('phone',$searchValue);
   $this->db->or_like('mobile',$searchValue); 
   $this->db->or_like('email',$searchValue); 
      }
    $records = $this->db->get($table)->result();
    $totalRecordwithFilter = $records[0]->allcount;
  
    ## Fetch records
    $this->db->select('*');
    if($searchValue != '') 
    {
   $this->db->like('fname',$searchValue);
   $this->db->or_like('lname',$searchValue);
   $this->db->or_like('username',$searchValue);
   $this->db->or_like('phone',$searchValue);
   $this->db->or_like('mobile',$searchValue); 
   $this->db->or_like('email',$searchValue);
    } 
    $this->db->order_by($columnName, $columnSortOrder);
    if($rowperpage!=-1)
    {     
       $this->db->limit($rowperpage, $start);
    }
    $records = $this->db->get($table)->result();
    // echo $this->db->last_query();
 
    $data = array();
    $sr=0;
    foreach($records as $record ){
 
       $status='Active'; $s='De-Activate';
       if($record->status==0){ $status='De-active'; $s='Activate'; }
       $data[] = array( 
          "srno"=>'EMP-'.$record->id,
          "fname"=>$record->fname.' '.$record->lname,
          "username"=>$record->username,
          "role"=>$this->db->get_where('usertype',array('id'=>$record->role))->row()->name,
          "status"=>$status,
          'link1'=>"<a href=".base_url('edit-emp').'/'.en($record->id).">Edit</a>",
           'link2'=>"<a href=".base_url('status-emp').'/'.en($record->id).">$s</a>"
       ); 
    }
 
    ## Response
    $response = array(
       "draw" => intval($draw),
       "iTotalRecords" => $totalRecords,
       "iTotalDisplayRecords" => $totalRecordwithFilter,
       "aaData" => $data
    );
 
    return $response; 
  
   }


   function getexpencesjson($table,$searchQuery='',$postData=null,$id='')
   {
    $response = array();
    $table='expences';
    ## Read value
    $draw = $postData['draw'];
    $start = $postData['start'];
    $rowperpage = $postData['length']; // Rows display per page
    $columnIndex = $postData['order'][0]['column']; // Column index
    $columnName = $postData['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
    $searchValue = $postData['search']['value']; // Search value
 
    ## Search 
    $searchQuery = "";
    if($searchValue != '')
    {
     }
 
    ## Total number of records without filtering
    $this->db->select('count(*) as allcount');
    if($id!='')
    {
      $this->db->where('user_id',$id);
    }
    $records = $this->db->get($table)->result();
    $totalRecords = $records[0]->allcount;
  





    ## Total number of record with filtering
    $this->db->select('count(*) as allcount');
    if($searchValue != '')
      {
   $this->db->like('amount',$searchValue);
   $this->db->or_like('note',$searchValue);
      }
      if($id!='')
      {
        $this->db->where('user_id',$id);
      }
      $this->db->join('users','expences.user_id=users.id','left');
      $this->db->join('expences_type','expences.type=expences_type.id','left');
      $records = $this->db->get($table)->result();
      $totalRecordwithFilter = $records[0]->allcount;
  






    ## Fetch records
    $this->db->select('users.username,expences_type.name as type,expences.amount,expences.id,expences.rejectnote,expences.edate,expences.staus');
    if($searchValue != '') 
    {
      $this->db->like('amount',$searchValue);
      $this->db->or_like('note',$searchValue);
    } 
    if($id!='')
    {
      $this->db->where('expences.user_id',$id);
    }
    $this->db->order_by($columnName, $columnSortOrder);
    if($rowperpage!=-1)
    {     
       $this->db->limit($rowperpage, $start);
    }
    $this->db->join('users','expences.user_id=users.id','left');
    $this->db->join('expences_type','expences.type=expences_type.id','left');
    $records = $this->db->get($table)->result();
    $data = array();
    $sr=0;
    foreach($records as $record )
    {
 
       $status='Pending';
       if($record->staus==1){ $status='Approved';  }
       if($record->staus==2){ $status='Rejected'; }
       
       if($record->staus==0)
       {
       $link2='<a class="btn btn-info" href="'.base_url('request-reject').'/'.en($record->id).'/'.en('edit').'">Edit</a>'; 
      if($this->session->userdata('role')==3)
      {   
      $link1='<a class="btn btn-info" href="'.base_url('request-approve').'/'.en($record->id).'">Approve</a>';  
      $link3='<a class="btn btn-info" href="'.base_url('request-reject').'/'.en($record->id).'/'.en('reject').'">Reject</a>';
      }
      else
      {
      $link1=$link3='-';
      } 
      }
       else
       {
       $link1=$link3='-';
       if($record->staus==2)
       {
      $link3=$link2='Rejected due to-'.$record->rejectnote;
       }
       else
       {
         $link2='';
       }

       }


      



       $data[] = array( 
          "srno"=>1,
          "username"=>$record->username,
          "type"=>$record->type,
          "amount"=>number($record->amount),
          "edate"=>$record->edate,
          "status"=>$status,
          'link2'=>$link2,
          'approve'=>$link1,
          'reject'=>$link3,
       ); 
    }
 
    ## Response
    $response = array(
       "draw" => intval($draw),
       "iTotalRecords" => $totalRecords,
       "iTotalDisplayRecords" => $totalRecordwithFilter,
       "aaData" => $data
    );
 
    return $response; 
  
   
}







   /************************************************** */























  function getzonesjson($table,$searchQuery='',$postData=null,$id='')
  {
   $response = array();
   $table='n_zones';
   ## Read value
   $draw = $postData['draw'];
   $start = $postData['start'];
   $rowperpage = $postData['length']; // Rows display per page
   $columnIndex = $postData['order'][0]['column']; // Column index
   $columnName = $postData['columns'][$columnIndex]['data']; // Column name
   $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
   $searchValue = $postData['search']['value']; // Search value

   ## Search 
   $searchQuery = "";
   if($searchValue != ''){
       $searchQuery .= "(name like '%".$searchValue."%' ) ";
    }

   ## Total number of records without filtering
   $this->db->select('count(*) as allcount');
   $records = $this->db->get($table)->result();
   $totalRecords = $records[0]->allcount;
   //$this->session->set_userdata('trx_count',$totalRecords);

   ## Total number of record with filtering
   $this->db->select('count(*) as allcount');
   if($searchQuery != '')
      $this->db->where($searchQuery);
   $records = $this->db->get($table)->result();
   $totalRecordwithFilter = $records[0]->allcount;
  // $this->session->set_userdata('trx_count',$totalRecordwithFilter);

   ## Fetch records
   $this->db->select('*');
   if($searchQuery != '')
   $this->db->where($searchQuery);
   $this->db->order_by($columnName, $columnSortOrder);
   if($rowperpage!=-1)
   {     
      $this->db->limit($rowperpage, $start);
   }
   $records = $this->db->get($table)->result();
   // echo $this->db->last_query();

   $data = array();
   $sr=0;
   foreach($records as $record ){

      $status='Active';
      if($record->status==0){ $status='De-active'; }
      $data[] = array( 
         "srno"=>1,
         "name"=>subs($record->name,25),
         "status"=>$status,
         'link1'=>"<a href=".base_url('deletezone').'/'.en($record->id).">View Detail</a>"
      ); 
   }

   ## Response
   $response = array(
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $data
   );

   return $response; 
 
  }



  function taxreportjson($table,$searchQuery='',$postData=null,$id='')
{
   $response = array();
   $table='n_tax_invoice';
## Read value
$draw = $postData['draw'];
$start = $postData['start'];
$rowperpage = $postData['length']; // Rows display per page
$columnIndex = $postData['order'][0]['column']; // Column index
$columnName = $postData['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $postData['order'][0]['dir']; // asc or desc
$searchValue = $postData['search']['value']; // Search value

## Search 
$searchQuery = "";
if($searchValue != ''){
    $searchQuery = "sdfds";
 }
 $this->db->select('count(*) as allcount');
 $this->db->from('n_tax_invoice');
 $this->db->where('n_tax_invoice.pending',0);
 $this->db->where('n_tax_invoice.total!=',0);
 $this->db->where('n_tax_invoice.new!=',0);
 if($this->session->userdata('from')!='' AND $this->session->userdata('to')!='')
 {
   $this->db->where('n_tax_invoice.updated_at >=', $this->session->userdata('from'));
   $this->db->where('n_tax_invoice.updated_at <=', $this->session->userdata('to'));
   
 } 

 $this->db->join('n_citizen', 'n_citizen.id = n_tax_invoice.user_id', 'left');
 $this->db->join('n_taxes', 'n_taxes.id = n_tax_invoice.tax_id', 'left');
 
 $records = $this->db->get()->result(); 
 $totalRecords = $records[0]->allcount;

  
 $this->db->select('count(*) as allcount');
 $this->db->from('n_tax_invoice');

 $this->db->where('n_tax_invoice.pending',0);
 $this->db->where('n_tax_invoice.total!=',0);
 $this->db->where('n_tax_invoice.new!=',0);
 if($this->session->userdata('from')!='' AND $this->session->userdata('to')!='')
 {
   $this->db->where('n_tax_invoice.updated_at >=', $this->session->userdata('from'));
   $this->db->where('n_tax_invoice.updated_at <=', $this->session->userdata('to'));
   
 } 


 if($searchValue != '')
 {  

    $this->db->like('n_citizen.name',$searchValue);
    $this->db->or_like('n_citizen.en_name',$searchValue);
    $this->db->or_like('n_citizen.house_no',$searchValue);
    $this->db->or_like('n_citizen.mobile_no',$searchValue);
    $this->db->or_like('n_taxes.name',$searchValue); 
    $this->db->or_like('n_tax_invoice.year',$searchValue);
 }
 $this->db->join('n_citizen', 'n_citizen.id = n_tax_invoice.user_id', 'left');
 $this->db->join('n_taxes', 'n_taxes.id = n_tax_invoice.tax_id', 'left');
 
 $records = $this->db->get()->result();
 $totalRecordwithFilter = $records[0]->allcount;




      $this->db->select('n_citizen.id as cid,
      n_citizen.name as cname,n_citizen.isdeleted,
      n_citizen.en_name,
      n_citizen.house_no
      ,n_citizen.mobile_no
      ,n_citizen.property_type
      ,n_taxes.name as tax
      ,n_tax_invoice.total as amount,
      ,n_tax_invoice.updated_at as date,
      n_tax_invoice.year,n_tax_invoice.pending,n_tax_invoice.new
      ');
      $this->db->where('n_tax_invoice.pending',0);
      $this->db->where('n_tax_invoice.total!=',0);
      $this->db->where('n_tax_invoice.new!=',0);
      if($this->session->userdata('from')!='' AND $this->session->userdata('to')!='')
 {
   $this->db->where('n_tax_invoice.updated_at >=', $this->session->userdata('from'));
   $this->db->where('n_tax_invoice.updated_at <=', $this->session->userdata('to'));
   
 } 

      $this->db->from('n_tax_invoice');


      if($searchValue != '')
      {
      $this->db->like('n_citizen.name',$searchValue);
      $this->db->or_like('n_citizen.en_name',$searchValue);
      $this->db->or_like('n_citizen.house_no',$searchValue);
      $this->db->or_like('n_taxes.name',$searchValue);
      $this->db->or_like('n_citizen.mobile_no',$searchValue);
      $this->db->or_like('n_tax_invoice.year',$searchValue);
      }
      $this->db->join('n_citizen', 'n_citizen.id = n_tax_invoice.user_id', 'left');
      $this->db->join('n_taxes', 'n_taxes.id = n_tax_invoice.tax_id', 'left');
 
      if($rowperpage!=-1)
{     
   $this->db->limit($rowperpage, $start);
}
   $records = $this->db->get()->result();


 $data = array();
 $sr=0;
 foreach($records as $record ){

   $array=array('user_id'=>$record->cid,'year'=>$record->year,'table'=>'n_tax_invoice');
   $pri=json_encode($array);

   if($record->pending==0  AND $record->amount!=0  AND $record->new!=0 ) {
    $data[] = array( 
       "srno"=>($record->cid),
       "name"=>($record->cname),
       "en_name"=>($record->en_name),
       "house_no"=>($record->house_no),
       "mobile_no"=>$record->mobile_no,
            'property_type'=>$record->property_type,
            'amount'=>$record->amount,
            'year'=>$record->year,
            'date'=>$record->date,
            'tax'=>$record->tax,
            'link1'=>"<a target='_black' class='btn btn-info btn-sm'  href=".base_url('print').'/'.en1($pri).">Print</a>",
            'link2'=>"<a target='_black' class='btn btn-info btn-sm' href=".base_url('print').'/'.en1($pri).">Print</a>",
     

    ); 
   } 
 }

 ## Response
 $response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
 );

 return $response; 
}





function taxreportjson_w($table,$searchQuery='',$postData=null,$id='')
{
   $response = array();
   $table='n_tax_invoice_w';
## Read value
$draw = $postData['draw'];
$start = $postData['start'];
$rowperpage = $postData['length']; // Rows display per page
$columnIndex = $postData['order'][0]['column']; // Column index
$columnName = $postData['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $postData['order'][0]['dir']; // asc or desc
$searchValue = $postData['search']['value']; // Search value

## Search 
$searchQuery = "";
if($searchValue != ''){
    $searchQuery = "sdfds";
 }
 $this->db->select('count(*) as allcount');
 $this->db->from('n_tax_invoice_w');
 $this->db->where('n_tax_invoice_w.pending',0);
 $this->db->where('n_tax_invoice_w.total!=',0);
 $this->db->where('n_tax_invoice_w.new!=',0);
 if($this->session->userdata('from_w')!='' AND $this->session->userdata('to_w')!='')
 {
   $this->db->where('n_tax_invoice_w.updated_at >=', $this->session->userdata('from_w'));
   $this->db->where('n_tax_invoice_w.updated_at <=', $this->session->userdata('to_w'));
   
 } 

  $this->db->join('n_citizen', 'n_citizen.id = n_tax_invoice_w.user_id', 'left');
  $this->db->join('n_taxes_w', 'n_taxes_w.id = n_tax_invoice_w.tax_id', 'left');
 
 $records = $this->db->get()->result(); 
 $totalRecords = $records[0]->allcount;

  
 $this->db->select('count(*) as allcount');
 $this->db->from('n_tax_invoice_w');

 $this->db->where('n_tax_invoice_w.pending',0);
 $this->db->where('n_tax_invoice_w.total!=',0);
 $this->db->where('n_tax_invoice_w.new!=',0);
 
 if($this->session->userdata('from_w')!='' AND $this->session->userdata('to_w')!='')
 {
   $this->db->where('n_tax_invoice_w.updated_at >=', $this->session->userdata('from_w'));
   $this->db->where('n_tax_invoice_w.updated_at <=', $this->session->userdata('to_w'));
   
 } 
 if($searchValue != '')
 {  

    $this->db->like('n_citizen.name',$searchValue);
    $this->db->or_like('n_citizen.en_name',$searchValue);
    $this->db->or_like('n_citizen.house_no',$searchValue);
    $this->db->or_like('n_citizen.mobile_no',$searchValue);
    $this->db->or_like('n_taxes_w.name',$searchValue); 
    $this->db->or_like('n_tax_invoice_w.year',$searchValue);
 }
 $this->db->join('n_citizen', 'n_citizen.id = n_tax_invoice_w.user_id', 'left');
 $this->db->join('n_taxes_w', 'n_taxes_w.id = n_tax_invoice_w.tax_id', 'left');
 
 $records = $this->db->get()->result();
 $totalRecordwithFilter = $records[0]->allcount;




      $this->db->select('n_citizen.id as cid,
      n_citizen.name as cname,n_citizen.isdeleted,
      n_citizen.en_name,
      n_citizen.house_no
      ,n_citizen.mobile_no
      ,n_citizen.property_type
      ,n_taxes_w.name as tax
      ,n_tax_invoice_w.total as amount,
      ,n_tax_invoice_w.updated_at as date,
      n_tax_invoice_w.year,n_tax_invoice_w.pending,n_tax_invoice_w.new
      ');
      $this->db->where('n_tax_invoice_w.pending',0);
      $this->db->where('n_tax_invoice_w.total!=',0);
      $this->db->where('n_tax_invoice_w.new!=',0);

      if($this->session->userdata('from_w')!='' AND $this->session->userdata('to_w')!='')
      {
        $this->db->where('n_tax_invoice_w.updated_at >=', $this->session->userdata('from_w'));
        $this->db->where('n_tax_invoice_w.updated_at <=', $this->session->userdata('to_w'));
        
      } 

      $this->db->from('n_tax_invoice_w');
      if($searchValue != '')
      {
      $this->db->like('n_citizen.name',$searchValue);
      $this->db->or_like('n_citizen.en_name',$searchValue);
      $this->db->or_like('n_citizen.house_no',$searchValue);
      $this->db->or_like('n_taxes_w.name',$searchValue);
      $this->db->or_like('n_citizen.mobile_no',$searchValue);
      $this->db->or_like('n_tax_invoice_w.year',$searchValue);
      }
      $this->db->join('n_citizen', 'n_citizen.id = n_tax_invoice_w.user_id', 'left');
      $this->db->join('n_taxes_w', 'n_taxes_w.id = n_tax_invoice_w.tax_id', 'left');
 
      if($rowperpage!=-1)
{     
   $this->db->limit($rowperpage, $start);
}
   $records = $this->db->get()->result();


 $data = array();
 $sr=0;
 foreach($records as $record ){

   // if($record->pending==0  AND $record->amount!=0  AND $record->new!=0 ) {


      $array=array('user_id'=>$record->cid,'year'=>$record->year,'table'=>'n_tax_invoice_w');
      $pri=json_encode($array);

    $data[] = array( 
       "srno"=>($record->cid),
       "name"=>($record->cname),
       "en_name"=>($record->en_name),
       "house_no"=>($record->house_no),
       "mobile_no"=>$record->mobile_no,
            'property_type'=>$record->property_type,
            'amount'=>$record->amount,
            'year'=>$record->year,
            'tax'=>$record->tax,
            'date'=>$record->date,

       'link1'=>"<a target='_black' class='btn btn-info btn-sm' href=".base_url('print').'/'.en1($pri).">Print</a>",
       'link2'=>"<a target='_black' class='btn btn-info btn-sm'  href=".base_url('print').'/'.en1($pri).">Print</a>",


    ); 
   //} 
 }

 ## Response
 $response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
 );

 return $response; 
}



























  function getcitizenjson($table,$searchQuery='',$postData=null,$id='')
  {
   $response = array();
   $table='n_citizen';
   ## Read value
   $draw = $postData['draw'];
   $start = $postData['start'];
   $rowperpage = $postData['length']; // Rows display per page
   $columnIndex = $postData['order'][0]['column']; // Column index
   $columnName = $postData['columns'][$columnIndex]['data']; // Column name
   $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
   $searchValue = $postData['search']['value']; // Search value

   ## Search 
   $searchQuery = "";
   if($searchValue != ''){
       $searchQuery .= " ";
    }

 
   $this->db->select('count(*) as allcount');
   $this->db->from('n_citizen');
   $this->db->where('n_citizen.isdeleted',0);
   if($searchValue != '')
   {  

      $this->db->like('n_citizen.name',$searchValue);
      $this->db->or_like('n_citizen.en_name',$searchValue);
      $this->db->or_like('n_karyalaya.name',$searchValue);
      $this->db->or_like('n_zones.name',$searchValue);
   }
   $this->db->join('n_karyalaya', 'n_karyalaya.id = n_citizen.karyalay', 'left');
   $this->db->join('n_zones', 'n_zones.id = n_citizen.zone', 'left');
   $records = $this->db->get()->result(); 
   $totalRecords = $records[0]->allcount;

   
   
   
   $this->db->select('count(*) as allcount');
   $this->db->from('n_citizen');
   if($searchValue != '')
   {  

      $this->db->like('n_citizen.name',$searchValue);
      $this->db->or_like('n_citizen.en_name',$searchValue);
      $this->db->or_like('n_karyalaya.name',$searchValue);
      $this->db->or_like('n_zones.name',$searchValue);
   }
   $this->db->join('n_karyalaya', 'n_karyalaya.id = n_citizen.karyalay', 'left');
   $this->db->join('n_zones', 'n_zones.id = n_citizen.zone', 'left');
   $this->db->where('n_citizen.isdeleted',0);
   if($rowperpage!=-1)
   {     
      $this->db->limit($rowperpage, $start);
   }
   $records = $this->db->get()->result();
   $totalRecordwithFilter = $records[0]->allcount;


   $this->db->select('n_citizen.id as cid,
   n_citizen.name as cname,n_citizen.isdeleted,
   n_citizen.en_name,
   n_citizen.house_no
   ,n_citizen.mobile_no
   ,n_karyalaya.name as kname
   ,n_zones.name as zname
   ,n_citizen.property_type
   ');
   $this->db->from('n_citizen');

   if($searchValue != '')
   {
      $this->db->like('n_citizen.name',$searchValue);
      $this->db->or_like('n_citizen.en_name',$searchValue);
      $this->db->or_like('n_karyalaya.name',$searchValue);
      $this->db->or_like('n_zones.name',$searchValue);
   }
   $this->db->join('n_karyalaya', 'n_karyalaya.id = n_citizen.karyalay', 'left');
   $this->db->join('n_zones', 'n_zones.id = n_citizen.zone', 'left');
   $this->db->where('n_citizen.isdeleted',0);
   $this->db->limit($rowperpage, $start);
   $records = $this->db->get()->result();
   
   // echo $this->db->last_query();

   $data = array();
   $sr=0;
   foreach($records as $record ){
   if($record->isdeleted==0){
      $status='Active';
      $data[] = array( 
         "srno"=>($record->cid),
         "name"=>($record->cname),
         "en_name"=>($record->en_name),
         "house_no"=>($record->house_no),
         "mobile_no"=>$record->mobile_no,
         "kname"=>$record->kname,
         "zname"=>$record->zname,
         'totaltax'=>totaltax($record->cid),
         'totaltaxp'=>totaltaxp($record->cid),
         'totaltax_w'=>totaltax_w($record->cid),
         'totaltaxp_w'=>totaltaxp_w($record->cid),
         'property_type'=>$record->property_type,
         'link1'=>"<a href=".base_url('viewtax').'/'.en($record->cid).">View Property</a>",
         'link2'=>"<a href=".base_url('citizen-edit').'/'.en($record->cid)." class='btn btn-success btn-icon'>Edit  Citizen</a>",
         'link3'=>"<a href=".base_url('citizen-delete').'/'.en($record->cid)." class='btn btn-danger btn-icon'>Delete Citizen</a>",
         'link4'=>"<a href=".base_url('citizen-add-tax').'/'.en($record->cid)." class='btn btn-success btn-icon'>Add Tax</a>",
         'link5'=>"<a href=".base_url('citizen-receive-paymnet').'/'.en($record->cid)." class='btn btn-success btn-icon'>Receive  Paymnet</a>",
      

         'link6'=>"<a href=".base_url('citizen-add-water').'/'.en($record->cid)." class='btn btn-success btn-icon'>Receive Nalpatti</a>",
         //'link7'=>"<a href=".base_url('citizen-receive-water-paymnet').'/'.en($record->cid)." class='btn btn-success btn-icon'>Receive  Nalpatti</a>",
      


      ); 
   }
   }

   ## Response
   $response = array(
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $data
   );

   return $response; 
 
  }







    }


?>