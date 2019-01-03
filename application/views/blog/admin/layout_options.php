<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('layout_options'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('admin/layout_options_post'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('blog/admin/_messages'); ?>

                <div class="row m-b-15">
                    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 layout-item">
                        <div class="col-sm-12 text-center m-b-15">
                            <input type="radio" name="layout" value="layout_1" class="flat-orange" <?php echo ($settings->layout == 'layout_1') ? 'checked' : ''; ?> >
                        </div>
                        <img src="<?php echo base_url(); ?>blog_assets/admin/img/layout_1.jpg" alt="" class="img-responsive">
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 layout-item">
                        <div class="col-sm-12 text-center m-b-15">
                            <input type="radio" name="layout" value="layout_2" class="flat-orange" <?php echo ($settings->layout == 'layout_2') ? 'checked' : ''; ?>>
                        </div>
                        <img src="<?php echo base_url(); ?>blog_assets/admin/img/layout_2.jpg" alt="" class="img-responsive">
                    </div>

                    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 layout-item">
                        <div class="col-sm-12 text-center m-b-15">
                            <input type="radio" name="layout" value="layout_3" class="flat-orange" <?php echo ($settings->layout == 'layout_3') ? 'checked' : ''; ?>>
                        </div>
                        <img src="<?php echo base_url(); ?>blog_assets/admin/img/layout_3.jpg" alt="" class="img-responsive">
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 layout-item">
                        <div class="col-sm-12 text-center m-b-15">
                            <input type="radio" name="layout" value="layout_4" class="flat-orange" <?php echo ($settings->layout == 'layout_4') ? 'checked' : ''; ?>>
                        </div>
                        <img src="<?php echo base_url(); ?>blog_assets/admin/img/layout_4.jpg" alt="" class="img-responsive">
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 layout-item">
                        <div class="col-sm-12 text-center m-b-15">
                            <input type="radio" name="layout" value="layout_5" class="flat-orange" <?php echo ($settings->layout == 'layout_5') ? 'checked' : ''; ?>>
                        </div>
                        <img src="<?php echo base_url(); ?>blog_assets/admin/img/layout_5.jpg" alt="" class="img-responsive">
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 layout-item">
                        <div class="col-sm-12 text-center m-b-15">
                            <input type="radio" name="layout" value="layout_6" class="flat-orange" <?php echo ($settings->layout == 'layout_6') ? 'checked' : ''; ?>>
                        </div>
                        <img src="<?php echo base_url(); ?>blog_assets/admin/img/layout_6.jpg" alt="" class="img-responsive">
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
</div>


