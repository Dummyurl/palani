<style>
.unread_count:empty{
    display: none;
}
</style>
<?php if(!empty($activity_list)): 

// echo '<pre>';
// print_r($activity_list);


?>
<?php foreach($activity_list as $chat): ?>
 <?php 
 $img1 = '';
 if($chat['picture_url'] != '')
 {
    $img1 = $chat['picture_url'];

}
if($chat['profile_img'] != '')
{
    $file_to_check = FCPATH . '/assets/images/' . $chat['profile_img'];
    if (file_exists($file_to_check)) {
        $img1 = base_url() . 'assets/images/'.$chat['profile_img'];
    }
}
$img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
if($chat['logged_in'] == 1){
    $log_class = 'online';
}elseif($activity_list['logged_in'] == 0){
    $log_class = 'away';
}

$user_id = $this->session->userdata('applicant_id');
$mentor_id = $chat['app_id'];



                                              // Getting unread counts of message 
$sql = "SELECT COUNT(c.id) as unread FROM chat c WHERE (c.recieved_id = $user_id AND c.sent_id =  $mentor_id) AND c.read_status = 0 ";

$unread = $this->db->query($sql)->row()->unread;



?>
<a  href="javascript:void(0)">
    <div class="chat-data chatclick_search state<?php echo $chat['app_id']; ?>  " data-chat-id="<?php echo $chat['app_id']; ?>" data-username="<?php echo $chat['username']; ?>" data-name="<?php echo $chat['first_name'].' '.$chat['last_name']; ?>" data-image="<?php echo $img; ?>" data-status="<?php echo $log_class; ?>">
        <img class="user-img img-circle" src="<?php echo $img; ?>" alt="user"/>
        <div class="user-data" id="chatlist" data-chat-id="<?php echo $chat['app_id']; ?>" data-username="<?php echo $chat['username']; ?>"  >
            <span class="name" data-chat-id="<?php echo $chat['app_id']; ?>" ><?php echo $chat['first_name']. ' '. $chat['last_name']; ?> </span> 
            <span class="time text-ellipsis"></span>
        </div>
        <div class="status <?php echo $log_class; ?>"></div>
        <div class="unread_count" style="" id="<?php echo $chat['username'] ?>"><?php echo ($unread)?$unread:''; ?></div>
        <div class="clearfix"></div>
    </div>
</a>
<?php endforeach; ?>
<?php else: ?>
    <div class="chat-data">No more chats</div>
<?php endif; ?>

<style type="text/css">
.selected{
    background: #5c65be;
    color: white !important; 
}
.selected span{            
    color: white !important; 
}
.chats img.loading{
    position: fixed;
    right: 590px;
    top: 271px;
}
.unread_count{
    float:right;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    font-size: 12px;
    color: #fff;
    line-height: 20px;
    text-align: center;
    background: #383f89;
}
.unread_count:empty{
    display: none;
}
</style>

<script type="text/javascript">

    function clock() {
        var time = new Date();

        time = time.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: true });
        $('#time').val(time);
        setTimeout('clock()',1000);
    }
    clock();
</script> 