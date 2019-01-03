<!-- <footer>
  <div class="container">
    <div class="thoughts">
      Thoughts on our application?<br>
      <a href="#">Let us know!</a>
    </div>
    ©2017 <a href="https://dreamguys.co.in/display/schoolguru/">School Guru</a>. All rights reserved. <a href="#">Privacy Policy</a> and <a href="#">Terms & Conditions</a>.
  </div>    
</footer> -->
<style type="text/css">
#subject_id_error,#course_error{color:red}
</style>


<div class="sidebar-overlay" data-reff="#sidebar"></div>
<script> var base_url = '<?php echo base_url(); ?>'; </script>
<script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src='<?php echo base_url()."assets/" ?>js/moment.js'></script>
<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/dataTables.bootstrap.min.js"></script><script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/app.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script type="text/javascript">
                  $('#dob').datetimepicker({
                   maxDate: moment().subtract(0, 'y'),
                   format: "DD/MM/YYYY",
                   useCurrent: false
                 });
</script>

<?php if($this->uri->segment(1) == 'settings' ){ ?> 

    <script type="text/javascript"> 

      
      var  table = $('#subject_table').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "pageLength": 5,

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('settings/get_all_subjects')?>",
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


       var  table1 = $('#course_table').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "pageLength": 5,

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('settings/get_all_courses')?>",
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
    

      $(document).ready(function(){
    get_subject('');
    $('input').keyup(function(){
      $('#subjects').parents().parents().removeClass('has-error')
      $('#subject_error').text('');
    });



    /*subject on click */
    $('#add_subject').click(function(){ 
      $('#subject_form')[0].reset();
    $('#title').html('Add Subject');      
    $('#subject_modal').modal('show');
    $('#btn_save').text('Add');     
      return false;
    });



    /*subject modal form save btn click */
    $('#subject_form').submit(function(e){
      e.preventDefault();
      var subject = $('#subjects').val();
      var subject_id = $('#subject_id').val();
      if(subject == ''){
        $('#subjects').parent().parent().addClass('has-error');
        $('#subject_error').text('Enter subject name');
        return false;
      }else{
        $.ajax({
          type: "POST",
          url: "<?php echo base_url();?>settings/add_subject",         
          data:{
            subject :subject,
            subject_id :subject_id
          },        
          beforeSend:function(){
            $("#subject option:gt(0)").remove(); 
          },
          success: function (res) {                   
            
            var obj = jQuery.parseJSON(res);
            if(obj.error){
              $('#subjects').parent().addClass('has-error');
              $('#subject_error').text(obj.error);
              return false;
            }else{
              $('#subject_modal').modal('hide');
              $('#subjects').parent().parent().removeClass('has-error');
              $('#subject_error').text('');
              get_subject(obj.subject_id);
              $('.alert-success').html('Subject saved sucessfully!');
              setTimeout(function() {
              $('.alert-success').html('');
            }, 2000);       
              reload_table();                                 
              
            }

          //;

        }
      }); 
        return false;
      }
      
    });



      $('input').keyup(function(){
      $('.help-block').html('');          
      });
      $('select').change(function(){
      $('.help-block').html('');  
      });


    /*course form save btn click */
    $('#course_form').submit(function(e){
      e.preventDefault();
      var subject_id = $('#subject').val();
      var course = $('#course').val();
      var course_id = $('#course_id').val();
      if(subject_id == ''){
        // $('#subject').parents().addClass('has-error');
        $('#subject_id_error').text('Select subject name');
        return false;
      }

      if(course == ''){
        // $('#course').parents().addClass('has-error');
        $('#course_error').text('Enter coures');
        return false;
      }



      
        $.ajax({
          type: "POST",
          url: "<?php echo base_url();?>settings/add_course",         
          data:{
            subject_id :subject_id,
            course :course,
            course_id :course_id,
          },
          success: function (res) {                                           
            $('#course_form')[0].reset();
            $('.alert-success').html(res);
            setTimeout(function() {
              $('.alert-success').html('');
            }, 2000);      
            reload_tables();   

        }
      }); 
        return false;
      
      
    });

    function reset_form(){
      $('#subject_form').reset();
    }


  });


  function get_subject(subject_id){
    $('#subject_form')[0].reset();
    $.ajax({
      type: "GET",
      url: "<?php echo base_url();?>settings/get_subjects",         
      beforeSend :function(){
      //  $('#subject').find("option:eq(0)").html("Please wait..");
      },                         
      success: function (data) {          
       // $('#subject').find("option:eq(0)").html("Select subject");
        var obj=jQuery.parseJSON(data);
        $(obj).each(function(){
          var option = $('<option />');
          option.attr('value', this.value).text(this.label);           
          $('#subject').append(option);
        });  
        // $('#subject').append('<option value="add_new">Add New</option>');
        if(subject_id){
          $("#subject option[value='"+subject_id+"']").attr("selected", "selected");
        }
      }
    });



  }
  function edit_subject(subject_id){
    $.post('<?php echo base_url(); ?>settings/get_subject_by_id',
      {subject_id:subject_id},
      function(res){
        var obj = jQuery.parseJSON(res);      
    $('#subject_id').val(subject_id);
    $('#subjects').val(obj.subject);
    $('#title').html('Edit Subject');     
    $('#subject_modal').modal('show');
    $('#btn_save').text('Update');
    });
  }
    function delete_subject(subject_id){
      if(confirm('Are you sure to delete this subject?')){

      $.post('<?php echo base_url(); ?>settings/delete_subject',
      {subject_id:subject_id},
      function(res){
        reload_table(); 
        get_subject();
    });

      }
    
  }
  function edit_course(course_id){
    $.post('<?php echo base_url(); ?>settings/get_course_by_id',
      {course_id:course_id},
      function(res){
        var obj = jQuery.parseJSON(res);      
    $('#subject').val(obj.subject_id);
    $('#course').val(obj.course);
    $('#course_id').val(obj.course_id);               
    });
  }



    function delete_course(course_id){
      if(confirm('Are you sure to delete this course?')){

      $.post('<?php echo base_url(); ?>settings/delete_course',
      {course_id:course_id},
      function(res){
        reload_tables();         
    });

      }
    
  }

  function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax     
}  function reload_tables()
{
    table1.ajax.reload(null,false); //reload datatable ajax     
}
      </script>
  <?php } ?>

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


    
      <script src="<?php echo base_url()."assets/" ?>js/cropper.min.js"></script>
      <script src="<?php echo base_url()."assets/" ?>js/main.js"></script>
    



    <?php if($this->uri->segment(1) == 'mentor_list' && $this->uri->segment(2) == ''){ ?> 


      <script type="text/javascript">
 //datatables
 var  table = $('#datatable').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('mentor_list/get_gurus')?>",
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




    <?php if($this->uri->segment(2) == 'mentor_details'){ ?> 


      <script type="text/javascript">
 //datatables
 var  table = $('#datatable').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('mentor_list/get_gurus_payment')?>",
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

    <?php if($this->uri->segment(1) == 'mentee_list' && $this->uri->segment(2)==''){ ?> 


      <script type="text/javascript">
 //datatables
 var  table = $('#datatable').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('mentee_list/get_applicants')?>",
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

    <?php if($this->uri->segment(2) == 'mentee_details'){ ?> 


      <script type="text/javascript">
 //datatables
 var  table = $('#datatable').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('mentee_list/get_applicant_payment')?>",
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

    <?php if($this->uri->segment(1) == 'payments'){ ?>

      <script type="text/javascript">
            
 //datatables
 var  table = $('#payment_table').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": '<?php echo site_url('payments/payment_list')?>',
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


 function reload_payment_table()
{
    table.ajax.reload(null,false); //reload datatable ajax     
}

 function pay_amount(payment_id,amount){
  $('#request_modal').modal('show');
  $('#payment_id').val(payment_id);
  $('#request_amount').val('$'+amount+'.00');
 }

   function reject_amount(payment_id,amount){
  $('#reject_modal').modal('show');
  $('#payment_ids').val(payment_id);
  $('#request_amounts').val('$'+amount+'.00');
 }






 function pay_the_amount(){

  var payment_id = $('#payment_id').val();
  var description = $('#description').val();
  /*Open modal*/
      $.post('<?php echo base_url(); ?>payments/pay_amount',{
        payment_id:payment_id,
        description:description
      },function(res){  
        $('#payment_id').val('');
        $('#description').val('');
        $('#request_amount').val('');
        $('.success').html('Payment made successfully!');        
        setTimeout(function() {
          $('#request_modal').modal('hide');
        reload_payment_table();  
        $('.success').html('');
        }, 2000);        
      });
    
  }
   function reject_the_amount(){

  var payment_id = $('#payment_ids').val();
  var description = $('#descriptions').val();
  /*Open modal*/
      $.post('<?php echo base_url(); ?>payments/reject_amount',{
        payment_id:payment_id,
        description:description
      },function(res){  
        $('#payment_ids').val('');
        $('#descriptions').val('');
        $('#request_amounts').val('');
        $('.success').html('Request rejected successfully!');        
        setTimeout(function() {
          $('#reject_modal').modal('hide');
        reload_payment_table();  
        $('.success').html('');
        }, 2000);        
      });
    
  }
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
