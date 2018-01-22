<?php foreach($latest_chat as $key => $currentuser) :  ?>
                <div class="chat <?php echo ($currentuser['sender_id'] != $this->session->userdata('applicant_id')) ? 'chat-left' : '';?>">
                    <div class="chat-avatar">
                    <a title="" data-placement="right" href="#" data-toggle="tooltip" class="avatar" data-original-title="<?php echo $currentuser['username']; ?>">
                    <img alt="Guru" src="<?php echo ($currentuser['senderImage'] != '') ? base_url().'assets/images/'.$currentuser['senderImage']: base_url().'assets/images/avatar.png'; ?>" class="img-responsive img-circle">
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
<?php endforeach; ?>