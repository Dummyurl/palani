<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--Partial: Popular Posts-->
<div class="widget-title widget-popular-posts-title">
    <h4 class="title"><?php echo html_escape(trans("popular_posts")); ?></h4>
</div>

<div class="col-sm-12 widget-body">
    <div class="row">
        <ul class="widget-list w-popular-list">

            <!--List  popular posts-->
            <?php foreach ($popular_posts as $item): ?>
                <li>
                    <a href="<?php echo base_url() . 'post/' . html_escape($item->title_slug); ?>">
                        <?php if (!empty($item->image_small)): ?>
                            <img src="<?php echo base_url() . $item->image_small; ?>"
                                 alt="<?php echo html_escape($item->title); ?>" class="img-popular"/>
                        <?php endif; ?>
                        <?php if (!empty($item->image_slider)): ?>
                            <img src="<?php echo base_url() . $item->image_slider; ?>"
                                 alt="<?php echo html_escape($item->title); ?>" class="img-popular-mobile"/>
                        <?php endif; ?>

                    </a>
                    <h3 class="title">
                        <a href="<?php echo base_url() . 'post/' . html_escape($item->title_slug); ?>">
                            <?php echo html_escape(character_limiter($item->title, 55, '...')); ?>
                        </a>
                    </h3>
                    <?php 

                            if($this->session->userdata('inf_ses_role') == 'admin'){
                                     $new_link ='#';
                                 
                            }
                            elseif($this->session->userdata('inf_ses_id') == $item->user_id){
                                     $new_link = base_url().'user/profile';
                                 
                            }else{
                                $this->db->select('a.username');
                            $this->db->where('u.id',$item->user_id);
                            $this->db->join('applicants a','a.email = u.email');
                            $result = $this->db->get('users u')->row();
                            $new_link = base_url().'mentor-profile/'.html_escape($result->username);
                            }

                           

                     ?>
                    <div class="w-meta">
                        <a href="<?php echo $new_link; ?>">
                            <?php  echo html_escape($item->username); ?>
                        </a>
                        <span><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?php echo helper_date_format($item->created_at); ?></span>

                        <?php if ($settings->comment_system == 1) : ?>
                            <span><i class="fa fa-comments"></i>&nbsp;
                                <?php echo helper_get_comment_count($item->id); ?>
                         </span>
                        <?php endif; ?>

                        <!--Show if enabled-->
                        <?php if ($settings->show_pageviews == 1) : ?>
                            <span><i class="fa fa-eye"></i>&nbsp;
                                <?php echo $item->hit; ?>
                            </span>
                        <?php endif; ?>
                    </div>

                </li>
            <?php endforeach; ?>

        </ul>
    </div>
</div>