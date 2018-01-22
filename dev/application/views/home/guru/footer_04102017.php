 <div class="modal fade bs-example-modal-lg" id="incoming_call" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                       
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3>Video call!!</h3>
                  </div>
                    <div class="modal-body">
   
   <div class="frame">
       <div class="card-box vdscreen" style="min-height: 450px;">
                        
                    <video autoplay id="incoming" style="display: inline;width:100%;"></video>
                    <div class="opponentscreen" style="margin-bottom: 10px;">
                                    <!--Add outgoing video here-->
                          <video muted autoplay id="outgoing" style="display: inline;height:200px;"></video>
                    </div>
                                
                                
    </div>
    
       <input type="hidden" id="callUserName" placeholder="Username (alice)" value="<?php echo $this->uri->segment(3); ?>"><br>
       <div id="callLog">
       </div>
       <div class="error">
       </div>
        <div class="vcontrols" style="margin-top: 25px;">
            <div id="call">
            <form id="newCall">
            <ul>
                <li class="btn btn-primary"><button><img src="<?php echo base_url(); ?>assets/images/micmute-icon.png"></button></li>
<!--                <li class="btn btn-danger"><button><img src="<?php echo base_url(); ?>assets/images/micmute-icon.png"></button></li>-->
                <li class="btn btn-primary"><button id="call"><img src="<?php echo base_url(); ?>assets/images/videomute-icon.png"></button></li>
<!--                <li class="btn btn-danger"><button><img src="<?php echo base_url(); ?>assets/images/videomute-icon.png"></button></li>-->
                <li class="btn btn-danger"><button id="hangup"><img src="<?php echo base_url(); ?>assets/images/call-drop-icon.png"></button></li>
             </ul>
             <audio id="ringback" src='<?php echo base_url();?>assets/css/style/ringback.wav' loop></audio>
             <audio id="ringtone" src='<?php echo base_url();?>assets/css/style/phone_ring.wav' loop></audio>
             </form>
            </div>   
        </div>
  </div>
                    </div>
</div>
              </div>
    </div>

<div class="modal fade" id="incoming_alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                       
                  <div class="modal-header">
                    <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                    <div class="success-signup" id="signup_applicant_modal">
					 <div class="cong_icon"><i class="fa fa-check"></i></div>
                     <h2>Incoming Call!</h2>
					 <div id="call_from"><h2></h2></div>
					</div>
                  </div>
                  <form id="newCall">
                  <div class="modal-body text-center">
                      <button type="button" id="answer" class="btn btn-success" >Answer</button>
		              <button type="button" id="hangout" class="btn btn-default" data-dismiss="modal">Reject</button>
                  </div>
                 
                  </form>
                </div>
              </div>
</div>


<div class="modal fade bs-example-modal-lg" id="calling" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3>Connecting Call!!</h3>
                  </div>
                    <div class="modal-body">Calling..........</div>
                </div>
              </div>
    </div>

<div class="modal fade bs-example-modal-lg" id="rating_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3>Rate Us!</h3>
                  </div>
                    <div class="modal-body">
                        <div class="rating text-center" data-calc="4.7" style="margin-bottom: 30px;">
                            <a href="javascript:void(0)" class="star" id="" data-seq="1"><i class="fa fa-star"></i></a>
                            <a href="javascript:void(0)" class="star" id="" data-seq="2"><i class="fa fa-star"></i></a>
                            <a href="javascript:void(0)" class="star" id="" data-seq="3"><i class="fa fa-star"></i></a>
                            <a href="javascript:void(0)" class="star" id="" data-seq="4"><i class="fa fa-star"></i></a>
                            <a href="javascript:void(0)" class="star" id="" data-seq="5"><i class="fa fa-star"></i></a>
                        </div>
                        <div class="text-center">
                        <input type="hidden" name="rating" id="rating_value" value="" />
                        <button type="button" id="send_rating" class="btn btn-success text-center" >Submit</button>
                        </div>
                    </div>
                </div>
              </div>
    </div>

</div>
    </section>
    
    <footer>
            <div class="container">
            <div class="thoughts">
            Thoughts on our application?<br>
            <a href="#">Let us know!</a>
            </div>
        	©2017 School Guru All rights reserved. Privacy Policy and Terms & Conditions
        </div>    
    </footer>
    

<script> var base_url = '<?php echo base_url(); ?>'; </script>
<script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/" ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src='<?php echo base_url()."assets/" ?>js/moment.js'></script>
<?php if($this->uri->segment(1) == 'dashboard' || $this->uri->segment(2) =='dashboard#_=_' || $this->uri->segment(2) == 'dashboard'){ ?> 
<script src="<?php echo base_url()."assets/" ?>js/dist/cropper.min.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/dist/main.js"></script>
<?php } ?>
<?php if($this->uri->segment(2) == 'schedule_guru'){ ?>

<?php } ?>
<?php if($this->uri->segment(1) == 'calendar'){ ?>
<script src="<?php echo base_url()."assets/" ?>js/jquery-ui.min.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/fullcalendar.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/" ?>js/jquery.fullcalendar.js"></script>
<?php } ?>

<?php if($this->uri->segment(1) == 'mentors' || $this->uri->segment(1) == 'applicants'){ ?>
<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/jshashtable-2.1_src.js"></script>
<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/jquery.numberformatter-1.2.3.js"></script>
<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/tmpl.js"></script>
<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/jquery.dependClass-0.1.js"></script>
<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/draggable-0.1.js"></script>
<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/jquery.slider.js"></script>
<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/theia-sticky-sidebar.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url()."assets/" ?>js/select2.min.js"></script>-->
<script>
    
if( $("#price-input").length > 0) {
        $("#price-input").each(function() {
                var vSLider = $(this).slider({
                        from: 10,
                        to: 500,
                        smooth: true, 
                        step: 1,
                        dimension: '&nbsp;$',
                }); 
        });
}
</script>
<script>
if( $("#age-input").length > 0) {
        $("#age-input").each(function() {
                var vSLider = $(this).slider({
                        from: 21,
                        to: 50,
                        smooth: true, 
                        step: 1,
                        dimension: '&nbsp;',
                }); 
        });
}
$('.leftsidebar').theiaStickySidebar({
        additionalMarginTop: 30
});

</script>

<?php } ?>
<script src="<?php echo base_url()."assets/" ?>js/dist/bootstrapValidator.js" type="text/javascript"></script>
<?php if($this->session->userdata('role') == 1){ ?>
<script src="<?php echo base_url()."assets/" ?>js/guru.js" type="text/javascript"></script>
<?php } ?>
<?php if($this->session->userdata('role') == 0){ ?>
<script src="<?php echo base_url()."assets/" ?>js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/" ?>js/applicant.js" type="text/javascript"></script>
<script> 
$(function () {
                $('#choosedate').datetimepicker({
                    useCurrent: false,
                    format: 'YYYY-MM-DD',
		    minDate:new Date()
                }).on('dp.change', function(e) {
                    // Revalidate the date field
                    $(this).closest('form').bootstrapValidator('revalidateField', $(this).prop('name'));
                });
                $('#choosedate1').datetimepicker({
                    useCurrent: false,
                    format: 'HH:mm'
                }).on('dp.change', function(e) {
                    // Revalidate the date field
                    $(this).closest('form').bootstrapValidator('revalidateField', $(this).prop('name'));
                });
        });
</script>
<?php } ?>
<?php if($this->input->get('token') != ''){ ?>
<script>
setTimeout(function(){
    window.location=base_url+'mentors';
},7000);
</script>
<?php } ?>
<script src="<?php echo base_url()."assets/" ?>js/bootstrap-notify.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/sinch/VIDEOsample.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/sinch/messages.js"></script>
<script type="text/javascript">
$('.radioBtn a').on('click', function(e){
    var sel = $(this).data('title');
    var append_id = $(this).data('value');
    $('#'+append_id).val(sel);
    //$("'#"+$(this).data('value')+"'").val(sel);
    if(sel==='N'){
    $(this).removeClass('notActive').addClass('active');    
    $(this).siblings('.Visible').removeClass('active').addClass('notActive ');
    }
    if(sel==='Y')
    {
    $(this).removeClass('notActive').addClass('active');    
    $(this).siblings('.Invisible').removeClass('active').addClass('notActive ');
    }
  
});
 function redirectCall()
 {
	 setTimeout(function(){
		 window.location=base_url+'user/meetings';
	 },2000);
 }
</script>
 
</body>

</html>
