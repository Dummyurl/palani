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
                        <?php echo form_open_multipart('auth/update_profile_post'); ?>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="row">
                                    <?php if (!empty(user()->avatar)) : ?>
                                        <img src="<?php echo base_url() . user()->avatar; ?>" alt="avatar"
                                             class="thumbnail img-responsive img-update">
                                    <?php else : ?>
                                        <img src="<?php echo base_url(); ?>blog_assets/img/user.png" alt="avatar"
                                             class="thumbnail img-responsive img-update">
                                    <?php endif; ?>
                                </div>
                                <div class="row text-center btn-change-avatar">
                                    <a class='btn btn-success btn-sm position-relative'>
                                        <?php echo html_escape(trans("change_avatar")); ?>
                                        <input type="file" name="file" size="40" class="uploadFile"
                                               accept=".png, .jpg, .jpeg"
                                               onchange="$('#upload-file-info').html($(this).val());">
                                    </a>
                                </div>
                                <div class="row text-center btn-change-file">
                                    <p class='label label-info' id="upload-file-info"></p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group has-feedback col-sm-12">
                            <div class="row">
                                <input type="text" name="username" class="form-control"
                                       placeholder="<?php echo html_escape(trans("username")); ?>"
                                       value="<?php echo html_escape(user()->username); ?>" readonly>
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                        </div>

                        <?php if (is_admin() || is_author()): ?>
                            <div class="form-group has-feedback col-sm-12">
                                <div class="row">
                                    <input type="text" name="slug" class="form-control"
                                           placeholder="<?php echo html_escape(trans("slug")); ?>"
                                           value="<?php echo html_escape(user()->slug); ?>" required>
                                    <span class="glyphicon glyphicon-link form-control-feedback"></span>
                                </div>
                            </div>
                        <?php else: ?>
                            <input type="hidden" name="slug" value="<?php echo html_escape(user()->slug); ?>">
                        <?php endif; ?>

                        <div class="form-group has-feedback col-sm-12">
                            <div class="row">
                                <input type="email" name="email" class="form-control"
                                       placeholder="<?php echo html_escape(trans("email")); ?>"
                                       value="<?php echo html_escape(user()->email); ?>" required>
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <button type="submit" class="btn btn-primary btn-action pull-right">
                                <?php echo html_escape(trans("save_changes")); ?>
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

