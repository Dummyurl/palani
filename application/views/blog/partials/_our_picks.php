<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--Partial: Popular Posts-->
<div class="widget-title widget-popular-posts-title">
    <h4 class="title"><?php echo html_escape(trans("our_picks")); ?></h4>
</div>

<div class="col-sm-12 widget-body">
    <div class="row">
        <ul class="widget-list w-our-picks-list">

            <!--List  popular posts-->
            <?php foreach ($our_picks as $item): ?>
                <li>
                    <?php $post_category = get_post_category($item); ?>
                    <div class="post-image">
                        <p class="label-post-category">
                            <a href="<?php echo base_url(); ?>category/<?php echo html_escape($post_category['slug']); ?>">
                                <label class="label label-danger">
                                    <?php echo html_escape($post_category['name']); ?>
                                </label>
                            </a>
                        </p>

                        <a href="<?php echo base_url() . 'post/' . html_escape($item->title_slug); ?>">
                            <img src="<?php echo base_url() . $item->image_mid; ?>"
                                 alt="<?php echo html_escape($item->title); ?>"/>
                        </a>
                    </div>

                    <h3 class="title">
                        <a href="<?php echo base_url() . 'post/' . html_escape($item->title_slug); ?>">
                            <?php echo html_escape(character_limiter($item->title, 55, '...')); ?>
                        </a>
                    </h3>

                </li>
            <?php endforeach; ?>

        </ul>
    </div>
</div>