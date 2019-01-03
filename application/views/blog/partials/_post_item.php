<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $post_category = get_post_category($item); ?>

<?php if ($layout == "layout_2" || $layout == "layout_5"):


echo '<pre>'; print_r($item); ?>

    <!--Post list item-->
    <div class="post-item-horizontal">

        <div class="item-image">
            <p class="label-post-category">
                <a href="<?php echo base_url(); ?>category/<?php echo html_escape($post_category['slug']); ?>">
                    <label class="label label-danger">
                        <?php echo html_escape($post_category['name']); ?>
                    </label>
                </a>
            </p>

            <a href="<?php echo base_url(); ?>post/<?php echo html_escape($item->title_slug); ?>">
                <img src="<?php echo base_url() . html_escape($item->image_slider); ?>" alt="<?php echo html_escape($item->title); ?>" class="img-responsive"/>
            </a>
        </div>

        <div class="item-content">

            <h3 class="title">
                <a href="<?php echo base_url(); ?>post/<?php echo html_escape($item->title_slug); ?>">
                    <?php echo html_escape(character_limiter($item->title, 55, '...')); ?>
                </a>
            </h3>
            <div class="post-meta">
                <a href="<?php echo base_url(); ?>profile/<?php echo html_escape($item->user_slug); ?>">
                    <?php echo html_escape($item->username); ?>
                </a>
                <span><i class="fa fa-calendar"></i>&nbsp;
                    <?php echo helper_date_format($item->created_at); ?>
                    </span>

                <?php if ($settings->comment_system == 1) : ?>
                    <span>
                        <i class="fa fa-comments"></i>&nbsp;
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
            <p class="summary">
                <?php echo html_escape(character_limiter($item->summary, 130, '...')); ?>
            </p>

            <div class="post-buttons">
                <a href="<?php echo base_url() . 'post/' . html_escape($item->title_slug); ?>"
                   class="pull-right read-more">
                    <?php echo html_escape(trans("readmore")); ?>
                    <i class="fa fa-angle-right read-more-i" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>

<?php elseif ($layout == "layout_3" || $layout == "layout_6"): ?>

    <div class="col-sm-6 col-xs-12 item-boxed-cnt">
        <!--Post list item-->
        <div class="col-xs-12 post-item-boxed p0">
            <div class="item-image">
                <p class="label-post-category">
                    <a href="<?php echo base_url(); ?>category/<?php echo html_escape($post_category['slug']); ?>; ?>">
                        <label class="label label-danger">
                            <?php echo html_escape($post_category['name']); ?>
                        </label>
                    </a>
                </p>

                <a href="<?php echo base_url(); ?>post/<?php echo html_escape($item->title_slug); ?>">
                    <img src="<?php echo base_url() . html_escape($item->image_slider); ?>" alt="<?php echo html_escape($item->title); ?>" class="img-responsive"/>
                </a>
            </div>

            <div class="item-content">

                <h3 class="title">
                    <a href="<?php echo base_url(); ?>post/<?php echo html_escape($item->title_slug); ?>">
                        <?php echo html_escape(character_limiter($item->title, 40, '...')); ?>
                    </a>
                </h3>
                <div class="post-meta">
                    <a href="<?php echo base_url(); ?>profile/<?php echo html_escape($item->user_slug); ?>">
                        <?php echo html_escape($item->username); ?>
                    </a>
                    <span><i class="fa fa-calendar"></i>&nbsp;
                        <?php echo helper_date_format($item->created_at); ?>
                    </span>

                    <?php if ($settings->comment_system == 1) : ?>
                        <span>
                        <i class="fa fa-comments"></i>&nbsp;
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
                <p class="summary">
                    <?php echo html_escape(character_limiter($item->summary, 130, '...')); ?>
                </p>

                <div class="post-buttons">
                    <a href="<?php echo base_url() . 'post/' . html_escape($item->title_slug); ?>"
                       class="pull-right read-more">
                        <?php echo html_escape(trans("readmore")); ?>
                        <i class="fa fa-angle-right read-more-i" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>

    <!--post list item-->
    <div class="col-sm-12 post-item">
        <div class="row">
            <div class="post-image">
                <a href="<?php echo base_url() . 'post/' . html_escape($item->title_slug); ?>">
                    <?php if (!empty($item->image_mid)): ?>
                        <img src="<?php echo base_url() . html_escape($item->image_mid); ?>" class="img-responsive"
                             alt="<?php echo html_escape($item->title); ?>"/>
                    <?php endif; ?>
                </a>
            </div>

            <div class="post-footer">
                <div class="text-center">
                    <!--if related category exists-->
                    <p class="label-post-category">
                        <a href="<?php echo base_url(); ?>category/<?php echo html_escape($post_category['slug']); ?>"
                           class="a-slider-category">
                            <label class="label label-danger cursor-pointer">
                                <?php echo html_escape($post_category['name']); ?>
                            </label>
                        </a>
                    </p>
                    <h3 class="title">
                        <a href="<?php echo base_url() . 'post/' . html_escape($item->title_slug); ?>">
                            <?php echo html_escape($item->title); ?>
                        </a>
                    </h3>
                    <div class="post-meta">
                        <a href="<?php echo base_url(); ?>profile/<?php echo html_escape($item->user_slug); ?>">
                            <?php echo html_escape($item->username); ?>
                        </a>
                        <span><i class="fa fa-calendar"></i>&nbsp;
                            <?php echo helper_date_format($item->created_at); ?>
                    </span>

                        <?php if ($settings->comment_system == 1) : ?>
                            <span>
                        <i class="fa fa-comments"></i>&nbsp;
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
                </div>
                <p class="summary text-center">
                    <?php echo html_escape($item->summary); ?>
                </p>

                <div class="post-buttons">
                    <a href="<?php echo base_url() . 'post/' . html_escape($item->title_slug); ?>"
                       class="pull-right read-more">
                        <?php echo html_escape(trans("readmore")); ?>
                        <i class="fa fa-angle-right read-more-i" aria-hidden="true"></i>
                    </a>
                </div>

            </div><!-- /.post footer -->
        </div><!-- /.row -->
    </div>

<?php endif; ?>




