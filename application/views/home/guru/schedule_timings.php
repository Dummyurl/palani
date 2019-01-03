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
  $mobile_number = $result['mobile_number'];
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
<div class="container schedule-timing-details">
<div class="row" id="timings">
  <div class="titlerow">
    <div class="col-sm-6">
     <h2>Schedule Timings</h2>
   </div>
   <div class="col-sm-6 text-right"></div>
 </div>

<?php if($this->session->flashdata('success_message') != '') : ?>
  <div class="alert alert-success custom-alert"> <a href="#" class="close" data-dismiss="alert" aria-label="close">Hide</a> <?php echo $this->session->flashdata('success_message'); ?>. </div>
<?php endif; ?>

<div class="">
  <div class="col-sm-12">
    <div class="profile-box">
      <div class="row">
        <div class="col-md-12">
          <div class="subnav timingsnav">
                <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" id="tsunday_link" href="#tsunday" data-day-value="1" data-append-value="tsunday">Sunday</a></li>
                  <li><a data-toggle="tab" id="tmonday_link" href="#tmonday" data-day-value="2" data-append-value="tmonday">Monday</a></li>
                  <li><a data-toggle="tab" id="ttuesday_link" href="#ttuesday" data-day-value="3" data-append-value="ttuesday">Tuesday</a></li>
                  <li><a data-toggle="tab" id="twednesday_link" href="#twednesday" data-day-value="4" data-append-value="twednesday">Wednesday</a></li>
                  <li><a data-toggle="tab" id="tthursday_link" href="#tthursday" data-day-value="5" data-append-value="tthursday">Thursday</a></li>
                  <li><a data-toggle="tab" id="tfriday_link" href="#tfriday" data-day-value="6" data-append-value="tfriday">Friday</a></li>
                  <li><a data-toggle="tab" id="tsaturday_link" href="#tsaturday" data-day-value="7" data-append-value="tsaturday">Saturday</a></li>
                </ul>
              </div>
              <div class="tab-content">
                <div class="row">
                  <form id="schedule_mentor_form" name="schedule_mentor_form" method="post">
                    <div class="col-md-2 col-sm-4">
                      <input type="hidden" name="day_value" id="day_value" value="1">
                      <input type="hidden" name="day_name" id="day_name" value="Sunday">
                      <input type="hidden" name="id_value" id="id_value" value="">
                      <label class="control-label">From</label>
                      <select class="form-control" id="from_time" name="from_time">
                      </select>
                    </div>
                    <div class="col-md-2 col-sm-4">
                      <label class="control-label">To</label>
                      <select class="form-control" id="to_time" name="to_time">
                      </select>
                    </div>
                    <div class="col-md-8 col-sm-4">
                      <button class="btn btn-success tadd" type="submit">ADD</button>
                    </div>
                  </form>
                </div>
                <!--Starts Here-->
                <div id="tsunday" class="tab-pane fade in active"> </div>
                <!--Ends Here-->
                <!--Starts Here-->
                <div id="tmonday" class="tab-pane fade"> </div>
                <!--Ends Here-->
                <!--Starts Here-->
                <div id="ttuesday" class="tab-pane fade"> </div>
                <!--Ends Here-->
                <!--Starts Here-->
                <div id="twednesday" class="tab-pane fade"> </div>
                <!--Ends Here-->
                <!--Starts Here-->
                <div id="tthursday" class="tab-pane fade"> </div>
                <!--Ends Here-->
                <!--Starts Here-->
                <div id="tfriday" class="tab-pane fade"> </div>
                <!--Ends Here-->
                <!--Starts Here-->
                <div id="tsaturday" class="tab-pane fade"> </div>
                <!--Ends Here-->
              </div>
               <!--Copy paste code ends here-->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
  $(".container").removeClass("dashboard-container");
</script>