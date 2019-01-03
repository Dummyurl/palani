<div class="sidebar-overlay" data-reff="#sidebar"></div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/app.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/notify.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/sinch.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sweetalert2.js"></script>
<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';	
</script>
<?php 
$uri = $this->uri->segment(1);

if($uri == 'department-settings' || $uri == 'designation-settings' || $uri =='employees'){ ?>
	<!-- 	CSS   -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap.min.css">

	<!-- JS -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js"></script>

<?php } ?>		
<?php if($uri == 'employees'){ ?>
	<!-- Employees  -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>	
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/employees.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sinch.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/custom_sinch.js"></script>	
	<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
	<script type="text/javascript">
		$(".select2-option").select2();
	</script>
<?php } ?>		
<?php if($uri == 'company-settings'){ ?>
	<!-- Company Settings  -->
	<script src="<?php echo base_url(); ?>assets/js/company.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
	<script type="text/javascript">
		$(".select2-option").select2();
	</script>
<?php } ?>		
<?php  if($uri == 'localization-settings'){ ?>
	<!-- Localization Settings  -->
	<script src="<?php echo base_url(); ?>assets/js/localization.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
	<script type="text/javascript">
		$(".select2-option").select2();
	</script>
<?php } ?>		
<?php  if($uri == 'theme-settings'){ ?>
	<!-- Theme Settings  -->
	<script src="<?php echo base_url(); ?>assets/js/theme.js"></script>
<?php } ?>
<?php  if($uri == 'department-settings'){ ?>
	<!-- Department Settings  -->
	<script src="<?php echo base_url(); ?>assets/js/department.js"></script>
<?php } ?>	
<?php  if($uri == 'designation-settings'){ ?>
	<!-- Designation Settings  -->
	<script src="<?php echo base_url(); ?>assets/js/designation.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
	<script type="text/javascript">
		$(".select2-option").select2();
	</script>
<?php } ?>
<?php  if($uri == 'change-password'){ ?>
	<!-- Password Settings  -->
	<script src="<?php echo base_url(); ?>assets/js/password.js"></script>
<?php } ?>
</body>
</html>