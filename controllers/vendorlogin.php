<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class vendorlogin extends CI_Controller {
 
    function vendorlogin()
    {
	parent::__construct();
	$this->load->model('vendormodel');
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
	$result=$this->vendormodel->checkVendorLogin();
	if($result==0){
	    $error=$this->session->set_flashdata('error, invalid username and password');
	    redirect(base_url()."vendorlogin",'refresh');
	}
	else{
	    $this->session->set_userdata('vendorusername',$result[0]['email']);
	    $this->session->set_userdata('vendorusername',$result[0]['name']);
	    $this->session->set_userdata('vendor_code',$result[0]['vendor_code']);
	    redirect('vendorlogin/dashboard');
	}
    }
    
    function dashboard(){
	$session_data=$this->session->userdata('vendorusername');
	if($session_data){
	$this->load->view('vendor/header');
	$data['vendor_code']=$this->vendormodel->candidateCount();
	$this->load->view('vendor/dashboard',$data);
	}
	else{
	redirect('vendorlogin/index');
	}
    }
    
    function vendor(){
	$session_data=$this->session->userdata('vendorusername');
	if(!empty($session_data))
	{
	    $this->load->view('vendor/header');
	    $data['vendorDetails']=$this->vendormodel->vendorDetails();
	    $this->load->view('vendor/vendor',$data);
	}
	else{
	redirect('vendorlogin/index');
	}
    }
    function vendorAddUser(){
	$session_username = $this->session->userdata('vendorusername');
	if($session_username){
	    if(isset($_POST['Save']))
	    {
		$this->vendormodel->mailToCandiate();
	    }
	    else
	    {
		$this->load->view('vendor/header');
		$this->load->view('vendor/vendorAddUser');
	    }
	}
	else
	{
	    redirect(site_url("vendorlogin"),'refresh');
	} 
    }    
    
    function vendorEdit($id){
	$session_data=$this->session->userdata('vendorusername');
	$data['candidateDetails']=$this->vendormodel->getCandidateDetails($id);
	$data['employeeDetails']=$this->vendormodel->getEmployeeDetails($id);
	$data['educationalDetails']=$this->vendormodel->getEducationalDetails($id);
	$this->load->view('vendor/header');
	$this->load->view('vendor/vendorEdit',$data);
    }
    
    function vendorEditView($id){
	$session_data=$this->session->userdata('vendorusername');
	$data['candidateDetails']=$this->vendormodel->getCandidateDetails($id);
	$data['employeeDetails']=$this->vendormodel->getEmployeeDetails($id);
	$data['educationalDetails']=$this->vendormodel->getEducationalDetails($id);
	$this->load->view('vendor/header');
	$this->load->view('vendor/vendorEdit',$data);
    }
    
     //PDF STARTS
    public function vendorPrint($sys_head_id)
	{
		$this->load->helper('dompdf_helper');
		$data['vendorPrintDetails']=$this->vendormodel->vendorPrintDetails($sys_head_id);
		$html = $this->load->view('vendor/printDocs/vendor', $data, true);
		pdf_create($html,$stream=TRUE,'portrait');
	}
    
    //PDF ENDS 
    
//    function mailToCandiate(){
//	$session_data = $this->session->userdata('vendorusername');
//	if($session_data){
//	    $this->vendormodel->mailToCandiate();
//	}
//	else
//	{
//	    redirect(site_url("vendorlogin"),'refresh');
//	} 
//    }    
    
    function logout(){
	$this->session->unset_userdata('vendorusername');
	unset($this->session->userdata);
	redirect(base_url()."view/index",'refresh');
    }
 //======================================USER LOGIN INDEX PAGE ENDS=====================================================================
 


    
  
  
    
}	
