<div class="container conversation-section">
  <div class="row titlerow clickable">
    <div class="col-sm-6">
      <h2>Conversations</h2>
    </div>
    <div class="col-sm-6 text-right"></div>
  </div>

  <div class="conversation clickable"></div>
</div>
</section>
<!-- Chat Message  -->
<div class="conv_messages_box">
  <!--Chat Box Starts-->
  <div class="panel-heading"> 
    <div class="user-details">
      <div class="user-info pull-left openchat"><a href="#">Andrew Dawis<span class="status"></span></a></div>
    </div>
    <div class="pull-right chattrash">
      <a title="Delete Chat History" onclick="delete_conversation();" href="javascript:void(0)"><i aria-hidden="true" class="fa fa-trash-o"></i></a>
    </div>
    <div class="progress upload-progress hidden">
      <div style="width: 100%;" aria-valuemax="100" aria-valuemin="100" aria-valuenow="100" role="progressbar" class="progress-bar progress-bar-success active progress-bar-striped">
        Uploading...  
      </div>
    </div>                               
  </div>
  <div class="panel-body">
    <div class="chat-box slimscrollleft mCustomScrollbar _mCS_2 mCS-autoHide" id="chat-box" style="position: relative; overflow: visible;"><div class="mCustomScrollBox mCS-minimal mCSB_vertical mCSB_outside" id="mCSB_2" style="max-height: none;" tabindex="0"><div dir="ltr" style="position:relative; top:0; left:0;" class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y" id="mCSB_2_container">
      <div class="chats"></div>    
    </div>
  </div>
  <div class="mCSB_scrollTools mCSB_2_scrollbar mCS-minimal mCSB_scrollTools_vertical" id="mCSB_2_scrollbar_vertical" style="display: none;">
    <div class="mCSB_draggerContainer"><div style="position: absolute; min-height: 50px; top: 0px; height: 0px;" class="mCSB_dragger" id="mCSB_2_dragger_vertical"><div class="mCSB_dragger_bar" style="line-height: 50px;"></div></div><div class="mCSB_draggerRail"></div></div></div></div>
  </div>
  <div class="panel-footer" id="chat" onsubmit="return false">
    <form name="chat_form" id="chat_form" enctype="multipart/form-data" method="post" action="<?php echo base_url(); ?>upload/upload_files">
      <div class="message-bar">
        <div class="message-inner">
          <a class="link attach-icon" href="javascript:void(0)" style="position: absolute;right: 90px;
    top: 13px;"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
          <div class="message-area" style="position: inherit;top: 0;padding: 0px;margin: 0px;">
            <input type="text" name="input_message" id="input_message" placeholder="Type message..." class="chat-input" autocomplete="off">
            <input  type="hidden" id="recipients" value="username" >
            <!-- <input type="text" name="receiver_id" id="receiver_id" value="0"> -->
            <input type="hidden" name="to_user_id" id="to_user_id" value="0">
            <input type="hidden" name="time" id="time" >                                              
            <input type="file" name="userfile" id="user_file" class="hidden"> 
          </div>
          <a class="link btn btn-default chat-send-btn" href="javascript:void(0)" id="chat-send-btn" style="
    position: absolute;
    top: 0px;
    width: auto;
    padding: 12px;
    right: 0;
">Send</a>
        </div>
      </div>
    </form>                                                        
  </div>

  <!--Chat Box Ends-->

</div>



<?php
$currentuser = get_userdata(); 
$profile_img = '';
if(isset($currentuser['profile_img'])&&!empty($currentuser['profile_img']))
{
    $profile_img = $currentuser['profile_img'];
}  
$social_profile_img = '';
if(isset($currentuser['picture_url'])&&!empty($currentuser['picture_url']))
{
    $social_profile_img = $currentuser['picture_url'];

}  
$img1 = '';
if($social_profile_img != '')
{
    $img1 = $social_profile_img;

}
if($profile_img != '')
{
    $file_to_check = FCPATH . '/assets/images/' . $profile_img;
    if (file_exists($file_to_check)) {
        $img1 = base_url() . 'assets/images/'.$profile_img;
    }
}
$img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
?>
<input type="hidden" name="img" id="img" value="<?php echo $img; ?>"> 
<script type="text/javascript">
    function clock() {
        var time = new Date();
        time = time.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: true });
        $('#time').val(time);
        setTimeout('clock()',1000);
    }
    clock();

    $('.attach-icon').click(function(){
        $('#user_file').click();
    });
</script>  

