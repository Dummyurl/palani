<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 3.6.0
    </div>
    <strong style="font-weight: 600;"><?php echo $settings->copyright; ?>&nbsp;
</footer>

</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="<?php echo base_url();?>blog_assets/admin/plugins/jQuery/jQuery-2.1.4.min.js"></script>

<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url();?>blog_assets/admin/plugins/jQueryUI/jquery-ui.min.js"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>

<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>blog_assets/bootstrap/js/bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="<?php echo base_url();?>blog_assets/admin/js/app.min.js"></script>

<!-- DataTables js -->
<script src="<?php echo base_url();?>blog_assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>blog_assets/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>

<!-- iCheck js -->
<script src="<?php echo base_url();?>blog_assets/admin/plugins/iCheck/icheck.min.js"></script>

<!-- Ckeditor js -->
<script src="<?php echo base_url();?>blog_assets/admin/plugins/ckeditor/ckeditor.js"></script>

<!-- Pace -->
<script src="<?php echo base_url();?>blog_assets/admin/plugins/pace/pace.min.js"></script>

<script src="<?php echo base_url();?>blog_assets/admin/plugins/tagsinput/bootstrap-tagsinput.min.js"></script>

<!-- Bootstrap Toggle js -->
<script src="<?php echo base_url();?>blog_assets/admin/js/bootstrap-toggle.min.js"></script>

<!-- Cookie js -->
<script src="<?php echo base_url(); ?>blog_assets/js/jquery.cookie.js"></script>

<!-- Custom js -->
<script src="<?php echo base_url();?>blog_assets/admin/js/custom.js"></script>

<!-- Ck editor -->
<script>
    CKEDITOR.replace('ckEditor', {
        language: 'en',
        filebrowserImageUploadUrl: "<?php echo base_url(); ?>admin_post/upload_ckimage_post?key=yfDnzj985hf7AdyfgjfH6ufhg",
    });
</script>

<script type="text/javascript">
    function isNumberKey(evt){
  var charCode = (evt.which) ? evt.which : evt.keyCode
  return !(charCode > 31 && (charCode < 48 || charCode > 57));
}

</script>

</body>
</html>

