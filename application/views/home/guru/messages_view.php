<style>
.chat-box-message{position: relative;}
.message-area{position: absolute;top: 0;width: 100%;}
input#input_message{position: absolute;width:80%;}
.btn.chat-send-btn{border: 0;
    border-left: 1px solid #eaeaea;
    border-radius: 0;
    color: #fff;
    background: #78bd34;
    font-size: 14px;
    min-width: 100px;
    text-transform: uppercase;
    height: 65px;
    position: absolute;
    top: 0px;
    line-height: 65px;
    right: 0px;}
input#user_file{ position: absolute;
    top: 0px;
    left: 0px;
}
input[type="text"], input[type="password"], textarea, select { 
    outline: none;
}
.message-bar .attach-icon {
    color: #b0b0b0;
    display: table-cell;
    font-size: 21px;
    padding: 0 10px;
    position: absolute;
    vertical-align: middle;
    width: 30px;
    top: 20px;
    right: 120px;
}
.message-area input {
    background-color: #fff;
    border: 0 none;
    color: #555;
    display: block;
    font-size: 14px;
    height: 38px;
    margin: 10px 0;
    padding: 6px 12px 6px 12px;
}
.chat-box-right .panel-footer {
    border: 0;
    border-top: 1px solid #eaeaea;
    border-bottom: 1px solid #eaeaea;
    background-color: transparent;
    padding: 0;
    height: 65px;
    position: absolute;
    bottom: 0;
    width: 100%;
    background: #fff;
}
.chatbox-message .mCustomScrollBox{max-height:350px !important;}
.chat-box-left.opened {box-shadow: 4px 0px 15px -5px rgba(0,0,0,0.5);}
</style>
<div class="row">
    <div class="col-md-12">     <a class="chat-users btn btn-primary" href="#chatuser_window"><i aria-hidden="true" class="fa fa-user"></i> Chat Users</a>
        <div class="chatting-panel panel">
            <div class="panel-wrapper">
                <div class="panel-body p-0">
                    <div class="chat-box-wrap">
                        <div class="chat-box-left" id="chatuser_window">
                            <div>
                                <form class="chat-search">
                                    <div class="input-group">
                                        <input class="form-control" placeholder="Search" type="text" id="search_suggest" onKeyUp="searchSuggest();" name="search_suggest" autocomplete="off">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn  btn-default"><img src="<?php echo base_url();?>assets/images/search-icon.png" width="16" alt=""></button>
                                        </span>
                                    </div>
                                </form> 
                                <div class="chat-user-list slimscrollleft">
                                    <ul class="chat-list-wrap">
                                        <li class="chat-list">
                                            <div class="chat-body-left">
                                                <?php if(!empty($activity_list)): ?>
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
                                                    }elseif($chat['logged_in'] == 0){
                                                        $log_class = 'away';
                                                    }                                                   $user_id = $this->session->userdata('applicant_id');
                                                    $mentor_id = $chat['app_id'];
                                              // Getting unread counts of message 
                                                  $sql = "SELECT COUNT(c.id) as unread FROM chat c WHERE (c.recieved_id = $user_id AND c.sent_id =  $mentor_id) AND c.read_status = 0 ";
                                                $unread = $this->db->query($sql)->row()->unread;
                                                    ?>
                                                    <a  href="javascript:void(0)">
                                                        <div class="chat-data chatclick state<?php echo $chat['app_id']; ?>  " data-chat-id="<?php echo $chat['app_id']; ?>" data-username="<?php echo $chat['username']; ?>" data-name="<?php echo $chat['first_name'].' '.$chat['last_name']; ?>" data-image="<?php echo $img; ?>" data-status="<?php echo $log_class; ?>">
                                                            <img class="user-img img-circle" src="<?php echo $img; ?>" alt="user"/>
                                                            <div class="user-data" id="chatlist" data-chat-id="<?php echo $chat['app_id']; ?>" data-username="<?php echo $chat['username']; ?>"  >
                                                                <span class="name" data-chat-id="<?php echo $chat['app_id']; ?>" ><?php echo $chat['first_name']. ' '. $chat['last_name']; ?> </span> 
                                                                <span class="time text-ellipsis"></span>
                                                            </div>
                                                            <div class="status <?php echo $log_class; ?>"></div>
                                                            <div class="unread_count" style="" id="<?php echo $chat['username'] ?>" ><?php echo ($unread)?$unread:''; ?></div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </a>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="chat-data">No Mentees</div>
                                            <?php endif; ?>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="loader"></div>
                    <div class="chat-box-right">
                        <div class="panel m-b-0 hidden" id="chat_box">
                            <div class="panel-heading"> 
                                <div class="user-details">
                                    <div class="user-info pull-left openchat"></div>
                                </div>
                                <div class="pull-right chattrash">
                                    <a href="javascript:void(0)" onclick="delete_conversation();" title="Delete Chat History"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                </div>                              <div class="progress upload-progress hidden">
                                    <div class="progress-bar progress-bar-success active progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="100" aria-valuemax="100" style="width: 100%;">
                                     Uploading...  
                                    </div>
                                </div>                               
                            </div>
                            <div class="panel-body">
                                <div id="chat-box" class="chat-box slimscrollleft chatbox-message">
                                    <div class="chats"><img src="<?php echo base_url()."assets/images/loading.gif"?>" class="loading"></div>
                                </div>
                            </div>
                            <div class="panel-footer" id="chat" onsubmit="return false">
                                <form name="chat_form" id="chat_form" enctype="multipart/form-data" method="post" action="<?php echo base_url(); ?>upload/upload_files">
                                    <div class="message-bar">
                                        <div class="message-inner">
                                           <a class="link attach-icon" href="javascript:void(0)"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
                                           <div class="chat-box-message">
                                               <div class="message-area">
                                                    <input type="text" name="input_message" id="input_message" placeholder="Type message..." class="chat-input" autocomplete="off">
                                                    <input  type="hidden" id="recipients" value="username" >
                                                    <input type="hidden" name="receiver_id" id="receiver_id">
                                                    <input type="hidden" name="to_user_id" id="to_user_id">
                                                    <input type="hidden" name="time" id="time" > 
                                                    <input type="file" name="userfile" id="user_file" class="hidden">
                                                </div>
                                                    <a class="link btn btn-default chat-send-btn" href="javascript:void(0)" id="chat-send-btn">Send</a>                                                  
                                            </div>
                                        </div>
                                    </div>
                                </form>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
        <style type="text/css">     .selected{background: #5c65be;color: white !important; }
        .selected span{color: white !important;}
        .chats img.loading{position: fixed;right: 590px;top: 271px;}
        .unread_count{float:right;width: 20px;height: 20px;border-radius: 50%;font-size: 12px;color: #fff;line-height: 20px;text-align: center;background: #383f89;}        .unread_count:empty{display: none;}
        </style>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/dropzone.min.css') ?>">
        <script type="text/javascript" src="<?php echo base_url('assets/js/dropzone.min.js') ?>"></script>
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
        </script>       <!-- /Row -->