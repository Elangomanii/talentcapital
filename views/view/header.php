<?php
$session_username = $this->session->userdata('username');
?>
<style>
    
/*social icon styles*/
 .img{
     background-color:#dd4b39;
     border-radius:15%;
     padding:13px;
    }
    .imgfb{
     background-color:#3b5998;
     border-radius:15%;
     padding:13px;
    }
    .imgfb{
     background-color:#3b5998;
     border-radius:15%;
     padding:13px;
    }
    .imglink{
     background-color:#007bb6;
     border-radius:15%;
     padding:13px;
    }
    .imgpin{
     background-color:#cb2027;
     border-radius:15%;
     padding:13px;
    }
    .imgtwit{
     background-color:#00aced;
     border-radius:15%;
     padding:13px;
    }
    .imgemail{
     background-color:#aaa;
     border-radius:15%;
     padding:13px;
    }
    .imgmore{
     background-color:#0039a1;
     border-radius:15%;
     padding:13px;
    }
/*social icon styles*/
</style>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Talent Captial India | Leading Web Services</title>
        <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="icon" href="images/favicon.ico" type="image/gif"> 
                <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
                    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/custom.css">
                        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/chosen.css">
                        <link rel="stylesheet" href="<?php echo base_url();?>assets/browse-button/filecss.css">
<!--                            <link href="<?php echo base_url();?>assets/css/datepicker.css" rel="stylesheet" />
                            <link href="<?php echo base_url();?>assets/css/datepicker3.css" rel="stylesheet" />
                            <link href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.css" rel="stylesheet" />
                            <link href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
                            <link href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker-standalone.css" rel="stylesheet" />-->
                            <link href="<?php echo base_url(); ?>assets/bootstrap-validation/css/bootstrapValidator.css" rel="stylesheet" />
                            <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
                             <link rel="stylesheet" href="<?php echo base_url();?>assets/css/social.css">
                            
                            <link href="<?php echo base_url(); ?>assets/bootstrap-datetimepicker2/css/bootstrap-datetimepicker.css" rel="stylesheet" />
                            <link href="<?php echo base_url(); ?>assets/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
                            <link href="<?php echo base_url(); ?>assets/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" />                            
                           
                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
                            <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
                            <script src="<?php echo base_url();?>assets/browse-button/filejs.js"></script>
                            <script src="<?php echo base_url();?>assets/js/chosen.jquery.js" type="text/javascript"></script>
			    <script src="<?php echo base_url();?>assets/js/moment.js" type="text/javascript"></script>
<!--                            
                            <script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
                            <script src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
                            <script src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>-->
                            <script src="<?php echo base_url(); ?>assets/bootstrap-validation/js/bootstrapValidator.js"></script>
                            
		    <script src="<?php echo base_url(); ?>assets/bootstrap-datetimepicker2/js/moment-with-locales.js"></script>
		    <script src="<?php echo base_url(); ?>assets/bootstrap-datetimepicker2/js/bootstrap-datetimepicker.min.js"></script>                            
    </head>
    <body>
	<!-- FLOATING SIDEBAR-->
	<!--<div style="float:right;margin-top:5%;">
        <a href="#"><img src="<?php echo base_url(); ?>assets/images/googleplus-white-60.png" class="img" style="width:25px;height:25px;"/></a><br>
        <a href="#"><img src="<?php echo base_url(); ?>assets/images/linkedin-white-60.png" class="imglink" style="width:25px;height:25px;"/></a><br>
        <a href="#"><img src="<?php echo base_url(); ?>assets/images/facebook-white-60.png" class="imgfb" style="width:25px;height:25px;"/></a><br>
        <a href="#"><img src="<?php echo base_url(); ?>assets/images/pinterest-white-60.png" class="imgpin" style="width:25px;height:25px;"/></a><br>
        <a href="#"><img src="<?php echo base_url(); ?>assets/images/twitter-white-60.png" class="imgtwit" style="width:25px;height:25px;"/></a><br>
        <a href="#"><img src="<?php echo base_url(); ?>assets/images/email-white-60.png" class="imgemail" style="width:25px;height:25px;"/></a><br>
        <a href="#"><img src="<?php echo base_url(); ?>assets/images/sumomepro-white-60.png" class="imgmore" style="width:25px;height:25px;"/></a><br>
     
    </div>
	-->
	<!--FLOATING SIDEBAR-->
        <div class="">
            <nav class="navbar navbar-default navbar-fixed-top aws-nav-header">
                <div class="container menuPad">
                    <div class="navbar-header">
                        <button class="navbar-toggle collapsed" aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" type="button">
                            <span class="sr-only">Toggle navigation</span                          
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand sizeChange" href="index.php"><img  src="<?php echo base_url();?>assets/images/logo.png" style="width: 100px;" alt="logo"></a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse navbar-right">
                        <ul class="nav navbar-nav menuChnage">
                            <li>
                                <a href="#"><span style="color: #000; font-weight: normal!important; ">Home</span></a>
                            </li>
                            <li>
                                <a href="#"><span style="color: #000;font-weight: normal!important;">About</span></a>
                            </li>
                            <li>
                                <a href="#"><span style="color: #000; font-weight: normal!important;">Service</span></a>
                            </li>
<!--                            <li>
                                <a href="#"><span style="color: #000; font-weight: normal!important;">Welcome ,<?php echo $session_username;?> </span></a>
                            </li>-->
<!--                            <li class="dropdown">
                                <a class="dropdown-toggle" aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" href="#">
                                    <span style="color: #000; font-weight: normal!important;">Welcome  <?php echo $session_username;?> </span>
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php //echo base_url('talentcapitalctr/userLogout'); ?>"><span style="color: #000; font-weight: normal!important;">Logout</span></a>
                                    </li>
                                </ul>
                            </li>   -->                       
                        </ul>
                    </div>
                </div>
            </nav>
        </div>