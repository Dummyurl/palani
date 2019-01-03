<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="sidebar">

    <?php $this->load->view("blog/partials/_ad_spaces", ["ad_space" => "sidebar_top"]); ?>

    <div class="col-sm-12 col-xs-12 sidebar-widget widget-popular-posts">
        <div class="row">
            <!--Include popular posts partial-->
            <?php $this->load->view('blog/partials/_popular_posts'); ?>
        </div>
    </div>

    <?php if (count($our_picks) > 0): ?>
        <div class="col-sm-12 col-xs-12 sidebar-widget">
            <div class="row">
                <!--Include our picks partial-->
                <?php $this->load->view('blog/partials/_our_picks'); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="col-sm-12 col-xs-12 sidebar-widget">
        <div class="row">
            <!--Include categories partial-->
            <?php $this->load->view('blog/partials/_categories'); ?>
        </div>
    </div>

    <?php $this->load->view("blog/partials/_ad_spaces", ["ad_space" => "sidebar_bottom"]); ?>

    <div class="col-sm-12 col-xs-12 sidebar-widget">
        <div class="row">
            <!--Include random slider partial-->
            <?php $this->load->view('blog/partials/_random_slider'); ?>
        </div>
    </div>

    <div class="col-sm-12 col-xs-12 sidebar-widget">
        <div class="row">
            <!--Include tags partial-->
            <?php $this->load->view('blog/partials/_tags'); ?>
        </div>
    </div>

</div><!--/Sidebar-->