<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-5 col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("update_category"); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_category/update_category_post'); ?>

            <input type="hidden" name="category_id" value="<?php echo html_escape($category->id); ?>">
            <input type="hidden" name="redirect_url" value="<?php echo html_escape($this->input->get('redirect_url')); ?>">

            <div class="box-body">
                <?php $this->load->view('blog/admin/_messages'); ?>

                <div class="form-group">
                    <label><?php echo trans("category_name"); ?></label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="<?php echo trans("category_name"); ?>"
                           value="<?php echo html_escape($category->name); ?>" maxlength="200" required>
                </div>

                <div class="form-group hidden">
                    <label class="control-label"><?php echo trans("slug"); ?>
                        <small>(<?php echo trans("slug_exp"); ?>)</small>
                    </label>
                    <input type="text" class="form-control" name="slug" placeholder="<?php echo trans("slug"); ?>"
                           value="<?php echo html_escape($category->slug); ?>">
                </div>

                <div class="form-group hidden">
                    <label class="control-label"><?php echo trans('description'); ?> (<?php echo trans('meta_tag'); ?>)</label>
                    <input type="text" class="form-control" name="description"
                           placeholder="<?php echo trans('description'); ?> (<?php echo trans('meta_tag'); ?>)"
                           value="<?php echo html_escape($category->description); ?>">
                </div>

                <div class="form-group hidden">
                    <label class="control-label"><?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)</label>
                    <input type="text" class="form-control" name="keywords"
                           placeholder="<?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)"
                           value="<?php echo html_escape($category->keywords); ?>">
                </div>

                <?php if ($category->parent_id == 0): ?>
                    <input type="hidden" class="form-control" name="parent_id" value="0">

                    <div class="form-group">
                        <label><?php echo trans('menu_order'); ?></label>
                        <input type="number" class="form-control" name="category_order" placeholder="<?php echo trans('menu_order'); ?>"
                               value="<?php echo html_escape($category->category_order); ?>" min="0" max="99999" required onkeypress="return isNumberKey(event)">
                    </div>

                <?php else: ?>
                    <div class="form-group">
                        <label><?php echo trans('parent_category'); ?></label>
                        <select class="form-control" name="parent_id" required>
                            <option value=""><?php echo trans('select_category'); ?></option>
                            <?php foreach ($categories as $item): ?>
                                <option value="<?php echo $item->id; ?>" <?php echo ($item->id == $category->parent_id) ? 'selected' : ''; ?>><?php echo $item->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12 col-lang">
                            <label><?php echo trans('show_on_menu'); ?></label>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-lang">
                            <input type="radio" id="rb_show_on_menu_1" name="show_on_menu" value="1" class="flat-orange" <?php echo ($category->show_on_menu == '1') ? 'checked' : ''; ?>>&nbsp;&nbsp;
                            <label for="rb_show_on_menu_1" class="cursor-pointer"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-lang">
                            <input type="radio" id="rb_show_on_menu_2" name="show_on_menu" value="0" class="flat-orange" <?php echo ($category->show_on_menu != '1') ? 'checked' : ''; ?>>&nbsp;&nbsp;
                            <label for="rb_show_on_menu_2" class="cursor-pointer"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
</div>

