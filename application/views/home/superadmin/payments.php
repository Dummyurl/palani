<div class="col-sm-12">
		<h4>Payment Details</h4>
    <div class="superadmin-settings table-responsive">
		<table class="table" id="payment_table">
			<thead>
				<tr>
          <th>Sno</th>          
								
					<th>Request Date</th>					
					<th>Amount</th>					
					<th>Resolved Date</th>					
          <th>User</th>   
					<th>Status</th>					
				</tr>
			</thead>

		</table>
	</div>
</div>



   <!-- Payment  Modal -->
        <div class="modal fade" id="request_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3>Payment Request</h3>
              </div>

              <div class="modal-body">
                <div class="alert alert-success success"></div>
                <div class="alert alert-danger error"></div>
                <div class="form-horzontal">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label">Requested Amount</label>
                      <input type="text" name="request_amount" id="request_amount" class="form-control" maxlength="6" id="request_amount" readonly>
                      <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Description (Optional)</label>
                      <textarea class="form-control" name="description" id="description"></textarea>
                      <span class="help-block"></span>
                    </div>
                  </div>
                </div>                  
              </div>
              <div class="clearfix"></div>
              <div class="modal-footer">.
              	 <input type="hidden" name="payment_id" id="payment_id">
                <button type="button" class="btn btn-primary" onclick="pay_the_amount()">Pay</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal -->

         <!-- Rejected  Modal -->
        <div class="modal fade" id="reject_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3>Reject Request</h3>
              </div>

              <div class="modal-body">
                <div class="alert alert-success success"></div>
                <div class="alert alert-danger error"></div>
                <div class="form-horzontal">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label">Requested Amount</label>
                      <input type="text" name="request_amounts" id="request_amounts" class="form-control" maxlength="6" id="request_amount" readonly>
                      <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Description (Optional)</label>
                      <textarea class="form-control" name="descriptions" id="descriptions"></textarea>
                      <span class="help-block"></span>
                    </div>
                  </div>
                </div>                  
              </div>
              <div class="clearfix"></div>
              <div class="modal-footer">.
              	 <input type="hidden" name="payment_ids" id="payment_ids">
                <button type="button" class="btn btn-primary" onclick="reject_the_amount()">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal -->

        <style type="text/css">
          .error:empty{display: none;}
          .success:empty{display: none;}
        </style>