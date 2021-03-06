<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin extends CI_Controller {
 
    function admin()
    {
	parent::__construct();
	$this->load->model('talentModel');
	$this->load->library('session');
	$this->load->helper('url');
	$this->load->helper('file');
	$this->load->helper('form');
	$this->load->helper('cookie');
	$this->load->helper('dompdf_helper');
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
	    $this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
	    $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
	    $this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
	    $this->output->set_header('Pragma: no-cache');
    }
//==================================USER LOGIN INDEX PAGE STARTS ============================================================================
    function index(){
	$sessionData=$this->session->userdata('username_admin');

	if($sessionData=="")
	{

	    if($this->input->post('save')=='Sign me in')
	    {
		    $result=$this->talentModel->checkAdminLogin();
		    //print_r($result);
		    //exit;
		    
		    if($result==0){
			$this->session->set_flashdata('authentication','Your Username and Password is Incorrect please check it');
			redirect(base_url()."admin",'refresh');
		    }
		    else{
			$this->session->set_userdata('username_admin',$result[0]['user_name']);
			$this->session->set_userdata('userimage_admin',$result[0]['user_image']);
		     
			redirect("admin/dashboard");
		    }

	    }
	    else{
		$this->load->view('admin/index');
	    }
	}
	else{
	    redirect("admin/dashboard");
	}
    }
    
    function logout(){
	$this->session->unset_userdata('username_admin');
	unset($this->session->userdata);
	redirect(base_url()."admin",'refresh');
    }
 //======================================USER LOGIN INDEX PAGE ENDS=====================================================================
 
 
//======================================DASHBOARD STARTS=====================================================================    
    function dashboard(){
	
	
	$session_data=$this->session->userdata('username_admin');
	if($session_data!='')
	{
	    //echo $session_data=$this->session->userdata('username_admin');
	    //exit;
	    $data['vendorCount']=$this->talentModel->vendorCount();
	    $data['employeesCount']=$this->talentModel->employeesCount();
	    $this->load->view('admin/header');	
	    $this->load->view('admin/dashboard',$data);
	}
	else
	{
	    redirect(site_url("admin"),'refresh');
	}
    }
//======================================DASHBOARD ENDS=====================================================================

//======================================VENDOR USERS STARTS=====================================================================

 function loginAsVendor(){

	$session_data=$this->session->userdata('vendor_username');
	if(!empty($session_data))
	    {
		$data['vendorDetails']=$this->talentModel->getVendorReferal();
		
		$this->load->view('admin/vendorHeader');		
		$this->load->view('admin/loginAsVendor',$data);		    
	    }
	else{
	    redirect('admin/vendorDashboard');
	}
    }







//======================================VENDOR USERS ENDS=====================================================================






//======================================DASHBOARD STARTS=====================================================================    
    function vendorDashboard(){
	$session_data=$this->session->userdata('vendor_username');
	  //print_r($session_data);
	  //  exit;
	if($session_data)
	{
	    $this->load->view('admin/vendorHeader');
	    $data['vendor_code']=$this->talentModel->candidateCount();
	  
	    
	    $this->load->view('admin/vendorDashboard',$data);
	}
	else{
	    redirect(site_url(),'refresh');
	}
    }
//======================================DASHBOARD ENDS=====================================================================


//======================================VENDOR PAGE STARTS=====================================================================   
   //VIEW PAGE
    function hiringPartner(){

	$session_data=$this->session->userdata('username_admin');
	if(!empty($session_data))
	    {
		$result['vendorDetails']=$this->talentModel->vendorDetails();
		$this->load->view('admin/header');		
		$this->load->view('admin/hiringPartner',$result);		    
	    }
	    else{
		redirect('admin/dashboard');
	    }
    }
    //ADD
    function hiringPartnerAdd()
    {
	
	$session_data=$this->session->userdata('username_admin');
	if(!empty($session_data))
	{
	    if (isset($_POST["Save"])) {
		
		$this->talentModel->hiringPartnerAdd();
		$this->session->set_flashdata('status','A New record added successfully');
		redirect("admin/hiringPartner");
	    }
	    $this->load->view('admin/header');
	    
	    $this->load->view('admin/hiringPartnerAdd');
	     
	}
	    
	
    }
    //EDIT
    function hiringPartnerEdit($id)
    {
	$session_data = $this->session->userdata('username_admin');
	if(!empty($session_data))
	{
	if (isset($_POST["Update"])) {
	 
	    $this->talentModel->hiringPartnerEdit($id);
	    $this->session->set_flashdata('status','A old record updated successfully');
	    redirect("admin/hiringPartner");
	}
	$data['vendorEdit']= $this->talentModel->getVendorDetails($id);
	//echo "<pre>";
	//print_r($data['vendorEdit']);
	//echo "</pre>";
	//exit;
	$this -> load -> view('admin/header');
	$this -> load -> view('admin/hiringPartnerEdit',$data);
	}
	else{
	    redirect(site_url('admin'));
	    
	}
	
    }
    //EDIT VIEW
    function hiringPartnerEditView($id){
	
	$data['vendorEdit']= $this->talentModel->getVendorDetails($id);
	$this -> load -> view('admin/header');
	$this -> load -> view('admin/hiringPartnerEditView',$data);
    
    }

    //DELETE
     public function hiringPartnerDelete($id)
    {
	$session_data = $this->session->userdata('username_admin');
	if(!empty($session_data))
	{
        $this->talentModel->hiringPartnerDelete($id);
        $this->session->set_flashdata('status','A record deleted successfully');
        redirect("admin/hiringPartner");
	}
	else{
	    
	    redirect(site_url('admin'));   
	}
    }
    //admin profilr edit
       function adminEdit($id){
	
	$session_data=$this->session->userdata('username_admin');
	if(!empty($session_data)){
	    if(isset($_POST['Update'])){
		
		$this->talentModel->adminEdit($id);
		$this->session->set_flashdata('status','A old record updated successfully');
		redirect("admin/addUserView");
	    }
	    $data['userEdits']=$this->talentModel->getuserDetailEdit($id);
	    //print_r($data['userEdits']);exit;
	 
	    $this->load->view('admin/header');
	    $this->load->view('admin/adminEditUser',$data);
	}
	else{
	    redirect(site_url('admin'));
	}
    }
    
    //PDF STARTS
    public function hiringPartnerPrint($sys_head_id)
	{
		//$this->load->helper('dompdf_helper');
		$data['vendorPrintDetails']=$this->talentModel->vendorPrintDetails($sys_head_id);
		$html = $this->load->view('admin/printDocs/hiringPartner', $data, true);
		pdf_create($html,$stream=TRUE,'portrait');
	}
    
    //PDF ENDS 
//======================================VENDOR PAGE ENDS=====================================================================

//======================================EMPLOYEE PAGE STARTS=====================================================================   
    //ADD
    function employeeAdd()
    {
	    $session_username = $this->session->userdata('username_admin');
	    if($session_username){
		if(isset($_POST['Save']))
		{
		   // echo "<pre>";
		   // print_r($_POST);
		   // 
		   //echo  "</pre>";
		   // exit;
		   $this->talentModel->employeeAdd();
		   $this->session->set_flashdata('status','A New record added successfully');
		    redirect("admin/employee");
		}
		else
		{
		    $this->load->view('admin/header');
		    $this->load->view('admin/employeeAdd');
		    
		    
		}
	    }
	    else
	    {
		redirect(site_url("admin"),'refresh');
	    }	    
	}
    
    //EDIT
    function employeeEdit($id){
	$session_data=$this->session->userdata('username_admin');
	if(!empty($session_data)){
	    
	    if(isset($_POST['Update'])){
		
		//echo "<pre>";
		//print_r($_POST);
		//echo "</pre>";
		//exit;
		$this->talentModel->employeeEdit($id);
		$this->session->set_flashdata('status','A old record updated successfully');
		redirect("admin/employee");
	    }
	    $data['employeeEdit']=$this->talentModel->getCandidateDetails($id);
	    $data['employeeDetails']=$this->talentModel->getEmployeeDetails($id);
	    $data['educationalDetails']=$this->talentModel->getEducationalDetails($id);
	   
	    
	    //print_r($data['employeeEdit']);
	    //exit;
	    $this->load->view('admin/header');
	    $this->load->view('admin/employeeEdit',$data);
	}
	else{
	    redirect(site_url('admin'));
	}
    }
    //VIEW
    function employee(){
	$session_data=$this->session->userdata('username_admin');
	if(!empty($session_data))
	    {
		$data['employeeDetails']=$this->talentModel->employeeDetails();
		$this->load->view('admin/header');
		$this->load->view('admin/employee',$data);
	    }
	    else{
		redirect('admin/dashboard');
	    }
    }
    //EDIT VIEW
    function employeeEditView($id){
	
	$data['employeeEdit']=$this->talentModel->getCandidateDetails($id);
	$data['employeeDetails']=$this->talentModel->getEmployeeDetails($id);
	$data['educationalDetails']=$this->talentModel->getEducationalDetails($id);
	$this -> load -> view('admin/header');
	$this -> load -> view('admin/employeeEditView',$data);
    
    }
    //DELETE
     public function employeeDelete($id)
    {
	$session_data = $this->session->userdata('username_admin');
	if(!empty($session_data))
	{
        $this->talentModel->employeeDelete($id);
        $this->session->set_flashdata('status','A  record deleted successfully');
        redirect("admin/employee");
	}
	else{
	    redirect(site_url('admin'));   
	}
    }
     //PDF STARTS
    public function employeePrint($sys_head_id)
	{
	    $data['employeeHeadDetails']=$this->talentModel->employeeHeadPrintDetails($sys_head_id);
	    $data['employeeCandiateDetails']=$this->talentModel->employeeCandidatePrintDetails($sys_head_id);
	    $data['employeeDetails']=$this->talentModel->employeePrintDetails($sys_head_id);
	    $html = $this->load->view('admin/printDocs/employeePrint', $data, true);
	    pdf_create($html,$stream=TRUE,'portrait');
	}
    
    //PDF ENDS 
  //======================================EMPLOYEE PAGE ENDS=====================================================================
  
  //======================================APPLICANT PAGE STARTS=====================================================================   
   //VIEW
    function applicant(){
	$session_data=$this->session->userdata('username_admin');
	if(!empty($session_data))
	    {
		$data['applicantDetails']=$this->talentModel->applicantDetails();
		$this->load->view('admin/header');
		$this->load->view('admin/applicant',$data);
	    }
	    else{
		redirect('admin/dashboard');
	    }
    }
    //ADD
    function applicantAdd()
    {
	//print_r($_FILES);
	    if (isset($_POST["Save"])) {
		//echo "<pre>";
		//print_r($_FILES);
		//print_r($_POST);
		//exit;
		$this->talentModel->applicantAdd();
		$this->session->set_flashdata('status','A New record added successfully');
		redirect("admin/applicant");
	    }
	    $this->load->view('admin/header');
	    
	    $this->load->view('admin/applicantAdd');
	
	
	    
	
    }
    //EDIT
    function applicantEdit($id){
	$session_data=$this->session->userdata('username_admin');
	if(!empty($session_data)){
	    if(isset($_POST['Update'])){
		//print_r($_POST);
		//exit;
		$this->talentModel->applicantEdit($id);
		$this->session->set_flashdata('status','A old record updated successfully');
		redirect("admin/applicant");
	    }
	    $data['applicantEdit']=$this->talentModel->getapplicantDetails($id);
	    //$data['skill']=$this->talentModel->getskillDetails();
	    
	    //print_r($data['employeeEdit']);
	    //exit;
	    $this->load->view('admin/header');
	    $this->load->view('admin/applicantEdit',$data);
	}
	else{
	    redirect(site_url('admin'));
	}
    }
    //EDIT VIEW
    function applicantEditView($id){
	
	$data['applicantEdit']=$this->talentModel->getapplicantDetails($id);
	$this -> load -> view('admin/header');
	$this -> load -> view('admin/applicantEditView',$data);
    
    }
    //DELETE
    public function applicantDelete($id)
    {
	$session_data = $this->session->userdata('username_admin');
	if(!empty($session_data))
	{
        $this->talentModel->applicantDelete($id);
        $this->session->set_flashdata('status','A record deleted successfully');
        redirect("admin/applicant");
	}
	else{
	    
	    redirect(site_url('admin'));   
	}
    }
    //PDF STARTS
    public function applicantPrint($sys_head_id)
	{
		//$this->load->helper('dompdf_helper');
		$data['applicantDetails']=$this->talentModel->applicantPrintDetails($sys_head_id);
		$html = $this->load->view('admin/printDocs/applicantPrint', $data, true);
		pdf_create($html,$stream=TRUE,'portrait');
	}
    
    //PDF ENDS 
 //======================================APPLICANT  PAGE ENDS=====================================================================
 
 //======================================ADD USER PAGE STARTS=====================================================================   
  //VIEW
    function addUserView(){
	$session_data=$this->session->userdata('username_admin');
	if(!empty($session_data))
	    {
		$data['userDetails']=$this->talentModel->userDetails();
		$this->load->view('admin/header');
		$this->load->view('admin/addUserView',$data);
	    }
	    else{
		redirect('admin/dashboard');
	    }
	
    }
    
    //ADD
    function userAdd(){
	
	    if (isset($_POST["Save"])) {
		
		$this->talentModel->addUser();
		$this->session->set_flashdata('status','A New record added successfully');
		redirect("admin/addUserView	");
	    }
	    $this->load->view('admin/header');
	    
	    $this->load->view('admin/addUser');
	
    }
    //EDIT
    function editUser($id){
	$session_data=$this->session->userdata('username_admin');
	if(!empty($session_data)){
	    if(isset($_POST['Update'])){
		
		$this->talentModel->editUser($id);
		$this->session->set_flashdata('status','A old record updated successfully');
		redirect("admin/addUserView");
	    }
	    $data['userEdit']=$this->talentModel->getuserDetails($id);
	 
	    $this->load->view('admin/header');
	    $this->load->view('admin/editUser',$data);
	}
	else{
	    redirect(site_url('admin'));
	}
    }
    //DELETE
    public function userDelete($id)
    {
	$session_data = $this->session->userdata('username_admin');
	if(!empty($session_data))
	{
        $this->talentModel->userDelete($id);
        $this->session->set_flashdata('status','A  record deleted successfully');
        redirect("admin/addUserView");
	}
	else{
	    
	    redirect(site_url('admin'));   
	}
    }
    //EDIT VIEW
    function addUserEditView($id){
	$data['userEdit']=$this->talentModel->getuserDetails($id);
	$this -> load -> view('admin/header');
	$this -> load -> view('admin/addUserEditView',$data);
	
    }
    //======================================USER ADD PAGE ENDS=====================================================================   
    //username already exits
    function userCheck(){
	header('Content-Type: application/json');
	$email=$this->input->post('email');
	$viewresult=$this->talentModel->ajaxUserView($email);

	if($viewresult==0)
	{
	    echo json_encode(array('valid'=>'true'));
	    
	}
	else
	{
	    echo json_encode(array('valid'=>'false'));
	}
	
    }
   //======================================REGISTER USER PAGE STARTS=====================================================================    
    function registerUser(){
	$session_data=$this->session->userdata('username_admin');
	if(!empty($session_data))
	    {
		$data['registerUser']=$this->talentModel->registerUser();
		$this->load->view('admin/header');
		$this->load->view('admin/registerUser',$data);
	    }
	    else{
		redirect('admin/dashboard');
	    }
    }
    //======================================REGISTER USER PAGE ENDS=====================================================================   
    function sendCredential(){	
        $result=$this->talentModel->sendCredentialToUser();
	echo json_encode($result);	
    }
    
    function sendUserCredential(){
        $result=$this->talentModel->sendUserCredential();
	echo json_encode($result);	
    }


    function vendorAddUser(){
	$session_username = $this->session->userdata('vendor_username');
	if($session_username){
	    if(isset($_POST['save']))
	    {
		$result=$this->tc_model->vendorAddUser();
		$this->session->set_flashdata('status', 'Your Vendor Information has been Succesfully Saved');
		redirect('talentcapitalctr/hiringPartner');
	    }
	    else
	    {
		$this->load->view('admin/vendorHeader');
		$this->load->view('admin/vendorAddUser');
	    }
	}
	else
	{
	    redirect(site_url("admin"),'refresh');
	}	
    }


    function vendorloginEdit($id){
	$session_data = $this->session->userdata('vendor_username');
	if($session_data){
	    $this->load->view('admin/vendorHeader');
	    $data['vendorloginEditRow']=$this->talentModel->vendorloginEdit($id);
	    $this->load->view('admin/vendorloginEdit',$data);
	}
	else
	{
	    redirect(site_url("admin"),'refresh');
	}	
    }
    function vendorloginEditReadOnly($id){
	$session_data = $this->session->userdata('vendor_username');
	if($session_data){
	    $this->load->view('admin/vendorHeader');
	    $data['vendorloginEditRow']=$this->talentModel->vendorloginEdit($id);
	    $this->load->view('admin/vendorloginEditReadOnly',$data);
	}
	else
	{
	    redirect(site_url("admin"),'refresh');
	}	
    }
    
    function mailToCandiate(){
	$session_data = $this->session->userdata('vendor_username');
	if($session_data){
	    $this->talentModel->mailToCandiate();
	}
	else
	{
	    redirect(site_url("admin"),'refresh');
	}	
    }
    function settings(){
    $session_data=$this->session->userdata('username_admin');
	if(!empty($session_data))
	    {
		
		$this->load->view('admin/header');
		$this->load->view('admin/settings');
	    }
	    else{
		redirect('admin/dashboard');
	    }
	
    }

}	
