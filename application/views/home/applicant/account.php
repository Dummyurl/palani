<div class="row" id="account">
  <div class="row titlerow">
    <div class="col-sm-6">
      <div class="account-detailsone">
        <div class="row">
          <div class="col-md-6 col-xs-6">
            <h2>Account</h2>
          </div>
          <div class="col-md-6 col-xs-6">
            <div class="edit-btn text-right">
              <a title="Edit Profile" class="btn btn-default" href="javascript:void(0);" onclick="edit_account()"><i aria-hidden="true" class="fa fa-pencil"></i> Edit Details</a>
            </div>
          </div>
        </div>
        <div class="profile-view-bottom">
          <div class="row">
            <div class="col-md-6">
              <h6>Bank Name</h6>
              <h5 id="bank_name" ><?php echo (!empty($account->bank_name))?$account->bank_name:''; ?></h5>
            </div>
            <div class="col-md-6">
              <h6>Account Type</h6>
              <h5 id="account_type" ><?php echo (!empty($account->account_type))?$account->account_type:''; ?></h5>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <h6>Routing (ABA)</h6>
              <h5 id="routing" ><?php echo (!empty($account->routing))?$account->routing:''; ?></h5>
            </div>
            <div class="col-md-6">
              <h6>Beneficiary Name</h6>
              <h5 id="beneficiary_name" ><?php echo (!empty($account->beneficiary_name))?$account->beneficiary_name:''; ?></h5>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <h6>Account Number</h6>
              <h5 id="account_no" ><?php echo (!empty($account->account_no))?$account->account_no:''; ?></h5>
            </div>
            <div class="col-md-6"></div>
          </div>
        </div>
      </div>
    </div>

    <?php
    $total_earned = (!empty($earned['earned_amount'])?$earned['earned_amount']:0);
    if($total_earned == '0.00' && !empty($account)){
      $class_name = 'btn btn-default';
      $modal = 'data-toggle="modal" data-target="#alert_modal" ';
    }else{
      $class_name = 'btn btn-primary request_btn';
      $modal = '';
    }  

    $requested_amt = (!empty($requested['request_amount'])?$requested['request_amount']:'0.00');
    if($requested_amt > 0){
      $total_earned = $total_earned - $requested_amt;
    }             

    $paid_amt = $paid['paid_amount'];
    $paid_amt = (!empty($paid['paid_amount'])?$paid['paid_amount']:'0.00');               
    $balance_amt = $total_earned - $paid_amt;


    ?>
    <div class="col-sm-6">
      <div class="account-details-one">
        <div class="row">
          <div class="col-sm-4 col-md-4 spa_earned"><span>$<?php echo $paid_amt; ?></span>Refunded</div>
          <div class="col-sm-4 col-md-4 spa_paid"><span>$<?php echo $requested_amt; ?></span>Requested</div>
          <div class="col-sm-4 col-md-4 spa_balance"><span>$<?php echo number_format($balance_amt,2); ?></span>Paid</div>
          <div class="col-md-12 spa_paynow">
            <div class="spa_paynow"><a class="<?php echo $class_name; ?>" <?php echo $modal ?>>Refund Request</a></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $('.request_btn').click(function(){
      $('#request_modal').modal('show');

    });
  </script>


  <div class="spa_conversations">		<div class="table-responsive">
   <table id="datatable" class="table table-striped" style="width:100% !important;">
    <thead>
     <tr>
      <th>Mentor Name</th>
      <th>Date</th>
      <th>From time</th>
      <th>To time</th>                
      <th>Amount</th>
      <th>Remarks</th>                
      <th>Action</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>
</div>	</div>
<!--Account Tab Ends Here-->

<!--Edit Account Details Modal-->
<div class="modal fade" id="edit_acc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3>Account Details</h3>
      </div>
      <div class="modal-body">
        <form class="form-vertical" id="accounts_form" >
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Bank Name</label>
                <input type="text" name="bank_name" class="form-control bank_name" value="<?php echo (!empty($account->bank_name))?$account->bank_name:''; ?>">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Account Type</label>
                <input type="text" name="account_type" class="form-control account_type" value="<?php echo (!empty($account->account_type))?$account->account_type:''; ?>">
                <span class="help-block"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Routing (ABA)</label>
                <input type="text" name="routing" class="form-control routing" value="<?php echo (!empty($account->routing))?$account->routing:''; ?>">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Beneficiary Name</label>
                <input type="text" name="beneficiary_name" class="form-control beneficiary_name" value="<?php echo (!empty($account->beneficiary_name))?$account->beneficiary_name:''; ?>">
                <span class="help-block"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Account Number</label>
                <input type="text" name="account_no" class="form-control account_no" value="<?php echo (!empty($account->account_no))?$account->account_no:''; ?>">
                <span class="help-block"></span>
              </div>
            </div>
          </div>

        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="save_acount()">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="request_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3>Refund Request</h3>
      </div>

      <div class="modal-body">
        <div class="alert alert-success success"></div>
        <div class="alert alert-danger error"></div>
        <div class="form-horzontal">
          <div class="col-md-12">
            <div class="form-group">
              <label class="control-label">Request Amount</label>
              <input type="text" name="request_amount" id="request_amount" class="form-control" maxlength="6"  onkeypress="return isNumber(event)">
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
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="request_amount()">Request</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->


<!-- Modal -->
<div class="modal fade" id="alert_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3>Alert !</h3>
      </div>

      <div class="modal-body">                
        <div class="alert alert-danger error">
          <i class="fa fa-warning"></i>You don't have sufficient balance!</div>                                
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">                
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->



  <style type="text/css">
  .error:empty{display: none;}
  .success:empty{display: none;}
</style>
<script type="text/javascript">

  function request_amount(){
    var request_amount = $('#request_amount').val();
    var description = $('#description').val();
    if(request_amount == 0 || request_amount < 0){
      $('.error').html('Enter valid amount!');
      setTimeout(function() {
        $('.error').html('');
      }, 3000);
      return false;
    }
    $.post('<?php echo base_url(); ?>user/request_amount',{
      request_amount:request_amount,
      description:description

    },function(res){            
      var obj = jQuery.parseJSON(res);

      if(obj.status == true){
        $('#request_amount').val('');  
        $('#description').val('');

        $('.success').html(obj.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
        setTimeout(function() {
          $('.success').html('');
          $('#request_modal').modal('hide');
          window.location.reload();
        }, 2000);


      }else{
        $('.error').html(obj.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
        setTimeout(function() {
          $('.error').html('');
        }, 3000);
      }

    });
  }

  function isNumber(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode
    return !(charCode > 31 && (charCode < 48 || charCode > 57));
  }

  function edit_account()
  {
    $('#edit_acc').modal('show');
  }

  function save_acount()
  {
    var bank_name = $('.bank_name').val();
    var account_type = $('.account_type').val();
    var routing = $('.routing').val();
    var beneficiary_name = $('.beneficiary_name').val();
    var account_no = $('.account_no').val();


    $.ajax({
      url : base_url+'user/save_acount',
      type: "POST",
      data: $('#accounts_form').serialize(),
      dataType: "JSON",
      success: function(data)
      {

            if(data.status == true) //if success close modal and reload ajax table
            {
              $('#edit_acc').modal('hide');
              $('#bank_name').text(bank_name);
              $('#account_type').text(account_type);
              $('#routing').text(routing);
              $('#beneficiary_name').text(beneficiary_name);
              $('#account_no').text(account_no);
            }
            else
            {
              for (var i = 0; i < data.inputerror.length; i++)
              {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                  }
                }

              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                alert('Error adding / update data');

              }
            });
  }
</script>
