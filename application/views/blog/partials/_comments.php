<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12 comments-body">
        <ul class="comment-lists">

            <?php foreach ($comments as $item) : ?>
                <?php //if (!is_null(get_user($item->user_id))) : ?>
                    <li>
                        <div class="row m0">
                            <div class="col-sm-1 col-xs-1 comment-left p0">


                             <?php 
                             $currentuser = get_userdata_by_id($item->email);
                             $profile_img = '';
                             $social_profile_img = '';
                             if(isset($currentuser['profile_img'])&&!empty($currentuser['profile_img'])){
                                $profile_img = $currentuser['profile_img'];
                            }                           
                            if(isset($currentuser['picture_url'])&&!empty($currentuser['picture_url'])){
                                $social_profile_img = $currentuser['picture_url'];
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
                            $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png'; ?>                          
                            <img src="<?php echo  $img; ?>"
                            alt="user" class="img-responsive">
                        </div><!--/comment-left -->

                        <div class="col-sm-11 col-xs-11 comment-right">
                            <h5 class="user-name"><?php echo html_escape($item->first_name.' '.$item->last_name); ?></h5>
                            <p class="comment-text"><?php echo html_escape($item->comment); ?></p>
                            <div class="comment-meta">
                                <small class="comment-date"><?php echo helper_comment_date_format($item->created_at); ?></small>

                                <!--Check login-->
                                <?php if (auth_check()): ?>
                                    <button class="btn-comment-reply"
                                    onclick="return showSubCommentBox('<?php echo $item->id; ?>');">
                                    <i class="fa fa-reply"></i>&nbsp;<?php echo html_escape(trans("reply")); ?>
                                </button>

                                <?php if (user()->id == $item->user_id): ?>
                                    <button type="button"
                                    onclick="deleteComment('<?php echo html_escape(trans("warning")); ?>',
                                        '<?php echo html_escape(trans("confirm_comment")); ?>',
                                        '<?php echo $item->id; ?>' );"
                                        class="btn-comment-delete">
                                        <i class="fa fa-trash"></i>&nbsp;<?php echo html_escape(trans("delete")); ?>
                                    </button>
                                <?php //endif; ?>
                            <?php endif; ?>
                        </div>


                        <!-- make sub comment block -->
                        <div id="sub_comment_<?php echo $item->id; ?>"
                         class="col-sm-12 leave-reply-body leave-reply-sub-body">
                         <div class="row">
                            <div class="sub-comment-loader-container">
                                <div class="loader"></div>
                            </div>
                            <!-- form make  sub comment -->
                            <form method="post">
                                <input type="hidden" id="comment_parent_id_<?php echo $item->id; ?>"
                                value="<?php echo $item->id; ?>">
                                <div class="form-group">
                                    <textarea class="form-control" name="comment" id="comment_text_<?php echo $item->id; ?>"
                                      placeholder="<?php echo html_escape(trans("comment")); ?>"
                                      maxlength="999"></textarea>
                                  </div>
                                  <div class="form-group">
                                    <button type="button" onclick="return makeSubComment('<?php echo $item->id; ?>')"
                                        class="btn btn-default pull-right btn-action">
                                        <?php echo html_escape(trans("submit")); ?>
                                    </button>
                                </div>

                            </form><!-- form end -->
                        </div>
                    </div> <!--/make sub comment block -->


                    <!--Print sub comments-->
                    <?php foreach (helper_get_subcomments($item->id) as $sub_comment) : ?>
                        <?php // if (!is_null(get_user($sub_comment->user_id))): ?>
                            <div class="row m0 item-sub-comment">

                                <div class="col-sm-1 col-xs-1 p0 comment-left">

                                   <?php 
                                   $currentuser = get_userdata_by_id($sub_comment->email);
                                   $profile_img = '';
                                   $social_profile_img = '';
                                   if(isset($currentuser['profile_img'])&&!empty($currentuser['profile_img'])){
                                    $profile_img = $currentuser['profile_img'];
                                }                           
                                if(isset($currentuser['picture_url'])&&!empty($currentuser['picture_url'])){
                                    $social_profile_img = $currentuser['picture_url'];
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
                                $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png'; ?>

                                <img src="<?php echo $img; ?>"
                                alt="user" class="img-responsive">

                            </div><!--/comment-left -->


                            <div class="col-sm-11 col-xs-11 comment-right">
                                <h5 class="user-name"><?php echo html_escape($sub_comment->first_name.' '.$sub_comment->last_name); ?></h5>
                                <p class="comment-text"><?php echo html_escape($sub_comment->comment); ?></p>
                                <div class="comment-meta">
                                    <small class="comment-date"><?php echo helper_comment_date_format($sub_comment->created_at); ?></small>

                                    <?php if (auth_check()): ?>
                                        <?php if (user()->id == $sub_comment->user_id): ?>
                                            <button type="button"
                                            onclick="deleteComment('<?php echo html_escape(trans("warning")); ?>',
                                                '<?php echo html_escape(trans("confirm_comment")); ?>',
                                                '<?php echo $sub_comment->id; ?>' );"
                                                class="btn-comment-delete">
                                                <i class="fa fa-trash"></i>&nbsp;<?php echo html_escape(trans("delete")); ?>
                                            </button>
                                        <?php // endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div><!--/comment-right -->

                        </div><!--/row -->
                    <?php endif; ?>
                <?php endforeach; ?>
            </div><!--/item-sub-comment -->


        </div><!--/row -->
    </li>
<?php endif; ?>
<?php endforeach; ?>
</ul>

</div>
</div>

<?php if (isset($visible_comment_count)): ?>
    <input type="hidden" id="visible_comment_count" value="<?php echo $visible_comment_count; ?>">

    <?php if ($visible_comment_count >= $comment_count): ?>
        <style>
        .btn-load-more-comments {
            display: none;
        }
    </style>
<?php endif; ?>

<?php else: ?>
    <input type="hidden" id="visible_comment_count" value="5">
<?php endif; ?>




