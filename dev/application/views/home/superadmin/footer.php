<!-- <footer>
  <div class="container">
    <div class="thoughts">
      Thoughts on our application?<br>
      <a href="#">Let us know!</a>
    </div>
    ©2017 <a href="https://dreamguys.co.in/display/schoolguru/">School Guru</a>. All rights reserved. <a href="#">Privacy Policy</a> and <a href="#">Terms & Conditions</a>.
  </div>    
</footer> -->


<script> var base_url = '<?php echo base_url(); ?>'; </script>
<script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src='<?php echo base_url()."assets/" ?>js/moment.js'></script>
<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/dataTables.bootstrap.min.js"></script>

<?php if($this->uri->segment(1) == 'dashboard' || $this->uri->segment(2) =='dashboard#_=_' || $this->uri->segment(2) == 'dashboard'){ ?> 

<script type="text/javascript">
 //datatables
 var  table = $('#datatable').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('user/get_all_payments')?>",
          "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable            
          },
          ],

        });



</script>
<?php } ?>


<?php if($this->uri->segment(2) == 'profile_edit'){ ?> 
<script src="<?php echo base_url()."assets/" ?>js/dist/cropper.min.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/dist/main.js"></script>
<?php } ?> 



<?php if($this->uri->segment(1) == 'gurus' && $this->uri->segment(2) == ''){ ?> 


<script type="text/javascript">
 //datatables
 var  table = $('#datatable').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('gurus/get_gurus')?>",
          "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable            
          },
          ],

        });



</script>
<?php } ?>




<?php if($this->uri->segment(2) == 'guru_details'){ ?> 


<script type="text/javascript">
 //datatables
 var  table = $('#datatable').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('gurus/get_gurus_payment')?>",
          "type": "POST",
           "data": function ( data ) {
             data.user_id = $('#user_id').val();
            
            }
        },
       
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable            
          },
          ],

        });



</script>
<?php } ?>

<?php if($this->uri->segment(1) == 'applicant' && $this->uri->segment(2)==''){ ?> 


<script type="text/javascript">
 //datatables
 var  table = $('#datatable').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('applicant/get_applicants')?>",
          "type": "POST",
           "data": function ( data ) {
             data.user_id = $('#user_id').val();
            
            }
        },
       
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable            
          },
          ],

        });



</script>
<?php } ?>

<?php if($this->uri->segment(2) == 'applicant_details'){ ?> 


<script type="text/javascript">
 //datatables
 var  table = $('#datatable').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('applicant/get_applicant_payment')?>",
          "type": "POST",
           "data": function ( data ) {
             data.user_id = $('#user_id').val();
            
            }
        },
       
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable            
          },
          ],

        });



</script>
<?php } ?>

<?php if($this->uri->segment(1) == 'calendar'){ ?>

<!-- <script src="<?php echo base_url()."assets/" ?>seelct2/js/select2.min.js"></script> -->
<script type="text/javascript">
 
   $.ajax({
    type: "GET",
    url: "<?php echo base_url();?>user/get_all_users",        
    beforeSend :function(){
       $("#user_select option:gt(0)").remove(); 
       $('#user_select').find("option:eq(0)").html("Please wait..");
   },                         
   success: function (data) {
      /*get response as json */
      $('#user_select').find("option:eq(0)").html("Choose the user");
      var obj=jQuery.parseJSON(data);
      $(obj).each(function()
      {
         var option = $('<option />');
         option.attr('value', this.value).text(this.label);           
         $('#user_select').append(option);
     });  

    //  $('#user_select').select2();
      /*ends */

  }
});

</script>
<script src="<?php echo base_url()."assets/" ?>js/jquery-ui.min.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/fullcalendar.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/" ?>js/custom_calendar.js"></script>
<?php } ?>
</body>

</html>
