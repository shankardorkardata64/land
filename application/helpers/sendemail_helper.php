<?php
function generate_token($size=30)
{
    $CI=&get_instance();
    $CI->load->helper('string');
    return random_string('alnum', $size/2).time().random_string('alnum', $size/2);
}



function send_mail($array) 
{
   
    $sitename='Payment Gatway';
    $from_email = "shankardorkardata64@gmail.com";
    $to_email =$array['to'];'ershankardorkar@gmail.com';
    $ci = get_instance();
    $select=select('users',array('email'=>$to_email))[0];
    $array['username']='Valuable User';
    if(!empty($select))
    {
    $array['username']=$select['firstname'].' '.$select['lastname'];
    }
    
    $me=$ci->load->view('email',$array,TRUE);
    
    $ci->load->library('email');
    $config['protocol'] = "smtp";
    $config['smtp_host'] = "mail.goodphpcode.com";
    $config['smtp_port'] = "587";
    $config['smtp_user'] = 'husen17@goodphpcode.com';
    $config['smtp_pass'] = 'Shankar6557$';
    $config['charset'] = 'iso-8859-1';
    $config['mailtype'] = "html";
    $config['newline'] = "\r\n";
    $ci->email->initialize($config);
    $ci->email->from($from_email, $sitename);
    $list = array($to_email);

    $ci->email->to($list);
    $ci->email->reply_to($from_email, $sitename);  //keep comapy name 2nd option ''
    $ci->email->subject($array['subject']);
    $ci->email->message($me);
    $ci->email->send();
}

?>