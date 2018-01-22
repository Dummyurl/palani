<div class="row">
<div class="col-md-12">
        <div class="chatting-panel panel">
<div class="panel-wrapper">
        <div class="panel-body p-0">
                <div class="chat-box-wrap">
                        <div class="chat-box-left">
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
     ?>
                                <a  href="javascript:void(0)">
                                        <div class="chat-data chatclick state<?php echo $chat['app_id']; ?>" data-chat-id="<?php echo $chat['app_id']; ?>">
                                                <img class="user-img img-circle" src="<?php echo $img; ?>" alt="user"/>
                                                <div class="user-data" id="chatlist" data-chat-id="<?php echo $chat['app_id']; ?>">
                                                        <span class="name" data-chat-id="<?php echo $chat['app_id']; ?>"><?php echo $chat['first_name']. ' '. $chat['last_name']; ?></span>
                                                        <span class="time text-ellipsis"></span>
                                                </div>
                                                <div class="status away"></div>
                                                <div class="unread_count<?php echo $chat['app_id']; ?>" style="float:right; width: 20px;height: 20px;border-radius: 50%;font-size: 12px;color: #fff;line-height: 20px;text-align: center;background: #383f89;display:none;"></div>
                                                <div class="clearfix"></div>
                                        </div>
                                </a>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <div class="chat-data">No more chats</div>
                            <?php endif; ?>
                        </div>
                </li>
        </ul>
</div>
                                </div>
    </div>
                                        <div class="chat-box-right">
                                       <p style="text-align: center;margin-top:100px;font-size:50px;color:#474fa5;"><b><i class="fa fa-comments"></i></b></p>      
                                        </div>
                                            </div>
                                    </div>
                            </div>
                    </div>


            </div>
    </div>
				<!-- /Row -->