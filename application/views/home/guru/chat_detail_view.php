<div class="panel m-b-0">
                <div class="panel-heading"> 
                <div class="user-details">
                <div class="user-info pull-left openchat<?php echo $receiver['receiver_id']; ?>">
                 <a href="#">
                    <?php echo $receiver['chat_name']; ?> <span class="status online"></span>
                </a>
                </div>
                </div>
                            <ul class="user-menu nav navbar-nav navbar-right pull-right">
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><img src="<?php echo base_url();?>assets/images/menu.png" alt=""></a>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)" onclick="delete_conversation(<?php echo $receiver['receiver_id']; ?>);">Delete Conversations</a></li>
                            <li><a href="javascript:void(0)">Settings</a></li>
                        </ul>
                    </li>
                </ul>
                </div>
                <div class="panel-body">
                <div id="chat-box" class="chat-box slimscrollleft">
                <div class="chats">
                <?php foreach($latest_chat as $key => $currentuser) :  //print_r($currentuser); ?>
                   
                <div class="chat <?php echo ($currentuser['sender_id'] != $this->session->userdata('applicant_id')) ? 'chat-left' : '';?>">
                    <div class="chat-avatar">
                    <a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="June Lane">
                   <img alt="June Lane" src="<?php 

                    if($currentuser['senderImage']!=''){
                        $img =  base_url().'assets/images/'.$currentuser['senderImage'];
                    }elseif($currentuser['socialImage']!=''){
                          $img = $currentuser['socialImage'];
                    }else{
                        $img = base_url().'assets/images/default-avatar.png';
                    }

                    echo $img; ?>" class="img-responsive img-circle">
                    </a>
                    </div>
                    <div class="chat-body">
                    <div class="chat-content">
                    <p>
                    <?php echo $currentuser['msg']; ?>
                    </p>
                    <span class="chat-time"><?php echo date('h:i a',strtotime($currentuser['chatdate'])); ?></span>
                    </div>
                    </div>
                </div>
                <?php endforeach;?>
                </div>
                </div>
                </div>
                <div class="panel-footer" id="chat">
                <form id="newRecipient">
                    <input  type="hidden" id="recipients" value="<?php echo $receiver['username']; ?>" >
                </form>
                <form name="chat_form" id="chat_form">
                 <div class="message-bar">
                        <div class="message-inner">
                                <div class="message-area">
                                        <input type="hidden" name="receiver_id" id="receiver_id" value="<?php echo $receiver['receiver_id']; ?>">
                                        <input type="text" name="input_message" id="input_message" placeholder="Type message..." class="chat-input" autocomplete="off">
                                </div>
                                <a class="link btn btn-default chat-send-btn" href="javascript:void(0)" id="chat-send-btn">
                                        Send
                                </a>
                        </div>
                    </div>
                     </form>
                </div>
</div>