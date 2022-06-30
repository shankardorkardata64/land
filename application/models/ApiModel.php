<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiModel extends CI_Model {

    var $client_service = "frontend-client";
    var $auth_key       = "simplerestapi";

    public function check_auth_client()
    {
        $Merchantkey = $this->input->get_request_header('Merchant-Id', TRUE);
        $publickey  = $this->input->get_request_header('Public-Key', TRUE);
        $client_service  = $this->input->get_request_header('Client-Service', TRUE);
        $select=@select('users',array('token'=>$Merchantkey))[0];
        $user_id=@$select['id'];
        $keys_num=@$this->db->get_where('api_keys',array('status'=>1,'user_id'=>$user_id,'public_key'=>$publickey))->num_rows();
        $ip=$_SERVER['REMOTE_ADDR'];
       
        
       
/*********LOG *******/
        $input=file_get_contents('php://input');
        $log['user_id']=$user_id;	$log['ip']=$ip;	$log['input']=$input;
/***********LOG End */

        if($client_service == $this->client_service && $keys_num !=0)
        {
            
            $log['status']='Authorized Access';
            insert('api_ip_logs',$log);
            return true;
        }
        else
        {   $log['status']='Unauthorized Access';
            insert('api_ip_logs',$log);
            return json_output(401,array('status' => 401,'message' => 'Unauthorized.'));
        }



    }

}

?>