<?php
 


 function setting()
 {
    $CI=&get_instance();
    return $CI->db->get('setting')->result_array()[0];
 }


 function reject_ex($id,$note='')
 {
    if($note=='')
    {
        $note='N/A';
    }
    $CI=&get_instance();
    $CI->db->where('id',$id);
    $CI->db->update('expences',array('rejectnote'=>$note,'staus'=>2,'updated_at'=>time()));
 }


    function number($number,$size=2)
    {
        return $number;
        return number_format($number,$size,".",".");
    }
    
    
function printrec($user_id,$table,$year)
{
           $CI=&get_instance();
           $CI->db->select_sum('amount');
     $total=$CI->db->get_where('n_paid',array('table'=>$table,'status'=>'Cleared','user_id'=>$user_id,'year'=>$year))->result_array()[0]['amount'];
     $all=$CI->db->get_where('n_paid',array('table'=>$table,'status'=>'Cleared','user_id'=>$user_id,'year'=>$year))->result_array();
     $tax=$CI->db->get_where($table,array('user_id'=>$user_id,'year'=>$year))->result_array();
     $AmountInWords=AmountInWords($total);
     return array('all'=>$all,'total'=>$total,'word'=>$AmountInWords,'tax'=>$tax);

}


function AmountInWords(float $amount)
{
   $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
   // Check if there is any number after decimal
   $amt_hundred = null;
   $count_length = strlen($num);
   $x = 0;
   $string = array();
   $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
     3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
     7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
     10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
     13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
     16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
     19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
     40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
     70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $x < $count_length ) {
      $get_divider = ($x == 2) ? 10 : 100;
      $amount = floor($num % $get_divider);
      $num = floor($num / $get_divider);
      $x += $get_divider == 10 ? 1 : 2;
      if ($amount) {
       $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
       $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
       $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
       '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
       '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
        }
   else $string[] = null;
   }
   $implode_to_Rupees = implode('', array_reverse($string));
   $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
   return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
}


 function sendWhatsAppMessage($message1, $recipient) 
{ 
   
    // Load Composer's autoloader
    require  FCPATH . 'application/vendor/autoload.php';
    

    $CI=&get_instance();
    $twilio_whatsapp_number = TWILIO_WHATSAPP_NUMBER;
    $account_sid = 'ACb14d093f437b5832a6894fbd7ef309b7';
    $auth_token = '7308d05b9eec1a96a3a203f66819bc77';
    $twilio = new Client($account_sid, $auth_token);
    $message = $twilio->messages->create($recipient,
                [
                'body' => $message1,
                "from" => "whatsapp:+14155238886"
                ]
    );
$CI->db->insert('n_whatapp',array('qutions'=>$message1,'from'=>$recipient,'sid'=>$message->sid));


}

function get_bill($body)
{
    $CI=&get_instance();
    $n_years=$CI->db->get('n_years')->result_array();
    $tax_array=array();
    foreach($n_years as $y)
    {
       
        $CI->db->select_sum('n_tax_invoice.pending');
        $CI->db->select('n_tax_invoice.user_id');
        $CI->db->select('n_tax_invoice.year');
        $CI->db->select('n_citizen.name');
        $CI->db->from('n_citizen');
        $CI->db->group_by('n_tax_invoice.year');
        $CI->db->like('n_citizen.name',$body);
        $CI->db->where('n_tax_invoice.pending!=',0);
        $CI->db->where('n_tax_invoice.year',$y['year']);
        $CI->db->join('n_tax_invoice', 'n_tax_invoice.user_id = n_citizen.id', 'left');
        $CI->db->where('n_citizen.isdeleted',0);
        $records = $CI->db->get()->result_array();
        if($records)
        {       
        array_push($tax_array,$records[0]);
        }
            
    }

$message=array();
    foreach($tax_array as $t)
    { 
        $t['type']='n_taxes';
       $ms=array(
        'Hello '.$t['name'].'
        You have one pending tax for year '.$t['year'].' and amount is Rs.'.$t['pending'].'
        please go to blow link and pay 
        https://2af9-2409-4042-2688-1c46-ede5-1229-c398-1fa5.in.ngrok.io/what/pay/'.en1(json_encode($t))); 
       array_push($message,$ms);
    }
    return $message;                
}




function get_bill_w($body)
{
    $CI=&get_instance();
    $n_years=$CI->db->get('n_years')->result_array();
    $tax_array=array();
    foreach($n_years as $y)
    {
       
        $CI->db->select_sum('n_tax_invoice_w.pending');
        $CI->db->select('n_tax_invoice_w.user_id');
        $CI->db->select('n_tax_invoice_w.year');
        $CI->db->select('n_citizen.name');
        $CI->db->from('n_citizen');
        $CI->db->group_by('n_tax_invoice_w.year');
        $CI->db->like('n_citizen.house_no',$body);
        $CI->db->where('n_tax_invoice_w.pending!=',0);
        $CI->db->where('n_tax_invoice_w.year',$y['year']);
        $CI->db->join('n_tax_invoice_w', 'n_tax_invoice_w.user_id = n_citizen.id', 'left');
        $CI->db->where('n_citizen.isdeleted',0);
        $records = $CI->db->get()->result_array();
        echo $CI->db->last_query();
        if($records)
        {       
        array_push($tax_array,$records[0]);
        }
            
    }

$message=array();
    foreach($tax_array as $t)
    { 
        $t['type']='n_taxes_w';
       $ms=array(
        'Hello '.$t['name'].'
        You have one pending tax for year '.$t['year'].' and amount is Rs.'.$t['pending'].'
        please go to blow link and pay 
        https://2af9-2409-4042-2688-1c46-ede5-1229-c398-1fa5.in.ngrok.io/what/pay/'.en1(json_encode($t))); 
       array_push($message,$ms);
    }
    return $message;                
}



function instance()
{
   return $CI=&get_instance();
}


function totaltax($user_id,$date='')
{   
    
    $CI=instance();
    if($date=='')
    {
     $date=$CI->db->get_where('n_setting',array('name'=>'year'))->row()->value;
    }
     $CI->db->select_sum('pending');
     $CI->db->where('user_id',$user_id);
     $CI->db->where('year',$date);
       $tax=$CI->db->get('n_tax_invoice')->result_array()[0]['pending'];
     if($tax==0 AND $tax==null)
     {
         return 0;
     }
     else
     {
         return $tax;
     }

}


function totaltaxp($user_id)
{   
    
    $CI=instance();
    
    $year=$CI->db->get_where('n_setting',array('name'=>'year'))->row()->value;
    
     $CI->db->select_sum('pending');
     $CI->db->where('user_id',$user_id);
     $CI->db->where('year!=',$year);
      $tax=$CI->db->get('n_tax_invoice')->result_array()[0]['pending'];
     if($tax==0 AND $tax==null)
     {
         return 0;
     }
     else
     {
         return $tax;
     }

}















function totaltax_w($user_id,$date='')
{   
    
    $CI=instance();
    if($date=='')
    {
     $date=$CI->db->get_where('n_setting',array('name'=>'year'))->row()->value;
    }
     $CI->db->select_sum('pending');
     $CI->db->where('user_id',$user_id);
     $CI->db->where('year',$date);
      $tax=$CI->db->get('n_tax_invoice_w')->result_array()[0]['pending'];
     if($tax==0 AND $tax==null)
     {
         return 0;
     }
     else
     {
         return $tax;
     }

}


function totaltaxp_w($user_id)
{   
    
    $CI=instance();
    
    $year=$CI->db->get_where('n_setting',array('name'=>'year'))->row()->value;
    
     $CI->db->select_sum('pending');
     $CI->db->where('user_id',$user_id);
     $CI->db->where('year!=',$year);
       $tax=$CI->db->get('n_tax_invoice_w')->result_array()[0]['pending'];
     if($tax==0 AND $tax==null)
     {
         return 0;
     }
     else
     {
         return $tax;
     }

}





function select($table,$array='',$limit='',$offset='',$order='DESC')
{
    try {
     $CI=instance();
     $CI->db->trans_start();
     $CI->db->order_by('id',$order);
     if($limit)
     {
         if($offset!='')
         {
            $CI->db->limit($limit,$offset);
         }
         else
         {
            $CI->db->limit($limit);
         }
     
     }
    
     

     if($array)
     {
     $data=$CI->db->get_where($table,$array)->result_array();
     }
     else
     {
     $data=$CI->db->get($table)->result_array();
     }
     $id=$data;
     $CI->db->trans_complete();
     return $id;
    }
    catch (\Exception $e) 
    {
        die($e->getMessage());
    }
}


function status($id)
{
   return select('tranaction_status',array('name'=>$id))[0]['value'];
}

function insert($table,$array)
{
    try {
     $CI=instance();
     $CI->db->trans_start();
     $CI->db->insert($table,$array);
     $id=$CI->db->insert_id();
     $CI->db->trans_complete();
     return $id;
    }
    catch (\Exception $e) 
    {
        die($e->getMessage());
    }
}
function update($table,$array,$whare)
{
    try {
     $CI=instance();
     $CI->db->trans_start();
     $CI->db->where($whare);
     $CI->db->update($table,$array);
     $id=$CI->db->affected_rows();
     $CI->db->trans_complete();
     return $id;
    }
    catch (\Exception $e) 
    {
        die($e->getMessage());
    }
}
function en($string)
{
    $output = false;
    $en_method = "AES-256-CBC";
    $secret_key = '74be16979710d4c4e7c6647856088456';  //machie_id
    $secret_iv = '1633298400'; //unix date of registartion
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    $output = openssl_encrypt($string, $en_method, $key, 0, $iv);
    $output = base64_encode($output);
    return $output;
}

 function de($string)
 {
    $output = false;
    $en_method = "AES-256-CBC";
    $secret_key = '74be16979710d4c4e7c6647856088456';  //machie_id
    $secret_iv = '1633298400'; //unix date of registartion
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    $output = openssl_decrypt(base64_decode($string), $en_method, $key, 0, $iv);
    return $output;
}



function en1($string)
{
    $output = false;
    $en_method = "AES-256-CBC";
    $secret_key = '74be16979710d4c4e7c6647856088456';  //machie_id
    $secret_iv = '1633298400'; //unix date of registartion
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    $output = openssl_encrypt($string, $en_method, $key, 0, $iv);
    $output = base64_encode($output);
    $output=str_replace("==","",$output);
    $output=str_replace("=","",$output);
    return $output;
}

 function de1($string)
 {
     $string=$string.'==';
    $output = false;
    $en_method = "AES-256-CBC";
    $secret_key = '74be16979710d4c4e7c6647856088456';  //machie_id
    $secret_iv = '1633298400'; //unix date of registartion
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    $output = openssl_decrypt(base64_decode($string), $en_method, $key, 0, $iv);
    return $output;
}


?>