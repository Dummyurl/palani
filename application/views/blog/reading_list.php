<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Section: main -->
<section id="main">
    <div class="container">
        <div class="row">
            <!-- breadcrumb -->
            <?php if ($page->breadcrumb_active == 1): ?>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url(); ?>"><?php echo html_escape(trans("home")); ?></a>
                        </li>
                        <li class="breadcrumb-item active"><?php echo html_escape($page->title); ?></li>
                        </li>
                    </ol>
                </div>
            <?php else: ?>
                <div class="page-breadcrumb m-t-45">
                </div>
            <?php endif; ?>


            <div class="page-content">
                <div class="col-xs-12 col-sm-12 col-md-8">

                    <div class="content">
                        <?php if ($page->title_active == 1): ?>
                            <h1 class="page-title"><?php echo html_escape($page->title); ?></h1>
                        <?php endif; ?>


                        <!-- posts -->
                        <div class="col-xs-12 col-sm-12 posts <?php echo ($layout == "layout_3" || $layout == "layout_6") ? 'p-0 posts-boxed' : ''; ?>">
                            <div class="row">
                                <?php $count = 0; ?>

                                <?php foreach ($posts as $item) : ?>

                                    <?php if ($count != 0 && $count % 2 == 0): ?>
                                        <div class="col-sm-12 col-xs-12"></div>
                                    <?php endif; ?>

                                    <!-- post item -->
                                    <?php $this->load->view('blog/partials/_post_item', ['item' => $item]); ?>
                                    <!-- /.post item -->

                                    <?php if ($count == 1): ?>

                                        <?php $this->load->view("blog/partials/_ad_spaces", ["ad_space" => "reading_list_top"]); ?>

                                    <?php endif; ?>

                                    <?php $count++; ?>

                                <?php endforeach; ?>

                                <?php if ($post_count < 1): ?>
                                    <p class="text-center"><?php echo html_escape(trans("reading_list_empty")); ?></p>
                                <?php endif; ?>
                            </div><!-- /.posts -->
                        </div>

                        <div class="col-xs-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <?php $this->load->view("blog/partials/_ad_spaces", ["ad_space" => "reading_list_bottom"]); ?>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="col-xs-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <?php echo $this->pagination->create_links(); ?>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-xs-12 col-sm-12 col-md-4">
                    <!--Sidebar-->
                    <?php $this->load->view('blog/partials/_sidebar'); ?>
                </div><!--/col-->

            </div>
        </div>
    </div>
</section>
<!-- /.Section: main -->

