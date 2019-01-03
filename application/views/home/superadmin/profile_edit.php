  <link href="<?php echo base_url(); ?>assets/css/slim.min.css" rel="stylesheet">   
  <script src="<?php echo base_url(); ?>assets/js/slim.kickstart.min.js"></script>
<?php
$count = 0 ;
$total = 20 ;



$mentor_first_name = '';
$mentor_last_name = '';
$mentor_user_name = '';
$mentor_email = '';
$profile_img = '';
$social_profile_img = '';
$img1 = '';

if(!empty($result['first_name'])){$mentor_first_name = $result['first_name']; $count++ ; }
if(isset($result['last_name'])&&!empty($result['last_name'])){ $mentor_last_name = $result['last_name']; $count++ ; }
if(isset($result['email'])&&!empty($result['email'])){ $mentor_user_name = $result['email'];   $count++ ; }
if(isset($result['email'])&&!empty($result['email'])){   $mentor_email = $result['email']; $count++ ; }
if(isset($result['profile_img'])&&!empty($result['profile_img'])){ $profile_img = $result['profile_img']; }
if(isset($result['picture_url'])&&!empty($result['picture_url'])){ $social_profile_img = $result['picture_url']; }

if($social_profile_img != ''){ $img1 = $social_profile_img; }
if($profile_img != ''){
  $file_to_check = FCPATH . '/assets/images/' . $profile_img;
  if (file_exists($file_to_check)) {
    $img1 = base_url() . 'assets/images/'.$profile_img;
}
}
if(!empty($img1)){
  $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
  $count++;
}else{
  $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
}





$mobile_number = '';
if(isset($result['mobile_number'])&&!empty($result['mobile_number'])){
  $mobile_number = $result['mobile_number'];
  $count++ ;
}

$dob = '';
if(isset($result['dob'])&&!empty($result['dob'])){
  $dob = $result['dob'];
  $count++ ;
}


$mentor_gender = '';
if(isset($result['mentor_gender'])&&!empty($result['mentor_gender'])){
  $mentor_gender = $result['mentor_gender'];
  $count++ ;
}

$hourly_rate = '';
if(isset($result['hourly_rate'])&&!empty($result['hourly_rate']))
{
  $hourly_rate = $result['hourly_rate'];
  $count++ ;
}


$mentor_personal_message = '';
if(isset($result['mentor_personal_message'])&&!empty($result['mentor_personal_message']))
{
  $mentor_personal_message = $result['mentor_personal_message'];
  $count++ ;
}



$address_line1 = '';
if(isset($result['address_line1'])&&!empty($result['address_line1']))
{
  $address_line1 = $result['address_line1'];
  $count++ ;
}
$address_line2 = '';
if(isset($result['address_line2'])&&!empty($result['address_line2']))
{
  $address_line2 = $result['address_line2'];
  $count++ ;
}

$country = '';
if(isset($result['country'])&&!empty($result['country']))
{
  $country = $result['country'];
  $count++ ;
}

$state = '';
if(isset($result['state'])&&!empty($result['state']))
{
  $state = $result['state'];
  $count++ ;
}

$city = '';
if(isset($result['city'])&&!empty($result['city']))
{
  $city = $result['city'];
  $count++ ;
}


$postal_code = '';
if(isset($result['postal_code'])&&!empty($result['postal_code']))
{
  $postal_code = $result['postal_code'];
  $count++ ;
}

$under_college = '';
if(isset($result['under_college'])&&!empty($result['under_college']))
{
  $under_college = $result['under_college'];
  $count++ ;
}

$under_major = '';
if(isset($result['under_major'])&&!empty($result['under_major']))
{
  $under_major = $result['under_major'];
  $count++ ;
}

$graduate_college = '';
if(isset($result['graduate_college'])&&!empty($result['graduate_college']))
{
  $graduate_college = $result['graduate_college'];
  $count++ ;
}

$degree = '';
if(isset($result['degree'])&&!empty($result['degree']))
{
  $degree = $result['degree'];
  $count++ ;
}

$progress_value =  number_format((float)($count/$total)*100, 0, '.', '');
?>


<div class="row welcomerow">
  <div class="row titlerow">
    <div class="col-sm-4">
     <h2>Edit Profile</h2>
 </div> 
<!--  <div class="col-sm-4">
    <h3>Profile Progress</h3>
    <p>You must fully complete your profile for get the exact match</p>
</div>
<div class="col-sm-4">
    <div class="progress-cntr">
      <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: <?php echo $progress_value; ?>%;">
          <div class="progresstip"><?php echo $progress_value; ?>%</div>
      </div>
  </div>
</div>
</div> -->
</div>
<?php if($this->session->flashdata('success_message') != '') : ?>
  <div class="alert alert-success custom-alert"> <a href="#" class="close" data-dismiss="alert" aria-label="close">Hide</a> <?php echo $this->session->flashdata('success_message'); ?>. </div>
<?php endif; ?>

<div class="row">
  <div class="col-sm-12">
    <div class="profile-box">
      <div class="row">
        <div class="col-md-3">
          <div class="profile-left">
             <div id="avatar-view" class="">             
              <div class="slim edit-pro-slim"
              data-will-remove="imageRemoved"
              data-status-upload-success="Profile image updated"
              data-label-loading="File uploading.."
              data-instant-edit="true"
              data-service="<?php echo base_url(); ?>user/upload_avatar"
              data-push="true"
              data-ratio="1:1"
              data-label="Upload Image"
              data-size="360,360"
              data-max-file-size="2"                  
              >
              <img src="<?php echo $img; ?>" width="300" height="300" alt="Profile image" class="upprofile-img" />
              <input type="file" name="slim[]"/>
            </div>            
          </div> 

          <script type="text/javascript">
            function imageRemoved(){
              swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.value) {

                  $.get(base_url+'user/delete_profile_image',function(res){
                    var obj = jQuery.parseJSON(res);
                    if(obj.status == true){
                     swal(
                      'Deleted!',
                      'Profile image has been deleted.',
                      'success'
                      );
                     $('.upprofile-img,img-responsive,.in,.out').attr('src',obj.image_url);                   
                   }else{
                    swal({
                      type: 'error',
                      title: 'Oops...',
                      text: 'You dont have profile image yet!'                        
                    });
                  }

                });
                }
              });
            }
          </script>
            <div class="profile-preview"> <a href="<?php echo base_url(); ?>user/profile/<?php echo $this->session->userdata('applicant_id'); ?>" class="btn btn-success btn-block">Preview Profile</a> </div>
        </div>
    </div>
    <div class="col-md-9">
      <form id="mentor_profile_form" method="post" >
        <div class="profile-right">
          <div class="education-details">
            <h4>Build your profile</h4>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label">Username <span>*</span></label>
                  <input type="text" class="form-control" name="username" id="username" value="<?php echo $mentor_user_name; ?>" required readonly>
                  <span class="help-block"></span>
              </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label class="control-label">Email <span>*</span></label>
              <input type="text" class="form-control" name="email" id="email" value="<?php echo $mentor_email; ?>" required readonly>
              <span class="help-block"></span>
          </div>
      </div>
  </div>
  <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label class="control-label">First Name <span>*</span></label>
          <input type="text" class="form-control text" name="first_name" id="first_name" value="<?php echo $mentor_first_name; ?>" required>
          <span class="help-block"></span>
      </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group">
      <label class="control-label">Last Name <span>*</span></label>
      <input type="text" class="form-control text" name="last_name" id="last_name" value="<?php  echo $mentor_last_name; ?>" required>
      <span class="help-block"></span>
  </div>
</div>
</div>
<div class="row">
<!--   <div class="col-sm-6">
    <div class="form-group">
      <label class="control-label">Phone Number <span>*</span></label>
      <input type="text" class="form-control" name="mobile_number" id="mobile_number" value="<?php echo $mobile_number; ?>" required readonly>
      <span class="help-block"></span>
  </div>
</div> -->
<?php
if($result['dob'] != '1970-01-01' && $result['dob'] != '0000-00-00'){                              
  $date_of_birth  = date('d-m-Y',strtotime($result['dob']));
}else{
  $date_of_birth = '';
} 

?>
<div class="col-sm-6">
    <div class="form-group">
      <label class="control-label">Gender <span>*</span></label>
      <select class="form-control" name="mentor_gender" id="mentor_gender" required>
        <option value="">Please Select</option>
        <option value="1" <?php if($mentor_gender==1){ echo "selected";} ?> >Male</option>
        <option value="2" <?php if($mentor_gender==2){ echo "selected";} ?> >Female</option>
    </select>
    <span class="help-block"></span>
</div>
</div>
 <div class="col-sm-6">
    <div class="form-group">
      <label class="control-label">Date of birth</label>
      <input type="text" id="dob" name="dob" class="form-control datepicker" value="<?php echo $date_of_birth; ?>" autocomplete="off">
      <span class="help-block"></span>
  </div>
</div>
</div>


<div class="row">
 

</div>
</div>

<div class="bank-details">
    <h4>More Details</h4>
    <div class="row">
      <div class="col-xs-12">
        <div class="form-group">
          <label class="control-label">About Yourself<span> *</span></label>
          <textarea class="form-control text" name="mentor_personal_message" id="mentor_personal_message" rows="3" required maxlength="100" minlength="1"><?php echo $result['mentor_personal_message']; ?></textarea>
      </div>
  </div>
</div>
</div>



<div class="education-details">
    <div class="bank-details">
        <h4>Qualification Details</h4>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label class="control-label">Undergraduate college</label>
              <input type="text"  name="under_college" class="form-control text" value="<?php echo $result['under_college'];?>">
              <span class="help-block"></span>
          </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label class="control-label">Undergraduate major</label>
          <input type="text" name="under_major" class="form-control text" value="<?php echo $result['under_major'];?>">
          <span class="help-block"></span>
      </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group">
      <label class="control-label">Graduate college1</label>
      <input type="text"  name="graduate_college" class="form-control text" value="<?php echo $result['graduate_college'];?>">
      <span class="help-block"></span>
  </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
      <label class="control-label">Type of degree</label>
      <input type="text" id="" name="degree" class="form-control text" value="<?php echo $result['degree'];?>">
      <span class="help-block"></span>
  </div>
</div>
</div>
</div>
<div class="bank-details">
    <h4>Contact Details</h4>
    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label class="control-label">Address Line 1<span> *</span></label>
          <input type="text" class="form-control text" name="address_line1" value="<?php echo $address_line1; ?>" required>
          <span class="help-block"></span>
      </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group">
      <label class="control-label">Address Line 2</label>
      <input type="text" class="form-control text" name="address_line2" value="<?php echo $address_line2; ?>">
      <span class="help-block"></span>
  </div>
</div>
</div>

<div class="row">
  <div class="col-sm-6">
    <div class="form-group">
      <label class="control-label">Country<span> *</span></label>
      <input type="text" name="country" class="form-control text" id="country" value="<?php echo $country; ?>">
      <span class="help-block"></span>
  </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
      <label class="control-label">State
        <span> *</span></label>
        <input type="text" name="state" class="form-control text" id="state" value="<?php echo $result['state']; ?>">
        <span class="help-block"></span>
    </div>
</div>
</div>
<div class="row">
   <div class="col-sm-6">
    <div class="form-group">
      <label class="control-label">City<span> *</span></label>
      <input type="text" class="form-control" name="city" id="city" value="<?php echo $city; ?>" required>
      <span class="help-block"></span>
  </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
      <label class="control-label">Postal Code<span> *</span></label>
      <input type="text" class="form-control" name="postal_code" id="postal_code" value="<?php echo $postal_code; ?>" required>
      <span class="help-block"></span>
  </div>
</div>
<div class="col-sm-6"></div>
</div>
</div>
<div class="submit-btn">
    <button type="submit" class="btn btn-primary">Save Profile</button>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>


<!--Edit Profile Tabs Ends Here-->
<script type="text/javascript">

    $(document).ready(function(){


        $('#mentor_profile_form').submit(function(){
           $.ajax({
            url : base_url+'guru/update_profile',
            type: "POST",
            data: $('#mentor_profile_form').serialize(),
            dataType: "JSON",
            success: function(data)
            {

            if(data.status == true) //if success close modal and reload ajax table
            {
                setInterval(function(){ window.location = base_url+'user/edit_profile'; }, 1000);
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
       });


        $('input[name="charge_type"]').click(function(){
            var radioValue = $("input[name='charge_type']:checked"). val();
            if(radioValue == 'free'){
              $('#hourly_rate').attr('disabled',true);
          }else{
              $('#hourly_rate').attr('disabled',false);
          }
      });

        $('#dob').datetimepicker({
           maxDate: moment().subtract(0, 'y'),
           format: "DD/MM/YYYY",
           useCurrent: false
       });


        $('.text').keypress(function (e) {
            var regex = new RegExp(/^[a-zA-Z\s]+$/);
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
              return true;
          }
          else {
              e.preventDefault();
              return false;
          }
      });
        $('input,textarea').bind('copy paste cut',function(e) { 
        e.preventDefault(); //disable cut,copy,paste
    });


    });
</script>
