<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class internalemployee extends CI_Controller {
 
    function internalemployee()
    {
	parent::__construct();
	$this->load->model('internalempmodel','emp_model');
	$this->load->model('talentcapitalmodel','tc_model');
	$this->load->library('session');
	$this->load->helper('url');
	$this->load->helper('file');
	$this->load->helper('form');
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	$config = Array(
	 
	   'protocol' => 'smtp',
	   'smtp_host' => 'secure.emailsrvr.com',
	   'smtp_port' => 465,
	   'smtp_user' => 'customerservice.eg@sedar.email', // change it to yours
	   'smtp_pass' => 'Sedar421', // change it to yours
	   'mailtype' => 'html',
	  'smtp_crypto'=>'ssl',
	   'charset' => 'iso-8859-1',
	   'wordwrap' => TRUE
	);
	$this->load->library('email', $config);
	$this->load->helper('string');	
    }
//==================================USER LOGIN INDEX PAGE STARTS ============================================================================
    function index(){
	$sessionData=$this->session->userdata('username_employee');

	if($sessionData=="")
	{

	    if($this->input->post('save')=='Sign me in')
	    {
		    $result=$this->emp_model->checkEmpLogin();
		    //print_r($result);
		    //exit;
		    
		    if($result==0){
			$this->session->set_flashdata('authentication','Your Username and Password is Incorrect please check it');
			redirect(base_url()."admin",'refresh');
		    }
		    else{
			$this->session->set_userdata('username_employee',$result[0]['user_name']);
			$this->session->set_userdata('user_email',$result[0]['email']);
                        $this->session->set_userdata('employee_role',$result[0]['role']);
			$this->session->set_userdata('employee_code',$result[0]['intemp_code']);
		     
			redirect("internalemployee/dashboard");
		    }

	    }
	    else{
		$this->load->view('internalemployee/index');
	    }
	}
	else{
	    redirect("internalemployee/dashboard");
	}
    }
    
    function logout(){
	$this->session->unset_userdata('username_employee');
	unset($this->session->userdata);
	redirect(base_url()."internalemployee",'refresh');
    }
    
    function dashboard(){
        
        $session_data=$this->session->userdata('username_employee');
	if($session_data!=''){
	$this->load->view('internalemployee/header');
	$data['internalEmp_Code']=$this->emp_model->candidateCount();
	$this->load->view('internalemployee/dashboard',$data);
	}
	else{
	redirect('internalemployee/index');
	}
    }
    
    function internalEmployeeView()
    {
        $session_data=$this->session->userdata('username_employee');
	if(!empty($session_data))
        {
            $result['internalDetails']=$this->emp_model->internalEmpDetails();
            $this->load->view('internalemployee/header');		
            $this->load->view('internalemployee/internalEmployeeView',$result);		    
        }
        else{
            redirect('internalemployee/dashboard');
        }
    }
    
    function intEmpAddUser(){
        $session_username = $this->session->userdata('username_employee');
	if($session_username){
	    if(isset($_POST['Save']))
	    {
		$this->emp_model->mailToCandiate();
	    }
	    else
	    {
		$this->load->view('internalemployee/header');
		$this->load->view('internalemployee/intEmpAdd');
	    }
	}
	else
	{
	    redirect(site_url("internalemployee"),'refresh');
	}  
    }
    
    function internalEmployeeLink($code){
	
	    $data['Vcode'] =  $code;
	    if(isset($_POST['save'])){
		$loginType = "InternalEmployee";
		$result=$this->tc_model->hiringPartnerLinkAdd($code,$loginType);
		$this->session->set_flashdata('status', 'Your Information has been Succesfully regeistered to talent capital');
		redirect('talentcapitalctr/successMsg');		
	    }
	    else{
		$this->load->view('view/header');
		$this->load->view('internalemployee/internalEmployeeLink',$data);
		$this->load->view('internalemployee/footer');		
	    }
	}
	
    function candidate_status()
    {
	//print_r($_POST);
	//exit;
        $session_username = $this->session->userdata('username_employee');
	$candidate_status = $this->input->post('candidate_status');
	$candidate_id =$this->input->post('candidate_id');
	
	$result=$this->emp_model->Change_Candidate_status($candidate_id,$candidate_status);
	
	echo json_encode(array('sccess'=>$candidate_status));
	//print_r($result);
	//exit;
    }
    
    


    
  
  
    
}	
