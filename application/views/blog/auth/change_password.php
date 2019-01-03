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
                        <?php echo form_open('auth/change_password_post'); ?>

                        <div class="form-group has-feedback">
                            <input type="password" name="old_password" class="form-control"
                                   placeholder="<?php echo html_escape(trans("old_password")); ?>"
                                   value="<?php echo old('old_password'); ?>" required>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                            <input type="password" name="password" class="form-control"
                                   placeholder="<?php echo html_escape(trans("password")); ?>"
                                   value="<?php echo old('password'); ?>" required>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                            <input type="password" name="password_confirmation" class="form-control"
                                   placeholder="<?php echo html_escape(trans("confirm_password")); ?>"
                                   value="<?php echo old('password_confirmation'); ?>" required>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                            <button type="submit"
                                    class="btn btn-primary btn-action pull-right"><?php echo html_escape(trans("change_password")); ?></button>
                        </div>

                        <?php echo form_close(); ?><!-- form end -->

                    </div>

                </div>

            </div>
        </div>
    </div>
</section>
<!-- /.Section: main -->
