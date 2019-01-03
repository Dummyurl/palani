<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-5 col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("update_category"); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_category/update_gallery_category_post'); ?>

            <input type="hidden" name="category_id" value="<?php echo html_escape($category->id); ?>">

            <div class="box-body">
                <?php $this->load->view('blog/admin/_messages'); ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans("category_name"); ?></label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="<?php echo trans("category_name"); ?>"
                           value="<?php echo html_escape($category->name); ?>" maxlength="200" required>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans("save_changes"); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
</div>
