<body>

	
		
		<!-- begin #sidebar -->
		
		<!-- end #sidebar -->
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Dashboard<small>  details are here...</small></h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- begin col-3 -->
				<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-green">
						<div class="stats-icon"><i class="fa fa-desktop"></i></div>
						<div class="stats-info">
							<h4>TOTAL VENDORS</h4>
							
							<p><?php  echo $vendorCount[0]['vendorCount']; ?></p>	
						</div>
						<div class="stats-link">
							<a href="<?php echo site_url('admin/hiringPartner');?>">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>
				<!-- end col-3 -->
				<!-- begin col-3 -->
				<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-blue">
						<div class="stats-icon"><i class="fa fa-chain-broken"></i></div>
						<div class="stats-info">
							<h4>TOTAL EMPLOYEES</h4>
							<p><?php  echo $employeesCount[0]['employeesCount']; ?></p>	
						</div>
						<div class="stats-link">
							<a href="<?php echo site_url('admin/employee');?>">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>
				<!-- end col-3 -->
				<!-- begin col-3 -->
				<!--<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-purple">
						<div class="stats-icon"><i class="fa fa-users"></i></div>
						<div class="stats-info">
							<h4>TOTAL DIRECT APPLICANTS</h4>
							<p><?php  echo $applicantsCount[0]['applicantsCount']; ?></p>	
						</div>
						<div class="stats-link">
							<a href="<?php echo site_url('admin/applicant');?>">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>-->
				<!-- end col-3 -->
				<!-- begin col-3 -->
				<!--<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-red">
						<div class="stats-icon"><i class="fa fa-clock-o"></i></div>
						<div class="stats-info">
							<h4>AVG TIME ON SITE</h4>
							<p>00:12:23</p>	
						</div>
						<div class="stats-link">
							<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>-->
				<!-- end col-3 -->
			</div>
			<!-- end row -->
			<!-- begin row -->
			<!-- end row -->
		</div>
		<!-- end #content -->
	
		
		<!-- begin scroll to top btn -->
		
		<!-- end scroll to top btn -->
	
	<!-- end page container -->
	
	
	
</body>
