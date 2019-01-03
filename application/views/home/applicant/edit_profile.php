  <link href="<?php echo base_url(); ?>assets/css/slim.min.css" rel="stylesheet">   
  <script src="<?php echo base_url(); ?>assets/js/slim.kickstart.min.js"></script>
  <style type="text/css">
  .modal-body{
    font-size: 13px !important;
  }
  .alert-danger:empty,.alert-success:empty{ display: none !important; }
</style>
<?php

$count = 0 ;
$total = 44 ;
$mentor_first_name = '';
if(isset($result['first_name'])&&!empty($result['first_name'])){
  $mentor_first_name = $result['first_name'];
  $count++ ;
}
$mentor_last_name = '';
if(isset($result['last_name'])&&!empty($result['last_name'])){
  $mentor_last_name = $result['last_name'];
  $count++ ;
}
$mentor_user_name = '';
if(isset($result['email'])&&!empty($result['email'])){
  $mentor_user_name = $result['email'];
  $count++ ;
}
$mentor_email = '';
if(isset($result['email'])&&!empty($result['email'])){
  $mentor_email = $result['email'];
  $count++ ;
}
$profile_img = '';
if(isset($result['profile_img'])&&!empty($result['profile_img'])){
  $profile_img = $result['profile_img'];
}
$social_profile_img = '';
if(isset($result['picture_url'])&&!empty($result['picture_url'])){
  $social_profile_img = $result['picture_url'];
}
$img1 = '';
if($social_profile_img != ''){
  $img1 = $social_profile_img;
}
if($profile_img != ''){
  $file_to_check = FCPATH . '/assets/images/' . $profile_img;
  if (file_exists($file_to_check)) {
    $img1 = base_url() . 'assets/images/'.$profile_img;
  }
}
if(!empty($img1)){
  $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
  $count++ ;
}else{
  $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
}
$mobile_number = '';
if(isset($result['mobile_number'])&&!empty($result['mobile_number'])){
  $mobile_number = '+'.$result['mobile_number'];
  $count++ ;
}
$mentor_gender = '';
if(isset($result['mentor_gender'])&&!empty($result['mentor_gender'])){
  $mentor_gender = $result['mentor_gender'];
  $count++ ;
}
$mentor_school = '';
if(isset($result['mentor_school'])&&!empty($result['mentor_school'])){
 $mentor_school = $result['mentor_school'];
 $count++ ;
}
$mentor_current_year = '';
if(isset($result['mentor_current_year'])&&!empty($result['mentor_current_year'])){
  $mentor_current_year = $result['mentor_current_year'];
  $count++ ;
}
$mentor_schools_applied = '';
if(isset($result['mentor_schools_applied'])&&!empty($result['mentor_schools_applied'])){
  $mentor_schools_applied = $result['mentor_schools_applied'];
  $count++ ;
}
$mentor_clubs = '';
if(isset($result['mentor_clubs'])&&!empty($result['mentor_clubs'])){
  $mentor_clubs = $result['mentor_clubs'];
  $count++ ;
}
$mentor_charge = '';
if(isset($result['mentor_charge'])&&!empty($result['mentor_charge'])){
  $mentor_charge = $result['mentor_charge'];
  $count++ ;
}
$mentor_executive_positions = '';
if(isset($result['mentor_executive_positions'])&&!empty($result['mentor_executive_positions'])){
  $mentor_executive_positions = $result['mentor_executive_positions'];
  $count++ ;
}
$mentor_undergrad_school = '';
if(isset($result['mentor_undergrad_school'])&&!empty($result['mentor_undergrad_school'])){
  $mentor_undergrad_school = $result['mentor_undergrad_school'];
  $count++ ;
}
$mentor_job_title = '';
if(isset($result['mentor_job_title'])&&!empty($result['mentor_job_title'])){
  $mentor_job_title = $result['mentor_job_title'];
  $count++ ;
}
$mentor_job_company = '';
if(isset($result['mentor_job_company'])&&!empty($result['mentor_job_company'])){
  $mentor_job_company = $result['mentor_job_company'];
  $count++ ;
}
$mentor_job_dept = '';
if(isset($result['mentor_job_dept'])&&!empty($result['mentor_job_dept'])){
  $mentor_job_dept = $result['mentor_job_dept'];
  $count++ ;
}
$mentor_job_location = '';
if(isset($result['mentor_job_location'])&&!empty($result['mentor_job_location'])){
  $mentor_job_location = $result['mentor_job_location'];
  $count++ ;
}
$mentor_job_desc = '';
if(isset($result['mentor_job_desc'])&&!empty($result['mentor_job_desc'])){
  $mentor_job_desc = $result['mentor_job_desc'];
  $count++ ;
}
$mentor_job_from_month = '';
if(isset($result['mentor_job_from_month'])&&!empty($result['mentor_job_from_month'])){
  $mentor_job_from_month = $result['mentor_job_from_month'];
  $count++ ;
}
$mentor_job_from_year = '';
if(isset($result['mentor_job_from_year'])&&!empty($result['mentor_job_from_year'])){
  $mentor_job_from_year = $result['mentor_job_from_year'];
  $count++ ;
}
$mentor_job_to_month = '';
if(isset($result['mentor_job_to_month'])&&!empty($result['mentor_job_to_month'])){
  $mentor_job_to_month = $result['mentor_job_to_month'];
  $count++ ;
}
$mentor_job_to_year = '';
if(isset($result['mentor_job_to_year'])&&!empty($result['mentor_job_to_year']))
{
  $mentor_job_to_year = $result['mentor_job_to_year'];
  $count++ ;
}
$mentor_about = '';
if(isset($result['mentor_about'])&&!empty($result['mentor_about']))
{
  $mentor_about = $result['mentor_about'];
  $count++ ;
}
$mentor_personal_message = '';
if(isset($result['mentor_personal_message'])&&!empty($result['mentor_personal_message']))
{
  $mentor_personal_message = $result['mentor_personal_message'];
  $count++ ;
}
$mentor_school_accepted = '';
if(isset($result['mentor_school_accepted'])&&!empty($result['mentor_school_accepted']))
{
  $mentor_school_accepted = $result['mentor_school_accepted'];
  $count++ ;
}
$mentor_read_guide = '';
if(isset($result['mentor_read_guide'])&&!empty($result['mentor_read_guide']))
{
  $mentor_read_guide = $result['mentor_read_guide'];
  $count++ ;
}
$mentor_hire_consult = '';
if(isset($result['mentor_hire_consult'])&&!empty($result['mentor_hire_consult']))
{
  $mentor_hire_consult = $result['mentor_hire_consult'];
  $count++ ;
}
$mentor_visit_school = '';
if(isset($result['mentor_visit_school'])&&!empty($result['mentor_visit_school']))
{
  $mentor_visit_school = $result['mentor_visit_school'];
  $count++ ;
}
$mentor_tour = '';
if(isset($result['mentor_tour'])&&!empty($result['mentor_tour']))
{
  $mentor_tour = $result['mentor_tour'];
  $count++ ;
}
$mentor_other_extra = '';
if(isset($result['mentor_other_extra'])&&!empty($result['mentor_other_extra']))
{
  $mentor_other_extra = $result['mentor_other_extra'];
  $count++ ;
}
$mentor_extracurricular_activities = '';
if(isset($result['mentor_extracurricular_activities'])&&!empty($result['mentor_extracurricular_activities']))
{
  $mentor_extracurricular_activities = $result['mentor_extracurricular_activities'];
  $count++ ;
}
$mentor_hs = '';
if(isset($result['mentor_hs'])&&!empty($result['mentor_hs']))
{
  $mentor_hs = $result['mentor_hs'];
  $count++ ;
}
$mentor_from = '';
if(isset($result['mentor_from'])&&!empty($result['mentor_from']))
{
  $mentor_from = $result['mentor_from'];
  $count++ ;
}
$mentor_live_work = '';
if(isset($result['mentor_live_work'])&&!empty($result['mentor_live_work']))
{
  $mentor_live_work = $result['mentor_live_work'];
  $count++ ;
}
$mentor_languages_speak = '';
if(isset($result['mentor_languages_speak'])&&!empty($result['mentor_languages_speak']))
{
  $mentor_languages_speak = $result['mentor_languages_speak'];
  $count++ ;
}
$mentor_favourite = '';
if(isset($result['mentor_favourite'])&&!empty($result['mentor_favourite']))
{
  $mentor_favourite = $result['mentor_favourite'];
  $count++ ;
}
$mentor_hobbies = '';
if(isset($result['mentor_hobbies'])&&!empty($result['mentor_hobbies']))
{
  $mentor_hobbies = $result['mentor_hobbies'];
  $count++ ;
}
$mentor_quotes = '';
if(isset($result['mentor_quotes'])&&!empty($result['mentor_quotes']))
{
  $mentor_quotes = $result['mentor_quotes'];
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
$city = '';
if(isset($result['city'])&&!empty($result['city']))
{
  $city = $result['city'];
  $count++ ;
}
$state = '';
$country = '';
if(isset($result['country'])&&!empty($result['country']))
{
  $country = $result['country'];
  $count++ ;
}
$postal_code = '';
if(isset($result['postal_code'])&&!empty($result['postal_code']))
{
  $postal_code = $result['postal_code'];
  $count++ ;
}
$progress_value =  number_format((float)($count/$total)*100, 0, '.', '');
?>
<div class="row welcomerow">
  <div class="row titlerow">
    <div class="col-sm-4">
     <h2>Edit Profile</h2>
   </div> 
 </div>
 <?php if($this->session->flashdata('success_message') != '') : ?>
  <div class="alert alert-success custom-alert"> <a href="#" class="close" data-dismiss="alert" aria-label="close">Hide</a> <?php echo $this->session->flashdata('success_message'); ?>. </div>
<?php endif; ?>

<div class="row">
  <div class="col-sm-12">
    <div class="profile-box">
      <div class="row">
        <div class="col-md-3 col-sm-4 edit-profile-img">
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

          <div class="profile-preview"> <a href="<?php echo base_url(); ?>user/profile/<?php echo $this->session->userdata('applicant_id'); ?>" class="btn btn-success btn-block">Preview Profile</a>
          </div>
        </div>
      </div>
      <div class="col-md-9 col-sm-8 edit-profile-details">
        <form id="mentor_profile_form" method="post" >
          <div class="profile-right">
            <div class="education-details edu-details">
              <h4>Build your profile</h4>
              <input type="hidden"  value="<?php echo $result['app_id']; ?>" id="session_app_id">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label">Username <span>*</span></label>
                    <input type="text" class="form-control" name="username" id="username" value="<?php echo $mentor_user_name; ?>"  readonly>
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label">Email <span>*</span></label>
                    <input type="text" class="form-control" name="email" id="email" value="<?php echo $mentor_email; ?>"  readonly>
                    <span class="help-block"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label">First Name <span>*</span></label>
                    <input type="text" class="form-control text" name="first_name" id="first_name" value="<?php echo $mentor_first_name; ?>" required maxlength="25">
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label">Last Name <span>*</span></label>
                    <input type="text" class="form-control text" name="last_name" id="last_name" value="<?php  echo $mentor_last_name; ?>" required maxlength="25">
                    <span class="help-block"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label">Phone Number</label>                      

                    <div class="row">
                     <div class="input-group edit-profile-no">
                      <input type="text" class="form-control" name="mobile_number" id="new_mobile_number" value="<?php echo $mobile_number; ?>"  readonly>
                      <a href="javascript:void(0);" class="input-group-addon" data-toggle="modal" data-target="#edit_modal"><i class="fa fa-edit"></i></a>
                    </div>
                  </div>                  
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label">Gender</label>
                  <select class="form-control" name="mentor_gender" id="mentor_gender" >
                    <option value="">Please Select</option>
                    <option value="1" <?php if($mentor_gender==1){ echo "selected";} ?> >Male</option>
                    <option value="2" <?php if($mentor_gender==2){ echo "selected";} ?> >Female</option>
                  </select>
                  <span class="help-block"></span>
                </div>
              </div>
            </div>
            <?php
            if($result['dob'] != '1970-01-01' && $result['dob'] != '0000-00-00' && !empty($result['dob'])){                              
              $date_of_birth  = date('d-m-Y',strtotime($result['dob']));
            }else{
              $date_of_birth = '';
            } 

            ?>

            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label">Date of birth</label>
                  <input type="text" id="dob" name="dob" class="form-control datepicker" value="<?php echo $date_of_birth; ?>">
                  <span class="help-block"></span>
                </div>
              </div>

            </div>
          </div>

          <div class="bank-details more-details">
            <h4>More Details</h4>
            <div class="row">
              <div class="alert alert-danger bio-alert"></div>
              <div class="col-xs-12">
                <div class="form-group">
                  <label class="control-label">Biography</label>                 

                  <textarea class="form-control" name="mentor_personal_message" id="mentor_personal_message" maxlength="500" minlength="40" ><?php echo $mentor_personal_message=$result['mentor_personal_message']; ?></textarea>
                  <br>
                  <span class="pull-right">
                   <span id="chars"><?php echo $charsb = 500 - strlen($mentor_personal_message); ?></span> characters remaining
                 </span>

               </div>
             </div>
           </div>
         </div>



         <div class="education-details">
          <h4 class="<?php if($this->session->userdata('type') == 'user' ){ echo 'hidden'; } ?>">Charging</h4>
          <div class="row <?php if($this->session->userdata('type') == 'user' ){ echo 'hidden'; } ?>">
            <div class="col-sm-6 form-inline">
              <div class="form-group">

                <label class="control-label">
                  <input type="radio" class="form-control charge-radio" name="charge_type" value="free" <?php if( $result['charge_type'] == 'free'){ echo 'checked="checked"'; } ?>> Free</label>
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="col-sm-6 form-inline">
                <div class="form-group">
                  <label class="control-label">
                    <input type="radio" class="form-control charge-radio" name="charge_type" value="charge" <?php if( $result['charge_type'] == 'charge'){ echo 'checked="checked"'; } ?> > Charge (per hour in dollar)
                  </label><br>
                  <input type="text" class="form-control" name="hourly_rate" id="hourly_rate" value="<?php echo $result['hourly_rate']; ?>" required min="1"  <?php if( $result['charge_type'] != 'charge'){ echo 'disabled'; } ?> onkeypress="return isRate(event)">
                  <span class="help-block"></span>
                </div>
              </div>
            </div>
            <div class="bank-details qualification-details">
              <h4>Qualification Details</h4>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label">Undergraduate college</label>
                    <input type="text"  name="under_college" class="form-control text" value="<?php echo $result['under_college'];?>" maxlength="100">
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label">Undergraduate major</label>
                    <input type="text" name="under_major" class="form-control text" value="<?php echo $result['under_major'];?>" maxlength="100">
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label">Graduate college1</label>
                    <input type="text"  name="graduate_college" class="form-control text" value="<?php echo $result['graduate_college'];?>" maxlength="100">
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label">Type of degree</label>
                    <input type="text" id="" name="degree" class="form-control text" value="<?php echo $result['degree'];?>" maxlength="100">
                    <span class="help-block"></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="bank-details contact-details">
              <h4>Contact Details</h4>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label">Address Line 1</label>
                    <input type="text" class="form-control " name="address_line1" value="<?php echo $address_line1; ?>" >
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label">Address Line 2</label>
                    <input type="text" class="form-control " name="address_line2" value="<?php echo $address_line2; ?>">
                    <span class="help-block"></span>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label">Country</label>
                    <input type="text" name="country" class="form-control text" id="country" value="<?php echo $country; ?>"  maxlength="100">
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label">State
                    </label>
                    <input type="text" name="state" class="form-control text" id="state" value="<?php echo $result['state']; ?>"  maxlength="100">
                    <span class="help-block"></span>
                  </div>
                </div>
              </div>
              <div class="row">
               <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label">City</label>
                  <input type="text" class="form-control text" name="city" id="city" value="<?php echo $city; ?>"  maxlength="100">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label">Postal Code</label>
                  <input type="text" class="form-control" name="postal_code" id="postal_code" value="<?php echo $postal_code; ?>" onkeypress="return isNumberKey(event)"  maxlength="10">
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


<!-- Modal -->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3>Enter new mobile number</h3>
      </div>

      <div class="modal-body"> 
        <form method="post" id="mobile_verify_form">               
          <div class="form-horzontal">
           <div id="error_msg" class="alert alert-danger"></div>
           <div id="success_msg"  class="alert alert-success"></div>
           <div class="row">              
            <div class="col-sm-5">
              <select name="country_code" class="form-control" id="country_code">
               <option data-countryCode="GB" value="44" Selected>UK (+44)</option>
               <option data-countryCode="US" value="1">USA (+1)</option>
               <optgroup label="Other countries">
                 <option data-countryCode="DZ" value="213">Algeria (+213)</option>
                 <option data-countryCode="AD" value="376">Andorra (+376)</option>
                 <option data-countryCode="AO" value="244">Angola (+244)</option>
                 <option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
                 <option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
                 <option data-countryCode="AR" value="54">Argentina (+54)</option>
                 <option data-countryCode="AM" value="374">Armenia (+374)</option>
                 <option data-countryCode="AW" value="297">Aruba (+297)</option>
                 <option data-countryCode="AU" value="61">Australia (+61)</option>
                 <option data-countryCode="AT" value="43">Austria (+43)</option>
                 <option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
                 <option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
                 <option data-countryCode="BH" value="973">Bahrain (+973)</option>
                 <option data-countryCode="BD" value="880">Bangladesh (+880)</option>
                 <option data-countryCode="BB" value="1246">Barbados (+1246)</option>
                 <option data-countryCode="BY" value="375">Belarus (+375)</option>
                 <option data-countryCode="BE" value="32">Belgium (+32)</option>
                 <option data-countryCode="BZ" value="501">Belize (+501)</option>
                 <option data-countryCode="BJ" value="229">Benin (+229)</option>
                 <option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
                 <option data-countryCode="BT" value="975">Bhutan (+975)</option>
                 <option data-countryCode="BO" value="591">Bolivia (+591)</option>
                 <option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
                 <option data-countryCode="BW" value="267">Botswana (+267)</option>
                 <option data-countryCode="BR" value="55">Brazil (+55)</option>
                 <option data-countryCode="BN" value="673">Brunei (+673)</option>
                 <option data-countryCode="BG" value="359">Bulgaria (+359)</option>
                 <option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
                 <option data-countryCode="BI" value="257">Burundi (+257)</option>
                 <option data-countryCode="KH" value="855">Cambodia (+855)</option>
                 <option data-countryCode="CM" value="237">Cameroon (+237)</option>
                 <option data-countryCode="CA" value="1">Canada (+1)</option>
                 <option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
                 <option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
                 <option data-countryCode="CF" value="236">Central African Republic (+236)</option>
                 <option data-countryCode="CL" value="56">Chile (+56)</option>
                 <option data-countryCode="CN" value="86">China (+86)</option>
                 <option data-countryCode="CO" value="57">Colombia (+57)</option>
                 <option data-countryCode="KM" value="269">Comoros (+269)</option>
                 <option data-countryCode="CG" value="242">Congo (+242)</option>
                 <option data-countryCode="CK" value="682">Cook Islands (+682)</option>
                 <option data-countryCode="CR" value="506">Costa Rica (+506)</option>
                 <option data-countryCode="HR" value="385">Croatia (+385)</option>
                 <option data-countryCode="CU" value="53">Cuba (+53)</option>
                 <option data-countryCode="CY" value="90392">Cyprus North (+90392)</option>
                 <option data-countryCode="CY" value="357">Cyprus South (+357)</option>
                 <option data-countryCode="CZ" value="42">Czech Republic (+42)</option>
                 <option data-countryCode="DK" value="45">Denmark (+45)</option>
                 <option data-countryCode="DJ" value="253">Djibouti (+253)</option>
                 <option data-countryCode="DM" value="1809">Dominica (+1809)</option>
                 <option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
                 <option data-countryCode="EC" value="593">Ecuador (+593)</option>
                 <option data-countryCode="EG" value="20">Egypt (+20)</option>
                 <option data-countryCode="SV" value="503">El Salvador (+503)</option>
                 <option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
                 <option data-countryCode="ER" value="291">Eritrea (+291)</option>
                 <option data-countryCode="EE" value="372">Estonia (+372)</option>
                 <option data-countryCode="ET" value="251">Ethiopia (+251)</option>
                 <option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
                 <option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
                 <option data-countryCode="FJ" value="679">Fiji (+679)</option>
                 <option data-countryCode="FI" value="358">Finland (+358)</option>
                 <option data-countryCode="FR" value="33">France (+33)</option>
                 <option data-countryCode="GF" value="594">French Guiana (+594)</option>
                 <option data-countryCode="PF" value="689">French Polynesia (+689)</option>
                 <option data-countryCode="GA" value="241">Gabon (+241)</option>
                 <option data-countryCode="GM" value="220">Gambia (+220)</option>
                 <option data-countryCode="GE" value="7880">Georgia (+7880)</option>
                 <option data-countryCode="DE" value="49">Germany (+49)</option>
                 <option data-countryCode="GH" value="233">Ghana (+233)</option>
                 <option data-countryCode="GI" value="350">Gibraltar (+350)</option>
                 <option data-countryCode="GR" value="30">Greece (+30)</option>
                 <option data-countryCode="GL" value="299">Greenland (+299)</option>
                 <option data-countryCode="GD" value="1473">Grenada (+1473)</option>
                 <option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
                 <option data-countryCode="GU" value="671">Guam (+671)</option>
                 <option data-countryCode="GT" value="502">Guatemala (+502)</option>
                 <option data-countryCode="GN" value="224">Guinea (+224)</option>
                 <option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
                 <option data-countryCode="GY" value="592">Guyana (+592)</option>
                 <option data-countryCode="HT" value="509">Haiti (+509)</option>
                 <option data-countryCode="HN" value="504">Honduras (+504)</option>
                 <option data-countryCode="HK" value="852">Hong Kong (+852)</option>
                 <option data-countryCode="HU" value="36">Hungary (+36)</option>
                 <option data-countryCode="IS" value="354">Iceland (+354)</option>
                 <option data-countryCode="IN" value="91">India (+91)</option>
                 <option data-countryCode="ID" value="62">Indonesia (+62)</option>
                 <option data-countryCode="IR" value="98">Iran (+98)</option>
                 <option data-countryCode="IQ" value="964">Iraq (+964)</option>
                 <option data-countryCode="IE" value="353">Ireland (+353)</option>
                 <option data-countryCode="IL" value="972">Israel (+972)</option>
                 <option data-countryCode="IT" value="39">Italy (+39)</option>
                 <option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
                 <option data-countryCode="JP" value="81">Japan (+81)</option>
                 <option data-countryCode="JO" value="962">Jordan (+962)</option>
                 <option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
                 <option data-countryCode="KE" value="254">Kenya (+254)</option>
                 <option data-countryCode="KI" value="686">Kiribati (+686)</option>
                 <option data-countryCode="KP" value="850">Korea North (+850)</option>
                 <option data-countryCode="KR" value="82">Korea South (+82)</option>
                 <option data-countryCode="KW" value="965">Kuwait (+965)</option>
                 <option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
                 <option data-countryCode="LA" value="856">Laos (+856)</option>
                 <option data-countryCode="LV" value="371">Latvia (+371)</option>
                 <option data-countryCode="LB" value="961">Lebanon (+961)</option>
                 <option data-countryCode="LS" value="266">Lesotho (+266)</option>
                 <option data-countryCode="LR" value="231">Liberia (+231)</option>
                 <option data-countryCode="LY" value="218">Libya (+218)</option>
                 <option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
                 <option data-countryCode="LT" value="370">Lithuania (+370)</option>
                 <option data-countryCode="LU" value="352">Luxembourg (+352)</option>
                 <option data-countryCode="MO" value="853">Macao (+853)</option>
                 <option data-countryCode="MK" value="389">Macedonia (+389)</option>
                 <option data-countryCode="MG" value="261">Madagascar (+261)</option>
                 <option data-countryCode="MW" value="265">Malawi (+265)</option>
                 <option data-countryCode="MY" value="60">Malaysia (+60)</option>
                 <option data-countryCode="MV" value="960">Maldives (+960)</option>
                 <option data-countryCode="ML" value="223">Mali (+223)</option>
                 <option data-countryCode="MT" value="356">Malta (+356)</option>
                 <option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
                 <option data-countryCode="MQ" value="596">Martinique (+596)</option>
                 <option data-countryCode="MR" value="222">Mauritania (+222)</option>
                 <option data-countryCode="YT" value="269">Mayotte (+269)</option>
                 <option data-countryCode="MX" value="52">Mexico (+52)</option>
                 <option data-countryCode="FM" value="691">Micronesia (+691)</option>
                 <option data-countryCode="MD" value="373">Moldova (+373)</option>
                 <option data-countryCode="MC" value="377">Monaco (+377)</option>
                 <option data-countryCode="MN" value="976">Mongolia (+976)</option>
                 <option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
                 <option data-countryCode="MA" value="212">Morocco (+212)</option>
                 <option data-countryCode="MZ" value="258">Mozambique (+258)</option>
                 <option data-countryCode="MN" value="95">Myanmar (+95)</option>
                 <option data-countryCode="NA" value="264">Namibia (+264)</option>
                 <option data-countryCode="NR" value="674">Nauru (+674)</option>
                 <option data-countryCode="NP" value="977">Nepal (+977)</option>
                 <option data-countryCode="NL" value="31">Netherlands (+31)</option>
                 <option data-countryCode="NC" value="687">New Caledonia (+687)</option>
                 <option data-countryCode="NZ" value="64">New Zealand (+64)</option>
                 <option data-countryCode="NI" value="505">Nicaragua (+505)</option>
                 <option data-countryCode="NE" value="227">Niger (+227)</option>
                 <option data-countryCode="NG" value="234">Nigeria (+234)</option>
                 <option data-countryCode="NU" value="683">Niue (+683)</option>
                 <option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
                 <option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
                 <option data-countryCode="NO" value="47">Norway (+47)</option>
                 <option data-countryCode="OM" value="968">Oman (+968)</option>
                 <option data-countryCode="PK" value="92">Pakistan (+92)</option>
                 <option data-countryCode="PW" value="680">Palau (+680)</option>
                 <option data-countryCode="PA" value="507">Panama (+507)</option>
                 <option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
                 <option data-countryCode="PY" value="595">Paraguay (+595)</option>
                 <option data-countryCode="PE" value="51">Peru (+51)</option>
                 <option data-countryCode="PH" value="63">Philippines (+63)</option>
                 <option data-countryCode="PL" value="48">Poland (+48)</option>
                 <option data-countryCode="PT" value="351">Portugal (+351)</option>
                 <option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
                 <option data-countryCode="QA" value="974">Qatar (+974)</option>
                 <option data-countryCode="RE" value="262">Reunion (+262)</option>
                 <option data-countryCode="RO" value="40">Romania (+40)</option>
                 <option data-countryCode="RU" value="7">Russia (+7)</option>
                 <option data-countryCode="RW" value="250">Rwanda (+250)</option>
                 <option data-countryCode="SM" value="378">San Marino (+378)</option>
                 <option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
                 <option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
                 <option data-countryCode="SN" value="221">Senegal (+221)</option>
                 <option data-countryCode="CS" value="381">Serbia (+381)</option>
                 <option data-countryCode="SC" value="248">Seychelles (+248)</option>
                 <option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
                 <option data-countryCode="SG" value="65">Singapore (+65)</option>
                 <option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
                 <option data-countryCode="SI" value="386">Slovenia (+386)</option>
                 <option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
                 <option data-countryCode="SO" value="252">Somalia (+252)</option>
                 <option data-countryCode="ZA" value="27">South Africa (+27)</option>
                 <option data-countryCode="ES" value="34">Spain (+34)</option>
                 <option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
                 <option data-countryCode="SH" value="290">St. Helena (+290)</option>
                 <option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
                 <option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
                 <option data-countryCode="SD" value="249">Sudan (+249)</option>
                 <option data-countryCode="SR" value="597">Suriname (+597)</option>
                 <option data-countryCode="SZ" value="268">Swaziland (+268)</option>
                 <option data-countryCode="SE" value="46">Sweden (+46)</option>
                 <option data-countryCode="CH" value="41">Switzerland (+41)</option>
                 <option data-countryCode="SI" value="963">Syria (+963)</option>
                 <option data-countryCode="TW" value="886">Taiwan (+886)</option>
                 <option data-countryCode="TJ" value="7">Tajikstan (+7)</option>
                 <option data-countryCode="TH" value="66">Thailand (+66)</option>
                 <option data-countryCode="TG" value="228">Togo (+228)</option>
                 <option data-countryCode="TO" value="676">Tonga (+676)</option>
                 <option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
                 <option data-countryCode="TN" value="216">Tunisia (+216)</option>
                 <option data-countryCode="TR" value="90">Turkey (+90)</option>
                 <option data-countryCode="TM" value="7">Turkmenistan (+7)</option>
                 <option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
                 <option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
                 <option data-countryCode="TV" value="688">Tuvalu (+688)</option>
                 <option data-countryCode="UG" value="256">Uganda (+256)</option>           
                 <option data-countryCode="UA" value="380">Ukraine (+380)</option>
                 <option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
                 <option data-countryCode="UY" value="598">Uruguay (+598)</option>           
                 <option data-countryCode="UZ" value="7">Uzbekistan (+7)</option>
                 <option data-countryCode="VU" value="678">Vanuatu (+678)</option>
                 <option data-countryCode="VA" value="379">Vatican City (+379)</option>
                 <option data-countryCode="VE" value="58">Venezuela (+58)</option>
                 <option data-countryCode="VN" value="84">Vietnam (+84)</option>
                 <option data-countryCode="VG" value="84">Virgin Islands - British (+1284)</option>
                 <option data-countryCode="VI" value="84">Virgin Islands - US (+1340)</option>
                 <option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
                 <option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
                 <option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
                 <option data-countryCode="ZM" value="260">Zambia (+260)</option>
                 <option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
               </optgroup>
             </select> 
           </div>
           <div class="col-sm-7">
            <input type="text" class="form-control" name="mobile_number" id="mobile_number" required autocomplete="off" onkeypress="return isNumberKey(event)">
            <span class="help-block" id="mobile_number"></span>
          </div>
        </div>

      </div>                          
      <br>
      <div class="modal-footer">
       <button type="submit" class="btn btn-primary" >Send OTP</button>
       <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
     </div>
   </form>   


   <form method="post" id="mobile_verify_code_form" style="display: none"> 
    <div class="alert alert-success"> An OTP has been sent to your Mobile number. If you don't receive an OTP,Try to resend the OTP or try with alternate number.
    </div>
    <div id="error_msg" style="color:red;"></div>
    <div class="row resendemail">
      <div class="col-xs-12"><label class="control-label">Enter the verification code</label></div>
      <div class="col-sm-4">
        <input type="text" name="verification_code" id="verification_code" class="form-control" value="" required autocomplete="off" />
        <br>
        <a href="javascript:void(0);" onclick="showMobileData_again()">Try alternate number?</a>
      </div>                
      <div class="col-sm-8">
        <button type="submit" class="btn btn-primary verify" >Verify</button>
        <button type="button" class="btn btn-primary send_again_otp" onclick="resend_otp()">Send Again</button>
      </div>

    </div>
  </div>
</form>




</div>
</div>
</div>
<!-- Modal -->








<style type="text/css">
#mobile_verify_form #country_code {
  height: 34px;
}
</style>
<script src="<?php echo base_url()."assets/" ?>js/bootstrapValidator.js" type="text/javascript"></script>
<script src='<?php echo base_url()."assets/" ?>js/moment.js'></script>
<script src="<?php echo base_url()."assets/" ?>js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<input type="hidden" value="<?php echo date('m-d-Y', strtotime('-5 years')); ?>" id="maxDate">  

<!--Edit Profile Tabs Ends Here-->
<script type="text/javascript">

  function showMobileData_again()
  {

    $("#mobile_verify_form").css('display','block');
    $("#mobile_verify_code_form").css('display','none');

  }

  function resend_otp(){
    $('.send_again_otp').text('Please wait...');
    $.get(base_url+'welcome/send_again_otp',function(res){
     var obj = jQuery.parseJSON(res);
     $('.send_again_otp').text('Send again');

     if(obj.status){
      swal(
        'Success!',
        'OTP sent to your mobile number.',
        'success'
        )
      $('.verify').attr('disabled',false);
      $('#mobile_number').val('');
      $('#mobile_verify_form').css("display","none");
      $('#mobile_verify_code_form').css("display","block");
    }
    else
    {
      $('#error_msg').html(obj.message);
      $('#error_msg').css('display','block');
    }


  });
  }



  $('#mobile_verify_form').bootstrapValidator({
    fields: {
      country_code: {
        validators: {
          notEmpty: {
            message: 'Select country code '
          }
        }
      },
      mobile_number: {
        validators: {
          stringLength: {
            min: 10,
            max: 15,
            message: 'Mobile number should be more than 10 digit and maximum 15 digit'
          },
          notEmpty: {
            message: 'The Mobile Number is required'
          }
        }
      }
    }
  }) .on('success.form.bv', function(e) {
                                      // Prevent form submission
                                      e.preventDefault();
                                      var number  = $('#mobile_number').val();
                                      if(number == ''){ 
                                        $('#mobile_verify_form').submit();                                         
                                        return false;
                                      }
                                      var url = base_url+"welcome/send_otp";
                                      var formData = $('#mobile_verify_form').serialize();
                                      $.ajax({
                                        type:'POST',
                                        url:url,
                                        data:formData,
                                        success:function(response)
                                        {

                                          var obj = jQuery.parseJSON(response);

                                          if(obj.status)
                                          {
                                            $('#mobile_number').val('');
                                            $('#mobile_verify_form').css("display","none");
                                            $('#mobile_verify_code_form').css("display","block");
                                          }
                                          else
                                          {
                                            $('#error_msg').html(obj.message);
                                            $('#error_msg').css('display','block');
                                          }
                                        }
                                      })


                                    });



  $('#mobile_verify_code_form').bootstrapValidator({
    fields: {
      verification_code: {
        validators: {
          notEmpty: {
            message: 'The Verification Code is required'
          }
        }
      }
    }
  }) .on('success.form.bv', function(e) {
                                      // Prevent form submission
                                      e.preventDefault();
                                      var url = base_url+"welcome/check_otp";
                                      var formData = $('#mobile_verify_code_form').serialize();
                                      $.ajax({
                                        type:'POST',
                                        url:url,
                                        data:formData,
                                        success:function(response)
                                        {

                                          var obj = jQuery.parseJSON(response);
                                           //   console.log(response);
                                           if(obj.mobile_number){
                                            $('#verification_code').val('');
                                            $('#new_mobile_number').val(obj.mobile_number);
                                            $('#mobile_verify_form,#mobile_verify_code_form,#mobile_title,#mobile_first_verify').css("display","none");                                            
                                            $('#mobile_verify_form').css("display","block");
                                            $('#success_msg').html('OTP verified successfully!');

                                            setTimeout(function() {
                                              $('#success_msg').html('');
                                              $('#edit_modal').modal('hide');
                                            }, 1000);
                                            

                                          }else{
                                           swal({
                                            title: 'Oops!',
                                            text: "Wrong OTP you entered!",
                                            type: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'Send again OTP!',
                                            confirmButtonClass: 'btn btn-success',
                                            cancelButtonText: 'No will try again!',
                                            cancelButtonClass: 'btn btn-danger',
                                            buttonsStyling: false,
                                            reverseButtons: true
                                          }).then((result) => {
                                            if (result.value) {

                                              swal(
                                                'Success!',
                                                'OTP sent to your mobile number.',
                                                'success'
                                                )
                                              $('.verify').attr('disabled',false);
                                              $.get(base_url+'welcome/send_again_otp',function(res){

                                              });


                                            }else if(result.dismiss === 'cancel'){
                                              $('.verify').attr('disabled',false);

                                            }
                                          })
                                        }
                                      }
                                    });

                                    });




  $(document).ready(function(){
    $('#mobile_number').keyup(function(){
      $('.alert-danger').html('');
    });
    $('input[name="charge_type"]').click(function(){
      var radioValue = $("input[name='charge_type']:checked"). val();
      if(radioValue == 'free'){
        $('#hourly_rate').attr('disabled',true);
      }else{
        $('#hourly_rate').attr('disabled',false);
      }
    });

   //  $('#dob').datetimepicker({
   //   maxDate: moment().subtract(0, 'y'),
   //   format: "DD/MM/YYYY",
   //   useCurrent: false
   // });


   var maxDate = $('#maxDate').val();
   maxDate =  moment(maxDate, 'MM-DD-YYYY hh:mm A');

   $('#dob').datetimepicker({
    maxDate: maxDate,
    format: "DD/MM/YYYY",
    useCurrent: false
  });





   $('.special').keydown(function (e) {       
     var key = e.keyCode;
    //         keys a-z,0-9               numpad keys 0-9            minus sign    backspace
    if ( ( key >= 48 && key <= 90 ) || ( key >= 96 && key <= 105 )  || key == 109 || key==8){
      return true;
    }
    else
    {
      return false
    }                       
  });




   $('.text').keypress(function (e) {             
     var regex = new RegExp("^[\\w\\-\\/ \\b\\t]+$");
     var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
     if (regex.test(str)) {
      return true;
    }
    else {
      e.preventDefault();
      return false;
    }
  });


   $('#dob').bind('copy paste cut',function(e) { 
        e.preventDefault(); //disable cut,copy,paste
      });



 });



  function isRate(evt) {
   var charCode = (evt.which) ? evt.which : evt.keyCode;
   if (charCode != 46 && charCode > 31 
    && (charCode < 48 || charCode > 57))
    return false;
  return true;
}


function isNumberKey(evt){
  var charCode = (evt.which) ? evt.which : evt.keyCode
  return !(charCode > 31 && (charCode < 48 || charCode > 57));
}



var _URL = window.URL || window.webkitURL;
function validateFileType(){
  var fileName = document.getElementById("avatarInput").value;
  var idxDot = fileName.lastIndexOf(".") + 1;
  var file = document.getElementById("avatarInput").files[0];
  var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();

  img = new Image();
  img.src = _URL.createObjectURL(file);
  img.onload = function() 
  {         

    if(this.width <256 && this.height <256 ){
      alert('Please upload your picture with the minimum resolution of width x height( 256 x 256 ) ');
      $('#avatarInput').val('');
      $('#avatar-modal').modal('hide');
      return false;
    }


  };





  if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
                              //TO DO
                               if (file.size > 2097152) // 2 mb for bytes.
                               {
                                alert("File size must under 2mb!");
                                $('#avatarInput').val('');
                                return false;
                              }


                            }else{
                              alert("Only jpg/jpeg and png files are allowed!");
                              $('#avatarInput').val('');
                              return false;
                            }   
                          }


                          

// function validateFileType(){
//   var fileName = document.getElementById("avatarInput").value;
//   var idxDot = fileName.lastIndexOf(".") + 1;
//   var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();




//                   var file = document.getElementById("avatarInput").files[0];

//                   if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
//                                 //TO DO

//                                 if (file.size > 2097152) // 2 mb for bytes.
//                                 {
//                                   alert("File size must under 2mb!");
//                                   $('#avatarInput').val('');
//                                   return false;
//                                 }


//                               }else{
//                                 alert("Only jpg/jpeg and png files are allowed!");
//                                 $('#avatarInput').val('');
//                               }   
//                             }

</script>
