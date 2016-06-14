<?php
class talentModel extends CI_Model {


    
    function checkAdminLogin()
    {
	$email = $this->input->post('email');
	$password = $this->input->post('password');
	$sql="SELECT * FROM login_auth where email='$email' AND password='$password'";
	$query = $this->db->query($sql, $return_object = TRUE);
	//print_r($query->num_rows);
	//exit;
	if($query->num_rows > 0){
	    return $query->result_array();
	}
	else
	{
	    return false;
	}
    }
    
    //1.USER VIEW STARTS
    function userDetails(){
	 $sql="SELECT * FROM login_auth order by id DESC";
     	return $this->db->query($sql, $return_object = TRUE)->result_array();
    }
    
    //add
    function addUser(){
	  $folderPath = $config['upload_path'] = 'upload/';
            $config['allowed_types'] = 'gif|jpg|png|pdf';
                  
            $this->load->library('upload', $config);
            $this->upload->do_upload('user_image');
            $data = $this->upload->data();
            $filePath=$folderPath.$data['file_name'];
	$data = array(
	    'role'=>$this->input->post('user_role'),
	    'user_name'=>$this->input->post('username'),
	    'password'=>$this->input->post('password'),
	    'email'=>$this->input->post('email'),
	    'user_image'=>$filePath,
	    'status'=>'Y',
	    );
	      
	    $this->db->insert("login_auth",$data);
	    
    }
    
    function getuserDetails($id){
    
     $sql="SELECT * FROM login_auth where id='$id'";
     return $this->db->query($sql, $return_object = TRUE)->result_array();
    }
    
     function editUser($id){
      $folderPath = $config['upload_path'] = 'upload/';
            $config['allowed_types'] = 'gif|jpg|png|pdf';
                   
            $this->load->library('upload', $config);
            $this->upload->do_upload('user_image');
            $data = $this->upload->data();
            $filePath=$folderPath.$data['file_name'];
             if($_FILES['user_image']['name']=="")
		{
			$filePath=$this->input->post('oldimage');
		}
	$data = array(
	    'user_name'=>$this->input->post('username'),
	    'password'=>$this->input->post('password'),
	    'email'=>$this->input->post('email'),
	    'user_image'=>$filePath,
	    );
	      
	   $this->db->where("id",$id);
	    $this->db->update("login_auth",$data);
     
     
     }
    
    //UserDelete
    function userDelete($id){
	$this->db->where("id",$id);
	$this->db->delete("login_auth");
    }
    
    
    //already user exits
    function ajaxUserView($email)
        {
        $sql="SELECT * FROM login_auth where email='$email'";
        $result=$this->db->query($sql)->result();
	return count($result);
        }
    
        function sendUserCredential(){
	$userEmail = $_POST['userEmail'];
	$userName = $_POST['userName'];
	$statusYN = $_POST['statusYN'];
	$this->db->where('email', $userEmail);
	$data = array(
	    'status' => $statusYN
	);
	$this->db->update('login_auth', $data);
	$this->db->affected_rows();
	if($statusYN=="Y"){
	    $this->userEmailSending($userEmail,$userName,$statusYN);
	}else{
	    $this->userRejectEmailSending($userEmail,$userName,$statusYN);
	}
	
    }
    function userEmailSending($userEmail,$userName,$statusYN)
    {
	$body ="<html>
		    <head>
			<title>Welcome to Talent Capital</title>
		    </head>
		    <body>
			<h4>Dear $userName,</h4>
			<p>You have been Activated.</p>
			<p> <a href='".base_url()."vendorlogin/index/hiringPartner' >Click Here</a> </p>
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
	$this->email->to($userEmail);// change it to yours
	$this->email->subject('Talent Capital India - activation Mail');
	$this->email->message($body);
	
	if($this->email->send()){
	    if($statusYN=="Y"){
		$this->session->set_flashdata('status', 'User has been approved successfully');
	    }
	}else{
	    $this->session->set_flashdata('status', 'User has not approved');	
	}
    }
    
    function userRejectEmailSending($userEmail,$userName,$statusYN)
    {
	$body ="<html>
		    <head>
			<title>Welcome to Talent Capital</title>
		    </head>
		    <body>
			<h4>Dear $userName,</h4>
			<p>You have been Rejected.</p>
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
	$this->email->to($userEmail);// change it to yours
	$this->email->subject('Talent Capital India - activation Mail');
	$this->email->message($body);
	
	if($this->email->send()){
	    if($statusYN=="N"){
		$this->session->set_flashdata('status', 'User has been Rejected successfully');
	    }
	}else{
	    $this->session->set_flashdata('status', 'User has not approved');	
	}
    }
    
    //USER VIEW ENDS
    
    
    
    function vendorDetails()
    {
	$sql="select * from vendor where login_types= 'vendor'";
     	return $this->db->query($sql, $return_object = TRUE)->result_array();
    }
    
    function getVendorReferal()
    {
	$vendorcode=$this->session->userdata('vendorcode');
	$sql="SELECT * FROM vendor where vendor_code='$vendorcode'";
     	return $this->db->query($sql, $return_object = TRUE)->result_array();
    }
    
    function vendorPrintDetails($sys_head_id)
    {
	$sql="SELECT * FROM vendor where id='$sys_head_id'";
     	return $this->db->query($sql, $return_object = TRUE)->result_array();
    }
    
    function applicantPrintDetails($sys_head_id)
    {
	$sql="SELECT * FROM applicant where id='$sys_head_id'";
     	return $this->db->query($sql, $return_object = TRUE)->result_array();
    }
    function employeeHeadPrintDetails($sys_head_id)
    {
	$sql="SELECT * FROM emp_candidate_details where id='$sys_head_id'";
     	return $this->db->query($sql, $return_object = TRUE)->result_array();
    }
    function employeeCandidatePrintDetails($sys_head_id)
    {
	$sql="SELECT * FROM educational_details where id='$sys_head_id'";
     	return $this->db->query($sql, $return_object = TRUE)->result_array();
    }
    function employeePrintDetails($sys_head_id)
    {
	$sql="SELECT * FROM employement_details where id='$sys_head_id'";
     	return $this->db->query($sql, $return_object = TRUE)->result_array();
    }
    
    
    function vendorAdd(){
	    $folderPath = $config['upload_path'] = 'upload/';
            $config['allowed_types'] = 'gif|jpg|png|pdf';
                 
            $this->load->library('upload', $config);
            $this->upload->do_upload('vendor_pancard_image');
            $data = $this->upload->data();
            $filePath=$folderPath.$data['file_name'];
	
	$data= array(
	   
	    'username'=>$this->input->post('username'),
	    'mobileno'=>$this->input->post('mobileno'),
	    'email'=>$this->input->post('email'),
	    'vendor_pancard_no'=>$this->input->post('vendor_pancard_no'),
	    'vendor_pancard_image'=>$filePath,
	    'location'=>$this->input->post('location'),
	);
	
	 $this->db->insert('register_users',$data);
    }
    
    function vendorEdit($id){
	    $folderPath = $config['upload_path'] = 'upload/';
            $config['allowed_types'] = 'gif|jpg|png|pdf';
                 
            $this->load->library('upload', $config);
            $this->upload->do_upload('vendor_pancard_image');
            $data = $this->upload->data();
            $filePath=$folderPath.$data['file_name'];
	    
	    if($_FILES['vendor_pancard_image']['name']=="")
	    {
		    $filePath=$this->input->post('oldimage');
	    }
			  
            
                 
	$data = array(
		'username'=>$this->input->post('username'),
		'mobileno'=>$this->input->post('mobileno'),
		'email'=>$this->input->post('email'),
		//'vendor_pancard_no'=>$this->input->post('vendor_pancard_no'),
		//'vendor_pancard_image'=>$filePath,
		//'location'=>$this->input->post('location'),
	       );
		    $this->db->where("id",$id);
		    $this->db->update("	",$data);
    }
    function getVendorDetails($id){
	$sql="SELECT * FROM vendor where id='$id'";
        return $this->db->query($sql, $return_object = TRUE)->result_array();
    }
   function hiringPartnerDelete($id){
    $this->db->where("id",$id);
    $this->db->delete("vendor");
   }
   
  
    function employeeDetails()
    {
	
	$sql="SELECT * FROM emp_candidate_details order by id desc";
     	return $this->db->query($sql, $return_object = TRUE)->result_array();
    }
    
    
    function employeeAdd()
        {
            $folderPath = $config['upload_path'] = 'upload/';
            $config['allowed_types'] = 'gif|jpg|png|pdf';     
            $this->load->library('upload', $config);
            $this->upload->do_upload('pan_card_attach');
            $data = $this->upload->data();
            $filePath=$folderPath.$data['file_name'];
     
	    $folderPath = $config['upload_path'] = 'upload/';
            $config['allowed_types'] = 'gif|jpg|png|pdf';     
            $this->load->library('upload', $config);
            $this->upload->do_upload('profile_pic');
            $data = $this->upload->data();
            $profilePic=$folderPath.$data['file_name'];
            
	    $primary=$this->input->post('primary_other_skils');
	    $secondary=$this->input->post('secondary_other_skils');
	    //echo $test;exit;

	    if($primary==null)
	    {
		$primary="NULL";
	    }
	    else {
		$primary=$this->input->post('primary_other_skils');
	    }
	    
	    if($secondary==null)
	    {
	       $secondary='NULL';
	    }
	    else {
		$secondary=$this->input->post('secondary_other_skils');
	    }
	    if($this->input->post('SecondarySkills')=="")
		    {
                        $data= array(
                           'candidate_name'=>$this->input->post('candidate_name'),
                           'mobile_number'=>$this->input->post('mobile_number'),
                           'mail_id'=>$this->input->post('mail_id'),
                           'skills'=>implode(",",$this->input->post('skills')),
                           'primary_other_skils'=>$primary,
                           'total_exp_year'=>$this->input->post('total_exp_year'),
                           'total_exp_month'=>$this->input->post('total_exp_month'),
                           'relevant_exp'=>$this->input->post('relevant_exp'),
                           'notice_period'=>$this->input->post('notice_period'),
                           'current_ctc'=>$this->input->post('current_ctc'),
                           'expected_ctc'=>$this->input->post('expected_ctc'),
                           'day'=>$this->input->post('day'),
                           'month'=>$this->input->post('month'),
                           'year'=>$this->input->post('year'),
                           'pan_card_no'=>$this->input->post('pan_card_no'),
                           'pan_card_attach'=>$filePath,
                           'language_known'=>implode(",",$this->input->post('language_known')),
                           'current_location'=>$this->input->post('current_location'),
                           'preferred_location'=>$this->input->post('preferred_location'),
                           'interview_timing'=>$this->input->post('interview_timing'),
                           'educational_gap_year'=>$this->input->post('educational_gap_year'),
                           'career_gap_year'=>$this->input->post('career_gap_year'),
                           'team_size_name'=>$this->input->post('team_size_name'),
                           'team_contact_no'=>$this->input->post('team_contact_no'),
                           'profile_pic'=>$profilePic
                        );
                                   
                    }
                    else
                        {
                            $data= array(
                                'candidate_name'=>$this->input->post('candidate_name'),
                                'mobile_number'=>$this->input->post('mobile_number'),
                                'mail_id'=>$this->input->post('mail_id'),
                                'skills'=>implode(",",$this->input->post('skills')),
                                'primary_other_skils'=>$primary,
                                'SecondarySkills'=>implode(",",$this->input->post('SecondarySkills')),
                                'secondary_other_skils'=>$secondary,
                                'total_exp_year'=>$this->input->post('total_exp_year'),
                                'total_exp_month'=>$this->input->post('total_exp_month'),
                                'relevant_exp'=>$this->input->post('relevant_exp'),
                                'notice_period'=>$this->input->post('notice_period'),
                                'current_ctc'=>$this->input->post('current_ctc'),
                                'expected_ctc'=>$this->input->post('expected_ctc'),
                                'day'=>$this->input->post('day'),
                                'month'=>$this->input->post('month'),
                                'year'=>$this->input->post('year'),
                                'pan_card_no'=>$this->input->post('pan_card_no'),
                                'pan_card_attach'=>$filePath,
                                'language_known'=>implode(",",$this->input->post('language_known')),
                                'current_location'=>$this->input->post('current_location'),
                                'preferred_location'=>$this->input->post('preferred_location'),
                                'interview_timing'=>$this->input->post('interview_timing'),
                                'educational_gap_year'=>$this->input->post('educational_gap_year'),
                                'career_gap_year'=>$this->input->post('career_gap_year'),
                                'team_size_name'=>$this->input->post('team_size_name'),
                                'team_contact_no'=>$this->input->post('team_contact_no'),
                                'profile_pic'=>$profilePic
                             );
                        }
	    
//            $data= array(
//                'candidate_name'=>$this->input->post('candidate_name'),
//                'mobile_number'=>$this->input->post('mobile_number'),
//                'mail_id'=>$this->input->post('mail_id'),
//                'skills'=>implode(",",$this->input->post('skills')),
//                'total_exp_year'=>$this->input->post('total_exp_year'),
//		'total_exp_month'=>$this->input->post('total_exp_month'),
//                'relevant_exp'=>$this->input->post('relevant_exp'),
//                'notice_period'=>$this->input->post('notice_period'),
//                'current_ctc'=>$this->input->post('current_ctc'),
//                'expected_ctc'=>$this->input->post('expected_ctc'),
//                'day'=>$this->input->post('day'),
//                'month'=>$this->input->post('month'),
//                'year'=>$this->input->post('year'),
//                'pan_card_no'=>$this->input->post('pan_card_no'),
//                'pan_card_attach'=>$filePath,
//                'language_known'=>implode(",",$this->input->post('language_known')),
//                'current_location'=>$this->input->post('current_location'),
//                'preferred_location'=>$this->input->post('preferred_location'),
//                'interview_timing'=>$this->input->post('interview_timing'),
//                'educational_gap_year'=>$this->input->post('educational_gap_year'),
//                'career_gap_year'=>$this->input->post('career_gap_year'),
//                'team_size_name'=>$this->input->post('team_size_name'),
//                'team_contact_no'=>$this->input->post('team_contact_no'),
//		'profile_pic'=>$profilePic
//            );
            $select = $this->db->insert('emp_candidate_details',$data);
            $getHeadId=$this->db->insert_id($select);
            
            $clientCnt = count($this->input->post('client_comp'));
            for($i=0; $i<$clientCnt; $i++)
            {
                if($_POST['client_comp'][$i]!=''){
                    $data= array(
                        'head_id'=>$getHeadId,
                        'client_comp'=>$_POST['client_comp'][$i],
                        'payroll_comp'=>$_POST['payroll_comp'][$i],
                        'designation'=>$_POST['designation'][$i],
                        'emp_duration_from'=>$_POST['emp_duration_from'][$i],
                        'emp_duration_to'=>$_POST['emp_duration_to'][$i],
                        'location'=>$_POST['location'][$i],
                    );
                    $this->db->insert('employement_details',$data);                    
                }
            }
            
            $degreeCnt = count($this->input->post('degree'));
            for($j=0; $j<$degreeCnt; $j++)
            {
                if($_POST['degree'][$j]!=''){
                    $data= array(
                        'head_id'=>$getHeadId,
                        'degree'=>$_POST['degree'][$j],
                        'specialisation'=>$_POST['specialisation'][$j],
                        'edu_duration_from'=>$_POST['edu_duration_from'][$j],
                        'edu_duration_to'=>$_POST['edu_duration_to'][$j],
                        'university'=>$_POST['university'][$j],
                        'percentage'=>$_POST['percentage'][$j],
                    );
                    $this->db->insert('educational_details',$data);                                
                }
            }
           
        }
    
    

    function getCandidateDetails($id){
	$sql="SELECT * FROM emp_candidate_details where id='$id'";
        return $this->db->query($sql, $return_object = TRUE)->result_array();
    }
    
    function getEmployeeDetails($id){
	$sql="SELECT * FROM employement_details where head_id='$id'";
        return $this->db->query($sql, $return_object = TRUE)->result_array();
    }
    function getEducationalDetails($id){
	$sql="SELECT * FROM educational_details where head_id='$id'";
        return $this->db->query($sql, $return_object = TRUE)->result_array();
    }
    
	
    function employeeEdit($id){
	    $folderPath = $config['upload_path'] = 'upload/';
            $config['allowed_types'] = 'gif|jpg|png|pdf';
                
            $this->load->library('upload', $config);
            $this->upload->do_upload('pan_card_attach');
            $data = $this->upload->data();
            $filePath=$folderPath.$data['file_name'];
            
              if($_FILES['pan_card_attach']['name']=="")
		{
			$filePath=$this->input->post('oldimage');
		}
	$data = array(
		
		"candidate_name"=>$this->input->post("candidate_name"),
		"mobile_number"=>$this->input->post("mobile_number"),
		
		"mail_id"=>$this->input->post("mail_id"),
		"skills"=>implode(",",$this->input->post('skills')),
		"total_exp_year"=>$this->input->post("total_exp_year"),
		"total_exp_month"=>$this->input->post("total_exp_month"),
		"relevant_exp"=>$this->input->post("relevant_exp"),
		"notice_period"=>$this->input->post("notice_period"),
		"current_ctc"=>$this->input->post("current_ctc"),
		"expected_ctc"=>$this->input->post("expected_ctc"),
		
		"day"=>$this->input->post("day"),
		"month"=>$this->input->post("month"),
		"year"=>$this->input->post("year"),
		"pan_card_no"=>$this->input->post("pan_card_no"),
		"pan_card_attach"=>$filePath,
		"language_known"=>implode(",",$this->input->post('language_known')),
		"current_location"=>$this->input->post("current_location"),
		"preferred_location"=>$this->input->post("preferred_location"),
		
		"interview_timing"=>$this->input->post("interview_timing"),
		"educational_gap_year"=>$this->input->post("educational_gap_year"),
		"career_gap_year"=>$this->input->post("career_gap_year"),
		"team_size_name"=>$this->input->post("team_size_name"),
		"team_contact_no"=>$this->input->post("team_contact_no"),
		
		
		
	       );
	    $this->db->where("id",$id);
	    $this->db->update("emp_candidate_details",$data);
		    
		    
	    $clientCnt = count($this->input->post('client_comp'));
	    //print_r($clientCnt);exit;
            for($i=0; $i<$clientCnt; $i++)
            {
                if($_POST['Line_Status'][$i]=='addNew'){
		    $this->addEmpoyeeLines($i);
		}else{
		    $this->updateEmpoyeeLines($i);
		}
            }/*exit;*/
	    
	    //exit;
	    
	    $degreeCnt = count($this->input->post('degree'));
            for($j=0; $j<$degreeCnt; $j++)
            {
                if($_POST['degree_Status'][$j]=='addNewDegree'){
		    $this->addEducationLines($j);
		}else{
		    $this->updateEducationLines($j);
                }
            }/*exit;*/
           
    }
    
    function updateEmpoyeeLines($i){
	$data= array(
	    'client_comp'=>$_POST['client_comp'][$i],
	    'payroll_comp'=>$_POST['payroll_comp'][$i],
	    'designation'=>$_POST['designation'][$i],
	    'emp_duration_from'=>$_POST['emp_duration_from'][$i],
	    'emp_duration_to'=>$_POST['emp_duration_to'][$i],
	    'location'=>$_POST['location'][$i],
	);
	$this->db->where('id',$_POST['line_id'][$i]);
	$result = $this->db->update('employement_details',$data);
    }
    
    function addEmpoyeeLines($i){
	$data= array(
	    'head_id'=>$_POST['headId'],
	    'client_comp'=>$_POST['client_comp'][$i],
	    'payroll_comp'=>$_POST['payroll_comp'][$i],
	    'designation'=>$_POST['designation'][$i],
	    'emp_duration_from'=>$_POST['emp_duration_from'][$i],
	    'emp_duration_to'=>$_POST['emp_duration_to'][$i],
	    'location'=>$_POST['location'][$i],
	);
	$this->db->insert('employement_details',$data);  
    }
    
    function addEducationLines($j){
	$data= array(
	    'head_id'=>$_POST['headId'],
	    'degree'=>$_POST['degree'][$j],
	    'specialisation'=>$_POST['specialisation'][$j],
	    'edu_duration_from'=>$_POST['edu_duration_from'][$j],
	    'edu_duration_to'=>$_POST['edu_duration_to'][$j],
	    'university'=>$_POST['university'][$j],
	    'percentage'=>$_POST['percentage'][$j],
	);
	$this->db->insert('educational_details',$data);
    }
    
    function updateEducationLines($j){
	$data= array(
	    'degree'=>$_POST['degree'][$j],
	    'specialisation'=>$_POST['specialisation'][$j],
	    'edu_duration_from'=>$_POST['edu_duration_from'][$j],
	    'edu_duration_to'=>$_POST['edu_duration_to'][$j],
	    'university'=>$_POST['university'][$j],
	    'percentage'=>$_POST['percentage'][$j],
	);
	$this->db->where("id",$_POST['degree_id'][$j]);
	$result= $this->db->update('educational_details',$data);  
    }

    function employeeDelete($id){
    $this->db->where("id",$id);
    $this->db->delete("emp_candidate_details");
   } 
   
   function employementDelete($id)
    {
	$this->db->where("id",$id);
	$this->db->delete("employement_details");
    }
    
    function educationDelete($id)
    {
	$this->db->where("id",$id);
	$this->db->delete("educational_details");
    }
    
    function applicantDetails()
    {
	
	$sql="SELECT * FROM applicant order by id desc";
     	return $this->db->query($sql, $return_object = TRUE)->result_array();
    }
    
     function applicantAdd(){
	   
	$data = array(
		'name'=>$this->input->post('name'),
                'mobile_number'=>$this->input->post('mobile_number'),
                'email'=>$this->input->post('email'),
                'skill'=>implode(",",$this->input->post('skill')),
	       );
		  
		    $this->db->insert("applicant",$data);
		    //redirect("admin/applicant");   
	
    }
    
    function applicantEdit($id){
	$data = array(
		'name'=>$this->input->post('name'),
                'mobile_number'=>$this->input->post('mobile_number'),
                'email'=>$this->input->post('email'),
                'skill'=>implode(",",$this->input->post('skill')),
	       );
	$this->db->where("id",$id);
	$this->db->update("applicant",$data);
	
    }
     function getapplicantDetails($id){
	 $sql="SELECT * FROM applicant where id='$id'";
	 //print_r($sql);
	 //exit;
            return $this->db->query($sql, $return_object = TRUE)->result_array();
    }
    
    function applicantDelete($id)
    {
	$this->db->where("id",$id);
	$this->db->delete("applicant");
	
    }
    
    function registerUser(){
	$sql="SELECT * FROM register_users order by id desc";
     	return $this->db->query($sql, $return_object = TRUE)->result_array();
    }
    
    function candidateCount(){
	$vendorId=$this->session->userdata('vendor_code');
	$sql="SELECT COUNT(vendor_code) vendor_code FROM vendor where vendor_code='$vendorId'";
	return $this->db->query($sql, $return_object = TRUE)->result_array();
    }
    
    function vendorCount(){
	$sql="SELECT COUNT(*) as vendorCount FROM vendor";
	 return $this->db->query($sql, $return_object = TRUE)->result_array();
	
    }
    function employeesCount(){
	$sql="SELECT COUNT(*) as employeesCount FROM emp_candidate_details";
	 return $this->db->query($sql, $return_object = TRUE)->result_array();
	
    }
    
    
    function sendCredentialToUser(){
	$userEmail = $_POST['userEmail'];
	$userName = $_POST['userName'];
	$statusYN = $_POST['statusYN'];
	$this->db->where('email', $userEmail);
	$data = array(
	    'status' => $statusYN
	);
	$this->db->update('vendor', $data);
	$this->db->affected_rows();
	if($statusYN=="Y")
	    $this->emailSending($userEmail,$userName,$statusYN);
	
    }
    
    function emailSending($userEmail,$userName,$statusYN)
    {
	$body ="<html>
		    <head>
			<title>Welcome to Talent Capital</title>
		    </head>
		    <body>
			<h4>Dear $userName,</h4>
			<p>You are successfully activated as hiring partner in TalentCapital Portal, Please click below link to manage your applicants</p>
			<p> <a href='".base_url()."vendorlogin/index/hiringPartner' >Click Here</a> </p>
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
	$this->email->to($userEmail);// change it to yours
	$this->email->subject('Talent Capital India - activation Mail');
	$this->email->message($body);
	
if($this->email->send()){
	    if($statusYN=="Y"){
		$this->session->set_flashdata('status', 'Hiring Partner has been approved successfully');
	    }
	    else{
		$this->session->set_flashdata('status', 'Hiring Partner has been Rejected successfully');
	    }
	    
	}else{
	    $this->session->set_flashdata('status', 'Hiring Partner has not approved');	
	}
    }

    //Vendor Login functionality starts
    
    function checkVendorLogin(){
	$user_id = $this->input->post('username');
	$password = $this->input->post('password');
	$sql="SELECT * FROM register_users where username='$user_id' AND password='$password'";
	$query = $this->db->query($sql, $return_object = TRUE);
	if($query->num_rows > 0){
	    return $query->result_array();
	}
	else
	{
	    return false;
	}
    }
    
    function vendorloginEdit($id){
	$sql="SELECT * FROM vendor where id='$id'";
	return $this->db->query($sql)->result_array();
    }
    
    function mailToCandiate(){
	$vendorCode = $this->input->post('vendor_code');
	$email = $this->input->post('email');
	$this->mailToCandidate($email,$vendorCode);
    }
    
    function mailToCandidate($email,$vendorCode)
    {
	$body ="<html>
		    <head>
			<title>Welcome to Talent Capital</title>
		    </head>
		    <body>
			<h1>Dear Candidate</h1>
			<p>Please register with talent capital with below link.</p>
			<p>".base_url()."talentcapitalctr/candidateLogin/".$vendorCode."</p>
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
	    redirect('admin/vendorAddUser');
	}else{
	    $this->session->set_flashdata('status', 'Email has not sent to User');
	    redirect('admin/vendorAddUser');
	}
    }    
    //Vendor Login functionality Ends
    
    
}