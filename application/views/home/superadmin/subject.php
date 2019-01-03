<style type="text/css">
	.alert:empty{display: none;}
</style>
<div class="container">
<div class="row">
	<h4>Settings </h4>
	<button type="button" class="btn btn-primary" id="add_subject">Add Subject</button>	
				<br><br>
	<div class="col-md-12">
		<div class="profile-right">
			<form id="course_form" method="post" novalidate>                				
						
			<div class="alert alert-success"></div>
				<div class="row superadmin-settings"> 
				
						<div class="col-lg-3">
							<div class="form-group">
								<label class="control-label">Subject Name<span>*</span></label>
								<select class="form-control" name="subject" id="subject">
									<option value="" >--Select Subject--</option>								
								</select>                        
								<span class="help-block" id="subject_id_error"></span>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<label class="control-label">Course Name<span>*</span></label>
								<input type="text" name="course" id="course" class="form-control">                   
								<span class="help-block" id="course_error"></span>
							</div>
						</div>
						<input type="hidden" name="course_id" id="course_id">
						<div class="col-lg-3" style="margin: 31px 0px 0px 0px;">													<button class="btn btn-primary">Save Courses</button>
							<button type="reset" class="btn btn-danger">Reset</button>						
						</div>
					
				</div>
				</form>
			</div>
		
	</div>
  </div>
</div>

<div class="clear-fix"></div><br>
<div class="container">
	<div class="row superadmin-settings">
		<div class="col-sm-6 ">
			<div class="">
				<h4>Subject Details</h4>
				<table class="table table-striped dataTable no-footer" id="subject_table" >
					<thead>
						<tr>
							<th>Sno</th>
							<th>Subject</th>
							<th>Action</th>
						</tr>
					</thead>			
				</table>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="">
			<h4>Course Details</h4>
			<div class="table-responsive">
				<table class="table table-striped dataTable no-footer" id="course_table">
					<thead>
						<tr>
							<th>Sno</th>
							<th>Subject</th>
							<th>Course</th>
							<th>Action</th>
						</tr>
					</thead>

				</table>
			</div>
		</div>
		</div>
	</div>
</div>





<!--Subject Modal -->
<div class="modal fade" id="subject_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 id="title"></h3>
			</div>
			<form id="subject_form" method="post" novalidate>      
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-9">
							<div class="form-group">
								<label class="control-label">Name<span>*</span></label>
								<input type="text" name="subject" class="form-control text" id="subjects">
								<span class="help-block" id="subject_error"></span>
							</div>
						</div>
					</div>
					<input type="hidden" name="hidden_id" id="subject_id">  

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" id="btn_save"></button>
					<button type="reset" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</form> 
		</div>
	</div>
</div>


<script type="text/javascript">
	 $('.text').keypress(function (e) {              
              var regex = new RegExp(/^[a-zA-Z._\b]+$/);
              var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
              if (regex.test(str)) {
                return true;
              }
              else {
                e.preventDefault();
                return false;
              }
            });
</script>

