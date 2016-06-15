<?php
class vendormodel extends CI_Model {


    
    function checkVendorLogin()
    {
	$user_id = $this->input->post('email');
	$password = $this->input->post('password');
	$sql="SELECT * FROM vendor where email='$user_id' AND password='$password' and status='Y'";
	$query = $this->db->query($sql, $return_object = TRUE);
	if($query->num_rows > 0){
	    return $query->result_array();
	}
	else
	{
	    return false;
	}
    }
   
    function candidateCount(){
	$vendor_code = $this->session->userdata('vendor_code'); 
	$sql="SELECT COUNT(vendor_code) vendor_code FROM emp_candidate_details where vendor_code='$vendor_code'";
	return $this->db->query($sql, $return_object = TRUE)->result_array();
	
    
    
    }
    
    function vendorDetails(){
	$vendor_code = $this->session->userdata('vendor_code'); 
	$sql="SELECT *  FROM emp_candidate_details where vendor_code='$vendor_code'";
	return $this->db->query($sql, $return_object = TRUE)->result_array();
	
    
    
    }
    function vendorPrintDetails($sys_head_id)
    {
	$sql="SELECT * FROM emp_candidate_details where id='$sys_head_id'";
     	return $this->db->query($sql, $return_object = TRUE)->result_array();
    }
    
    
    function getCandidateDetails($id){
	
	$sql="SELECT *  FROM emp_candidate_details where id='$id'";
	return $this->db->query($sql, $return_object = TRUE)->result_array();
	
    }
    function getEmployeeDetails($id){
	
	$sql="SELECT *  FROM employement_details where head_id='$id'";
	return $this->db->query($sql, $return_object = TRUE)->result_array();

    }
    function getEducationalDetails($id){
	
	$sql="SELECT *  FROM educational_details where head_id='$id'";
	return $this->db->query($sql, $return_object = TRUE)->result_array();
	
    }
    //Vendor Login functionality Ends
    function mailToCandiate(){
	$session_username = $this->session->userdata('vendorusername');
	$vendorCode = $this->input->post('vendor_code');
	$email = $this->input->post('email');
	
	$this->mailToCandidate($email,$vendorCode,$session_username);
    }
    //vendor edit
     function getvendorDetailEdit($id){
    
	$sql="SELECT vendor_code,name,mobile_number,email,profile_pic FROM vendor where vendor_code='$id'";
       
	return $this->db->query($sql, $return_object = TRUE)->result_array();
    }
    
    function adminVendorEdit($id){
	$folderPath = $config['upload_path'] = 'upload/';
	$config['allowed_types'] = 'gif|jpg|png|pdf';
	$this->load->library('upload', $config);
	$this->upload->do_upload('profile_pic');
	$data = $this->upload->data();
	$filePath=$folderPath.$data['file_name'];
	if($_FILES['profile_pic']['name']=="")
	    {
		$filePath=$this->input->post('oldimage');
	    }
	$data = array(
	    'name'=>$this->input->post('name'),
	    'mobile_number'=>$this->input->post('mobile_number'),
	    'email'=>$this->input->post('email'),
	    'profile_pic'=>$filePath,
	);
	
        $this->db->where("vendor_code",$id);
	$this->db->update("vendor",$data);

    }
    
    
    function mailToCandidate($email,$vendorCode,$session_username)
    {
	//print_r($session_username);
	//exit;
	$body ="<html>
		    <head>
			<title>Welcome to Talent Capital</title>
		    </head>
		    <body>
			<h3>Dear Candidate</h3>
			<p>You are refered to register in Talent Capital India by <span >".$session_username."</span></p>
			<p>Please click below link to register with talent capital</p>
			<p>".base_url()."talentcapitalctr/hiringPartnerLink/".$vendorCode."</p>
			<br>
			<p>Regards,</p>
			<p>Talent capital Portal,</p>
			<p>To contact the Talent Capital India Team, click the link below:</p>
			<p>https://www.talentcapitalindia.com/support</p>
			<img src='http://appimagine.com/talentcapital/assets/images/logo.png' style='width:100px'>
		    </body>
		</html>";
	$this->email->set_newline("\r\n");
	$this->email->from('donotreply@talentcapitalindia.com'); // change it to yours
	$this->email->to($email);// change it to yours
	$this->email->subject('Talent capital India - Please register with us');
	$this->email->message($body);
	if($this->email->send()){
	    $this->session->set_flashdata('status', 'Email has been sent to User Successfully');
	    redirect('vendorlogin/vendorAddUser');
	}else{
	    $this->session->set_flashdata('status', 'Email has not sent to User');
	    redirect('vendorlogin/vendorAddUser');
	}
    }
}