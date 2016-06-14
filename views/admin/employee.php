<?php
$status = $this->session->flashdata('status');
?>
<div class="content" id="content">
			<!-- begin breadcrumb -->
			
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			
			<!-- end page-header -->
            <!-- end row -->
            <!-- begin row -->
            <div class="row">
                <!-- begin col-12 -->
                <div class="col-12 ui-sortable">
                    <!-- begin panel -->
                    <div data-sortable-id="form-stuff-5" class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a data-click="panel-expand" class="btn btn-xs btn-icon btn-circle btn-default" href="javascript:;"><i class="fa fa-expand"></i></a>
                                <a data-click="panel-reload" class="btn btn-xs btn-icon btn-circle btn-success" href="javascript:;"><i class="fa fa-repeat"></i></a>
                                <a data-click="panel-collapse" class="btn btn-xs btn-icon btn-circle btn-warning" href="javascript:;"><i class="fa fa-minus"></i></a>
                                <a data-click="panel-remove" class="btn btn-xs btn-icon btn-circle btn-danger" href="javascript:;"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Employee View</h4>
                        </div>
                        <div class="panel-body" id="form_validation">
                        <?php if($status)
			{?>
			    <div id="alert" class="alert alert-success outer"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a><?php echo $status; ?></div>
			    <?php
			} ?>
				<!--<p>
				   <a class="btn btn-primary btn-sm " href="<?php echo site_url('admin/employeeAdd')?>"><i class="fa fa-plus fa-1x"></i> <span class="f-s-14 f-w-500">Add Employee</span></a>
				 </p>-->
                            	<div class="table-responsive" style="border: none">
					<table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
					  <thead>
						<tr>
						    <th data-class="expand">Name</th>
						    <th data-hide="phone,tablet">Mobile Number</th>
						    <th data-hide="phone,tablet">Mail ID</th>
						    <th data-hide="phone,tablet">Skills</th>
						    <th data-hide="phone,tablet">Total Experience</th>
						    <th data-hide="phone,tablet">Location</th>
						    <th data-hide="phone,tablet">Referred by</th>
						    <th>Action</th>
						    
						</tr>
					    </thead>
					    <tbody>
						<?php if(count($employeeDetails) > 0)
							     { foreach($employeeDetails as $row) {  ?>
					       
						<tr>
						    <td style="cursor:pointer;" class="clickable-row" data-href='<?php echo site_url('admin/employeeEditView/'.$row['id'])?>'><u><?php echo $row['candidate_name']; ?></u></td>					    
						    <td ><?php echo $row['mobile_number']; ?></td>
						    <td ><?php echo $row['mail_id']; ?></td>
						    <td ><?php echo $row['skills']; ?></td>				    
						    <td><?php echo $row['total_exp_year']; ?></td>
						    <td><?php echo $row['current_location']; ?></td>
						    <td><?php if($row['vendor_code']=="0"){ echo "Direct"; }else{ echo $row['vendor_code']; } ?></td>
						    <td>
							<a href="<?php echo site_url('admin/employeeEdit/'.$row['id'])?>" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> </a>
						       <a  id="delete_box" href="<?php echo site_url('admin/employeeDelete/'.$row['id'])?>" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> </a>
						   <a  href="#" data-toggle="modal" data-target="#printPreview"  class="btn btn-primary btn-xs" onclick="printEmployeeDetails('<?php echo $row['id'];?>')"><i class="fa fa-file-pdf-o fa-2x"></i> </a>
						    </td>
						</tr>
					    <?php }}?>
					    </tbody>
					</table>
		    
				</div>
				<!--PDF STARTS-->
				<div class="modal fade" id="printPreview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				    <div class="modal-dialog modal-lg">
					<div class="modal-content">
					    <form  id="category-form" class="smart-form" >
						<div class="modal-header" style="border-bottom: 1px solid #e5e5e5; min-height: 16.4286px; padding: 15px;">   
						    <b><img alt="" data-id="login-cover-image" height="50px" width="100px" src="http://localhost/talentCapitalAdmin/assets/images/logo.png"></b>
						    <button aria-hidden="true" data-dismiss="modal" class="close" type="button onClick="onClickHandler(this)"><i class="fa  fa-times-circle "></i></button>
						    			
						</div>
						<div class="model-body">
						    <iframe class="responsiveiframe table-responsive" width="900px" id="previewiframe" height="1000px"></iframe>
						</div>
					    </form>
					    <input type="hidden" id="emailSystemId">
					</div>
				    </div>
				</div>
				
				
				
				<!--PDF ENDS-->

                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-6 -->
            </div>
            <!-- end row -->
		</div>
	<script>
	
	  $('#form_validation').on('click', '#delete_box', function(e) {
 e.preventDefault();

         var link = $(this).attr('href');
      bootbox.confirm("Are you sure you want to delete?", function(confirmed) {   
               if (confirmed) {
                     window.location.href = link;     
                }    
            });
 });
	</script>
	<script>
	//    $(document).ready(function() {
	//	    App.init();
	//	    TableManageTableTools.init();
	//    });
	    
	$(document).ready(function() {
	 setTimeout(function(){ $('#alert').remove();}, 5000);
	    $('#data-table').DataTable( {
		dom: 'Bfrtip',
		"ordering":false,
		buttons: [
		    //'copyHtml5',
		    'excelHtml5',
		    //'csvHtml5',
		    //'pdfHtml5'
		]
	    } );
	} );
	function printEmployeeDetails(systemId)
		
	{
	    var data = "admin/employeePrint/"+systemId;
	    var preview = "<?php echo site_url()?>"+data;
	    $('#previewiframe').attr('src',preview);
	    var dataURL = "admin/employeePrint/"+systemId;
	   
	   
	}
	    $(document).ready(function($) {
	    $(".clickable-row").click(function() {
	     window.document.location = $(this).data("href");
	    });
	});
		    
	    $(document).ready(function($) {
	    $(".clickable-row").click(function() {
	     window.document.location = $(this).data("href");
	    });
	});
	</script>