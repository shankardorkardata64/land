<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Twilio\Rest\Client;
// Load Composer's autoloader
require  FCPATH . 'application/vendor/autoload.php';

class Auth extends CI_Controller 
{




    public function index()
	{  
		alv('auth/login');
    }
	

  public function twofa()
  {
	$select=select('users',array('token'=>$this->session->userdata('token')))[0];
	if(!empty($select))
	{
	$data['otp']='';
	$data['token']=$select['token'];
	alv('auth/twofa',$data);
	}
	else
	{
	die('usernot found');
	}  
}

 public function verifyfa()
 {

	 $token=$this->input->post('token');
	 $otp=$this->input->post('otp');
	 $select=select('users',array('token'=>$token))[0];
	 if(empty($select))
	 {
		die('usernot found');
	 }
	  $email_opt=$select['twofa'];
	  $email_verified=$select['email_verified'];
	  if($email_verified==1)
	  {
		
		  if($email_opt==$otp)
		  {
			$this->userloginsession($select);
		  }
		  else
		  {
			  $type='error';
			  $message='You have Enterd Wrong CODE';
			  setalert($message,$type);
			  redirect('two-fa');
		  }
	  }
	  else
	  {
		$type='error';
		$message='Email is not verified';
		setalert($message,$type);
		redirect('login');
	  }

 }



	public function resendfa()
	{
		$select=select('users',array('token'=>$this->session->userdata('token')))[0];
		if($select)
		{
		$this->twofacode($select);  
		}
	  }


	private function userloginsession($select)
	{
		$admin_data = array(
			'id' => $select['id'],
			'username' => $select['username'],
			'name' => $select['fname'].' '.$select['name'],
			'role' => $select['role'],
			'rolename' => $this->db->get_where('usertype',array('id'=>$select['role']))->row()->name,
			);

			$this->session->set_userdata($admin_data);
			$message='Sucessfully Loged in';
			setalert($message);
			redirect('dashboard');
	}
	private function  twofacode($select)
	{
		$twofa=generate_token(6);
		$ms='This is Your Verification code :-'.$twofa;
		$array=array('to'=>$select['email'],'subject'=>'Verify Your Two FA  Code',
		'message'=>$ms);
		send_mail($array);
		$this->session->set_userdata('token',$select['token']);
		update('users',array('twofa'=>$twofa),array('id'=>$select['id']));
		$message='Check Your email('.subs($select['email'],10).') for Two Factor Authentication Code';
		setalert($message);
		redirect('two-fa');
	}
	public function login()
	{
      $password=$this->input->post('password');
	  $username=$this->input->post('username');
	  $select=select('users',array('username'=>$username))[0];
	  if(!empty($select))
	  {
    	 $validPassword = password_verify($password, $select['password']); //die();
     	if($validPassword)
	 	{
			 if($select['status']==1)
			 {
              $this->userloginsession($select);
			 }
			 else
			 { 
				$type='error';
				$message='Your Account is deactivated';
				setalert($message,$type);
				redirect('login'); 
			 }
		 }
	 	else
	 	{
		$type='error';
		$message='Invalid Credentials';
		setalert($message,$type);
		redirect('login'); 
	 	}

	  }
	  else
	  {
		$type='error';
		$message='Invalid Credentials';
		setalert($message,$type);
		redirect('login');
	  }

	}


	public function logout(){
		$this->session->sess_destroy();
		$type='error';
		$message='Sucessfully Loged OUT';
		setalert($message,$type);
		redirect('login');
	}
    public function register()
	{   
	
		$this->load->library('form_validation');
		if($_POST)
		{ 
			
			$this->form_validation->set_error_delimiters('<div class="form_validation_error">', '</div>');
			$this->form_validation->set_rules('firstname', 'First Name', 'required');
			$this->form_validation->set_rules('lastname', 'Last Name', 'required');
			$this->form_validation->set_rules('country', 'Country', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');

			if ($this->form_validation->run() == FALSE)
			{
            alv('auth/register');
            }
			else
			{	
            $data['fname']=escape($this->input->post('firstname'));
			$data['lname']=escape($this->input->post('lastname'));
			$data['email']=escape($this->input->post('email'));
			$data['username']=escape($this->input->post('username'));
			$data['password']=password_hash($this->input->post('password'), PASSWORD_BCRYPT);
            $data['county']=escape($this->input->post('country'));
			$array=array('to'=>$data['email'],'subject'=>'Verify Your Email','message'=>$otp);
			$data1=insert('users',$data);
		    if($data1!='')
			{ 
				$message='Sucessfully Registraion Done Sucessfully';
				setalert($message);
			    redirect('login/'.$token);
			}
			else
			{
				$type='error';
				$message='Try again';
				setalert($message,$type);
			    redirect('register');
			}
            

			}


		}
		else
		{
		alv('auth/register');
		}
	}


	public function resendotp($token)
	{
		$select=select('users',array('token'=>$token))[0];
		$otp=$select['email_opt'];
		$array=array('to'=>$select['email'],'subject'=>'Verify Your Email','message'=>$otp);
			    send_mail($array);
			    $message='Check Your Email('.subs($select['email'],10).') for OTP Code';
				setalert($message);
			    redirect('email-verify/'.$token);
	}
    public function verify_view($token='')
	{ 
	
		if($_POST)
		{
					$token=$this->input->post('token');
					$otp=$this->input->post('otp');
                    $select=select('users',array('token'=>$token))[0];
					$email_opt=$select['email_opt'];
					$email_verified=$select['email_verified'];
                     if($email_verified==0)
					 {
						 if($email_opt==$otp)
						 {
							update('users',array('email_verified'=>1),array('id'=>$select['id']));
							$message='Email Verified Sucessfully';
							setalert($message);
							redirect('login');
						 }
						 else
						 {
							 $type='error';
							 $message='You have Enterd Wrong OTP';
							 setalert($message,$type);
							 redirect('email-verify/'.$token);
						 }
					 }
		}
		else
		{
        $data['token']=$token;
		$data['otp']='';
		if(isset($_GET['otp']))
		{
          $data['otp']=$_GET['otp'];
		}
		alv('auth/verify_view',$data);	
	    }
	}


	


}
