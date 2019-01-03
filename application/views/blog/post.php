<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Section: main -->
<section id="main">
    <div class="container">
        <div class="row">
            <!-- breadcrumb -->
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url(); ?>"> <?php echo html_escape(trans("home")); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo html_escape($post->title); ?></li>
                </ol>
            </div>

            <div class="col-sm-12 col-md-8">
                <div class="content">

                    <div class="post-content">
                        <div class="post-image">

                            <?php if ($post_image_count > 0) : ?>
                                <!-- owl-carousel -->
                                <div class="owl-carousel post-detail-slider" id="post-detail-slider">
                                    <div class="post-detail-slider-item" style="position: relative">
                                        <img src="<?php echo base_url() . $post->image_big; ?>"
                                             alt="<?php echo html_escape($post->title); ?>" class="img-responsive"/>
                                    </div>
                                    <!--List  random slider posts-->
                                    <?php foreach ($post_images as $image): ?>
                                        <!-- slider item -->
                                        <div class="ramdom-slider-item">
                                            <img src="<?php echo base_url() . $image->image_path; ?>"
                                                 alt="<?php echo html_escape($post->title); ?>"
                                                 class="img-responsive"/>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            <?php else: ?>
                                <?php if (!empty($post->image_big)): ?>
                                    <img src="<?php echo base_url() . html_escape($post->image_big); ?>"
                                         class="img-responsive center-image"
                                         alt="<?php echo html_escape($post->title); ?>"/>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="post-title">
                            <h1 class="title"><?php echo html_escape($post->title); ?></h1>
                        </div>
                         <?php 
            $currentuser = get_userdata_by_id($post->email);
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
            

                        <div class="post-meta">
                            <a href="#">
                              
                                    <img src="<?php echo $img; ?>" alt="<?php echo html_escape($post->username); ?>" class="post-avatar">
                               
                                <?php echo html_escape($post->username); ?>
                            </a>
                            <?php $post_category = get_post_category($post); ?>

                            <a href="<?php echo base_url(); ?>category/<?php echo html_escape($post_category['slug']); ?>" class="font-weight-normal">
                                <i class="fa fa-folder"></i> <?php echo html_escape($post_category['name']); ?>
                            </a>
                            <span><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?php echo helper_date_format($post->created_at); ?></span>

                            <?php if ($settings->comment_system == 1) : ?>
                                <span><i class="fa fa-comments"></i>&nbsp;&nbsp;&nbsp;<?php echo helper_get_comment_count($post->id); ?> </span>
                            <?php endif; ?>

                            <!--Show if enabled-->
                            <?php if ($settings->show_pageviews == 1) : ?>
                                <span>
                                        <i class="fa fa-eye"></i>&nbsp;
                                    <?php echo $post->hit; ?>
                                    </span>
                            <?php endif; ?>


                            <!--Add to Reading List-->
                            <?php if($this->session->userdata('role')!=0){ if (auth_check()) : ?>
                                <?php if ($is_reading_list == false) : ?>

                                    <?php echo form_open('home/add_delete_from_reading_list_post'); ?>
                                    <input type="hidden" name="post_id" value="<?php echo $post->id; ?>">

                                    <button type="submit" class="add-to-reading-list pull-right">
                                        <i class="fa fa-plus-circle"></i>&nbsp;<?php echo html_escape(trans("add_reading_list")); ?>
                                    </button>
                                    <?php echo form_close(); ?>

                                <?php else: ?>

                                    <!--Remove from Reading List-->
                                    <?php echo form_open('home/add_delete_from_reading_list_post'); ?>
                                    <input type="hidden" name="post_id" value="<?php echo $post->id; ?>">

                                    <button type="submit" class="delete-from-reading-list  pull-right">
                                        <i class="fa fa-minus-circle"></i>&nbsp;
                                        <?php echo html_escape(trans("delete_reading_list")); ?>
                                    </button>
                                    <?php echo form_close(); ?>

                                <?php endif; ?>

                            <?php else: ?>

                                <a href="<?php echo base_url(); ?>login" class="add-to-reading-list pull-right">
                                    <i class="fa fa-plus-circle"></i>&nbsp;<?php echo html_escape(trans("add_reading_list")); ?>
                                </a>

                            <?php endif; } ?>
                        </div>

                        <?php $this->load->view("blog/partials/_ad_spaces", ["ad_space" => "post_top"]); ?>

                        <div class="post-text text-style">

                            <?php echo $post->content; ?>

                            <?php if (!empty($post->optional_url)) : ?>
                                <br>
                                <a href="<?php echo html_escape($post->optional_url); ?>"
                                   class="btn btn-success btn-action margin-bottom15 btn-optional-link"
                                   target="_blank"><?php echo html_escape($settings->optional_url_button_name); ?></a>
                            <?php endif; ?>
                        </div>
                        <div class="post-tags">
                            <h2 class="tags-title"><?php echo html_escape(trans("tags")); ?></h2>
                            <ul class="tag-list">
                                <?php foreach ($post_tags as $tag) : ?>
                                    <li>
                                        <a href="<?php echo base_url() . 'tag/' . html_escape($tag->tag_slug); ?>">
                                            <?php echo html_escape($tag->tag); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="post-share hidden">
                            <a href="javascript:void(0)"
                               onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url(); ?>post/<?php echo html_escape($post->title_slug); ?>', 'Share This Post', 'width=640,height=450');return false"
                               class="btn-share share facebook">
                                <i class="fa fa-facebook"></i>
                                <span class="hidden-sm">Facebook</span>
                            </a>

                            <a href="javascript:void(0)"
                               onclick="window.open('https://twitter.com/share?url=<?php echo base_url(); ?>post/<?php echo html_escape($post->title_slug); ?>&amp;text=<?php echo html_escape($post->title); ?>', 'Share This Post', 'width=640,height=450');return false"
                               class="btn-share share twitter">
                                <i class="fa fa-twitter"></i>
                                <span class="hidden-sm">Twitter</span>
                            </a>

                            <a href="javascript:void(0)"
                               onclick="window.open('https://plus.google.com/share?url=<?php echo base_url(); ?>post/<?php echo html_escape($post->title_slug); ?>', 'Share This Post', 'width=640,height=450');return false"
                               class="btn-share share gplus">
                                <i class="fa fa-google-plus"></i>
                                <span class="hidden-sm">Google</span>
                            </a>

                            <a href="javascript:void(0)"
                               onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo base_url(); ?>post/<?php echo html_escape($post->title_slug); ?>', 'Share This Post', 'width=640,height=450');return false"
                               class="btn-share share linkedin">
                                <i class="fa fa-linkedin"></i>
                                <span class="hidden-sm">Linkedin</span>
                            </a>

                            <a href="javascript:void(0)"
                               onclick="window.open('http://pinterest.com/pin/create/button/?url=<?php echo base_url(); ?>post/<?php echo html_escape($post->title_slug); ?>&amp;media=<?php echo base_url() . html_escape($post->image_big); ?>', 'Share This Post', 'width=640,height=450');return false"
                               class="btn-share share pinterest">
                                <i class="fa fa-pinterest"></i>
                                <span class="hidden-sm">Pinterest</span>
                            </a>

                        </div>

                        <div class="bn-bottom-post">
                            <?php $this->load->view("blog/partials/_ad_spaces", ["ad_space" => "post_bottom"]); ?>
                        </div>


                    </div><!--/post-content-->


                    <div class="related-posts">
                        <div class="related-post-title">
                            <h4 class="title"><?php echo html_escape(trans("related_posts")); ?></h4>
                        </div>
                        <div class="row related-posts-row">
                            <ul class="post-list">
                                <?php foreach ($related_posts as $item): ?>

                                    <li class="col-sm-4 col-xs-12 related-posts-col">
                                        <a href="<?php echo base_url() . 'post/' . html_escape($item->title_slug); ?>">
                                            <?php if (!empty($item->image_big)): ?>
                                                <img src="<?php echo base_url() . html_escape($item->image_slider); ?>"
                                                     class="img-responsive"
                                                     alt="<?php echo html_escape($item->title); ?>"/>
                                            <?php endif; ?>
                                        </a>
                                        <h3 class="title">
                                            <a href="<?php echo base_url() . 'post/' . html_escape($item->title_slug); ?>">
                                                <?php echo html_escape(character_limiter($item->title, 70, '...')); ?>
                                            </a>
                                        </h3>
                                    </li>

                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <?php if ($settings->comment_system == 1 || !empty($settings->facebook_comment)): ?>
                        <div class="col-sm-12 col-xs-12 section-comments">
                            <div class="row">
                                <ul class="nav nav-tabs comment-tabs">
                                    <?php if ($settings->comment_system == 1): ?>
                                        <li class="active"><a data-toggle="tab" href="#tab1"><?php echo html_escape(trans("site_comments")); ?> (<?php echo $comment_count; ?>)</a></li>
                                    <?php endif; ?>
                                    <?php if (!empty($settings->facebook_comment)): ?>
                                        <li class="<?php echo ($settings->comment_system != 1) ? 'active' : ''; ?>"><a data-toggle="tab" href="#tab2"><?php echo html_escape(trans("facebook_comments")); ?> (<span class="fb-comments-count" data-href="<?php echo current_url(); ?>">0</span>)</a></li>
                                    <?php endif; ?>
                                </ul>

                                <div class="tab-content">
                                    <div id="tab1" class="tab-pane fade <?php echo ($settings->comment_system == 1) ? 'in active' : ''; ?>">

                                        <!--Comment Box-->
                                        <div class="leave-reply">
                                            <div class="row">

                                                <div class="col-sm-12 leave-reply-body">
                                                    <div class="comment-loader-container">
                                                        <div class="loader"></div>
                                                    </div>

                                                    <?php if (auth_check()): ?>
                                                        <!-- form make comment -->
                                                        <form method="post" id="formC">
                                                            <input type="hidden" id="comment_post_id" value="<?php echo $post->id; ?>">
                                            <input type="hidden" id="comment_user_id" value="<?php echo $this->session->userdata('applicant_id'); ?>">

                                                            <div class="form-group">
                                                    <textarea class="form-control" name="comment" id="comment_text"
                                                              maxlength="999"
                                                              placeholder="<?php echo html_escape(trans("leave_reply")); ?>"></textarea>
                                                            </div>

                                                            <div class="form-group">
                                                                <button type="button" id="make-comment"
                                                                        class="btn btn-default pull-right btn-action">
                                                                    <?php echo html_escape(trans("submit")); ?>
                                                                </button>
                                                            </div>
                                                        </form><!-- form end -->
                                                    <?php else: ?>
                                                        <div class="form-group">
                                                    <textarea class="form-control" name="comment" id="comment_text"
                                                              maxlength="999"
                                                              placeholder="<?php echo html_escape(trans("comment")); ?>"></textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default pull-right btn-action" onclick="$('.comment-message').show();">
                                                                <?php echo html_escape(trans("submit")); ?>
                                                            </button>
                                                        </div>
                                                        <p class="comment-message">
                                                            <?php echo html_escape(trans("message_login_for_comment")).'  <a href="'.base_url().'login" >Click here to login</a>';
                                                                     ?>
                                                        </p>

                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="comments" id="comment-result">
                                            <?php $this->load->view('blog/partials/_comments', ['comments' => $comments, 'comment_count' => $comment_count]); ?>
                                        </div>

                                        <!--Comment loader-->
                                        <div class="col-sm-12 comment-loader">
                                            <div class="row">
                                                <img src="<?php echo base_url(); ?>blog_assets/img/loader.gif" alt="comments">
                                            </div>
                                        </div>

                                        <!--Show more comments-->
                                        <?php if ($comment_count > 5): ?>
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <a href="javascript:void(0)" class="btn btn-load-more-comments" onclick="load_more_comments('<?php echo $post->id; ?>');"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo html_escape(trans("load_more_comments")); ?></a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div id="tab2" class="tab-pane fade <?php echo ($settings->comment_system != 1) ? 'in active' : ''; ?>">
                                        <div class="fb-comments" data-href="" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

            </div>

            <div class="col-sm-12 col-md-4">
                <!--Sidebar-->
                <?php $this->load->view('blog/partials/_sidebar'); ?>
            </div><!--/col-->
        </div>
    </div>
</section>
<!-- /.Section: main -->