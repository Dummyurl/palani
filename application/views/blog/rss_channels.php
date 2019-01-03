<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="main">
    <div class="container">
        <div class="row">
            <?php if ($page->breadcrumb_active == 1): ?>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url(); ?>"><?php echo html_escape(trans("home")); ?></a>
                        </li>
                        <li class="breadcrumb-item active"><?php echo html_escape($page->title); ?></li>
                    </ol>
                </div>
            <?php else: ?>
                <div class="page-breadcrumb m-t-45">
                </div>
            <?php endif; ?>

            <div id="content" class="col-sm-12">
                <div class="row">
                    <!--Check page title active-->
                    <?php if ($page->title_active == 1): ?>
                        <div class="col-sm-12">
                            <h1 class="page-title"><?php echo html_escape($page->title); ?></h1>
                        </div>
                    <?php endif; ?>
                    <div class="col-sm-12">
                        <div class="page-content font-text page-rss">
                            <div class="rss-item">
                                <div class="left">
                                    <a href="<?php echo base_url(); ?>rss/posts" target="_blank"><i class="fa fa-rss"></i>&nbsp;&nbsp;<?php echo trans("all_posts"); ?></a>
                                </div>
                                <div class="right">
                                    <p><?php echo base_url() . "rss/posts"; ?></p>
                                </div>
                            </div>

                            <div class="rss-item">
                                <div class="left">
                                    <a href="<?php echo base_url(); ?>rss/popular-posts" target="_blank"><i class="fa fa-rss"></i>&nbsp;&nbsp;<?php echo trans("popular_posts"); ?></a>
                                </div>
                                <div class="right">
                                    <p><?php echo base_url() . "rss/popular-posts"; ?></p>
                                </div>
                            </div>

                            <?php foreach ($categories as $category): ?>
                                <div class="rss-item">
                                    <div class="left">
                                        <a href="<?php echo base_url(); ?>rss/category/<?php echo html_escape($category->slug); ?>" target="_blank"><i class="fa fa-rss"></i>&nbsp;&nbsp;<?php echo html_escape($category->name); ?></a>
                                    </div>
                                    <div class="right">
                                        <p><?php echo base_url(); ?>rss/category/<?php echo html_escape($category->slug); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <div class="rss-content text-style">
                                <?php echo $page->page_content; ?>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


</div>