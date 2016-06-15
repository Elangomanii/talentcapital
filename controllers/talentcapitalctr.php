<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class talentcapitalctr extends CI_Controller {
    public function __construct()
    {
	parent::__construct();
	    $this->load->model('talentcapitalmodel','tc_model');
	    $this->load->helper('url');
	    $this->load->library('session');
	    $this->load->helper('cookie');
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
	      
	      //'protocol' => 'smtp',
	      // 'smtp_host' => 'mbox.s214.sureserver.com',
	      // 'smtp_port' => 465,
	      // 'smtp_user' => 'donotreply@talentcapitalindia.com', // change it to yours
	      // 'smtp_pass' => '09062016', // change it to yours
	       //'mailtype' => 'html',
	     // 'smtp_crypto'=>'ssl',
	      // 'charset' => 'iso-8859-1',
	      // 'wordwrap' => TRUE
	    );
	    
	$this->load->library('email', $config);
	$this->load->helper('string');
        }
	
	public function index($user)
	{
	    
	    if($_POST['save'] == "Register Now")
	    {
		//echo "hi";
		//print_r($_POST);
		//exit;
		if($this->input->post('login_types')=='vendor')
		{
		    
		    $result=$this->tc_model->vendorAdd();
		    
		    if($result!="")
		    {
			$this->session->set_flashdata('error', 'Invalid User Id and Password Please check it');
		        redirect(site_url());
		    }else{
			$this->session->set_flashdata('status','You are Successfully Registered with Talent Capital, Please check your Email to Proceed');
			redirect('talentcapitalctr/successMsg');
		    }
		}
		else{
		    $result=$this->tc_model->internalEmployeeAdd();
		    if($result==0)
		    {
		        $this->session->set_flashdata('error', 'Invalid User Id and Password Please check it');
		        redirect(site_url());
		    }else{
			$this->session->set_flashdata('status','You are Successfully Registered with Talent Capital, Please check your Email to Proceed');
		        redirect('talentcapitalctr/successMsg');
		    }
		}
	    }
	    else if($_POST['save'] == "Sign me in")
	    {
		if($_POST['login_types']=='vendor'){
		    require_once('vendorlogin.php');
		    $newValu=new vendorlogin();
		    $newValu->index();
		}/*else{
		    require_once('admin.php');
		    $newValu=new admin();
		    $newValu->index();
		}*/
		//print_r($_POST);exit;
		//if(isset($_GET['user']))
		//{
		//    $loginUser['user']=$user;
		//    
		//}
		//else
		//{
		//    $loginUser['user']="";
		//}
	    }else{
		$this->load->view('view/index',$loginUser);
		$this->load->view('view/footer');
		
	    }
	}
	function vendorRegister($uniqueCode)
	{
	    if(isset($_POST['save']))
	    {
		//print_r($_POST);
		//exit;
		$this->tc_model->updateVendorRegister($uniqueCode);
		
	    }
	    else{
		$data['getVendorDetails'] = $this->tc_model->getVendorRegister($uniqueCode);
		$this->load->view('view/header');
		$this->load->view('view/vendor',$data);
		$this->load->view('view/footer');		
	    }
	}
	
	function applicantRegister($uniqueCode){

	    if(isset($_POST['save']))
	    {
		$this->tc_model->updateApplicantRegister($uniqueCode);
		$this->session->set_flashdata('status', 'Your information has been successfully registered');
		redirect('talentcapitalctr/successMsg');
	    }
	    else{
		$data['getApplicantDetails'] = $this->tc_model->getApplicantRegister($uniqueCode);
		$this->load->view('view/header');
		$this->load->view('view/internalEmployee',$data);
		$this->load->view('view/footer');		
	    }	    
	    
	}
	
	function applicantVerification($uniqueCode){
	    $result = $this->tc_model->applicantEmailCheck($uniqueCode);
	    if($result == 0){
		$this->session->set_flashdata('error', 'Your Email is not verified');
		redirect('talentcapitalctr/index');
	    }else{
		redirect('talentcapitalctr/internalEmployee');
	    }
	}
	//function emailNotificationPage(){
	//    $this->load->view('header');
	//    
	//    $this->load->view('footer');
	//}
	function vendor()
	{
	    if(isset($_POST['save'])){
		$result=$this->tc_model->vendorAdd();
		$this->session->set_flashdata('status', 'Your Vendor Information has been Succesfully regeistered to talent capital');
		redirect('talentcapitalctr/successMsg');
	    }
	    else{
		$this->load->view('view/header');
		$this->load->view('view/vendor');
		$this->load->view('view/footer');
	    }
	}

	function internalEmployee()
	{
	    if(isset($_POST['save']))
	    {
		$result=$this->tc_model->internalEmployeeAdd();
		$this->session->set_flashdata('status', 'Your Information has been Succesfully regeistered to talent capital');
		redirect('talentcapitalctr/successMsg');
	    }
	    else
	    {
		$this->load->view('view/header');
		$this->load->view('view/internalEmployee');
		$this->load->view('view/footer');
	    }
	}
	
	
	function CheckEmailExist(){
	    header('Content-Type: application/json');
	    $emailCheck=$this->input->post('email');
	    if($emailCheck==""){
		$emailCheck=$this->input->post('mail_id');
	    }
	    $sql="SELECT * FROM vendor INNER JOIN emp_candidate_details WHERE email = '$emailCheck' OR mail_id = '$emailCheck'";
	    $query = $this->db->query($sql)->result_array();
	    //print_r($sql);
	    //print_r($query);exit;
	    if(count($query)==0)
	    {
		echo json_encode(array('valid'=>'true'));
	    }
	    else
	    {
		echo json_encode(array('valid'=>'false'));
	    }
	}

	function forgetPassword(){
	    if(isset($_POST['forgotsave']))
	    {
		$result=$this->tc_model->getPassword();
	    }
	    else{
		$this->load->view('view/forgotpassword');	    
	    }
	}
	
	function resetPassword($fPassToken){
	    if(isset($_POST['resetSave']))
	    {
		$this->tc_model->updatePassword($fPassToken);
	    }
	    else{
		$this->load->view('view/resetPassword');
	    }	    
	}
	
	function successMsg(){
	    $this->load->view('view/header');
	    $this->load->view('view/success');
	}
	
	function hiringPartnerLink($code){
	    $data['Vcode'] =  $code;
	    if(isset($_POST['save'])){
		//print_r($_POST);
		//exit;
		$result=$this->tc_model->hiringPartnerLinkAdd($code);
		$this->session->set_flashdata('status', 'Your Information has been Succesfully regeistered to talent capital');
		redirect('talentcapitalctr/successMsg');		
	    }
	    else{
		$data['vendorName']=$this->tc_model->getVendorName($code);
		$this->load->view('view/header');
		$this->load->view('view/hiringPartnerlink',$data);
		$this->load->view('view/footer');		
	    }
	}
    }