<?php if($this->session->userdata('role') == 0): ?>

<div class="subnav">
<ul class="nav nav-tabs">
     <li><a href="<?php echo base_url();?>list-view">List View</a></li>
    <li class="active"><a href="<?php echo base_url();?>calendar">Calendar View</a></li>
</ul>
</div>            
<div class="row">
    <div class="col-lg-12">
        <div class="card-box11">
            <div class="row">
                <div class="col-md-12">
                    <div id="calendar"></div>
                </div> <!-- end col -->
            </div>  <!-- end row -->
        </div>

         <!-- BEGIN MODAL -->

        <div class="modal fade bs-example-modal-lg" id="event-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Edit Event</h4>
                    </div>
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php else: ?>

<?php $this->load->view('home/guru/calendar'); ?>

<?php endif; ?>