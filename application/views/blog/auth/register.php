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
                    </ol>
                </div>
            <?php else: ?>
                <div class="page-breadcrumb m-t-45">
                </div>
            <?php endif; ?>

            <div class="page-content">
                <div class="col-xs-12 col-sm-6 col-md-4 center-box">
                    <div class="content page-contact page-login">

                        <h1 class="page-title text-center"><?php echo html_escape($page->title); ?></h1>

                        <!-- include message block -->
                        <?php $this->load->view('blog/partials/_messages'); ?>

                        <!-- form start -->
                        <?php echo form_open('auth/register_post', array('onsubmit' => "if (!checkCaptcha($('#captcha-input').val())) { $('#captcha-input').addClass('has-error'); return false };")); ?>

                        <div class="form-group has-feedback">
                            <input type="text" name="username" class="form-control"
                                   placeholder="<?php echo html_escape(trans("username")); ?>"
                                   value="<?php echo html_escape($this->session->flashdata('form_data')['username']); ?>" required>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                            <input type="email" name="email" class="form-control"
                                   placeholder="<?php echo html_escape(trans("email")); ?>"
                                   value="<?php echo html_escape($this->session->flashdata('form_data')['email']); ?>" required>
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                            <input type="password" name="password" class="form-control"
                                   placeholder="<?php echo html_escape(trans("password")); ?>"
                                   value="<?php echo html_escape($this->session->flashdata('form_data')['password']); ?>" required>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                            <input type="password" name="confirm_password" class="form-control"
                                   placeholder="<?php echo html_escape(trans("confirm_password")); ?>" required>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback text-center captcha-cnt">
                            <a class="captcha-refresh" onclick="refreshCaptcha();"><i class="fa fa-refresh"></i></a>
                            <img id='imageCaptcha' alt="">
                        </div>

                        <div class="col-sm-12 p0 form-group has-feedback m0">
                            <input type="text" id="captcha-input" class="form-control pull-right"
                                   placeholder="<?php echo html_escape(trans("captcha")); ?>" required>
                        </div>
                        <div class="col-sm-12 p0 form-group has-feedback">
                            <button type="submit" class="btn btn-primary btn-action pull-right margin-top-15">
                                <?php echo html_escape(trans("register")); ?>
                            </button>
                        </div>

                        <?php echo form_close(); ?><!-- form end -->

                    </div>

                </div>

            </div>
        </div>
    </div>
</section>
<!-- /.Section: main -->

