<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-5 col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("update_link"); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin/update_menu_link_post'); ?>

            <input type="hidden" name="id" value="<?php echo $page->id; ?>">

            <div class="box-body">
                <!-- include message block -->
                <?php if (empty($this->session->flashdata("mes_menu_limit"))):
                    $this->load->view('blog/admin/_messages_form');
                endif; ?>

                <div class="form-group">
                    <label><?php echo trans("title"); ?></label>
                    <input type="text" class="form-control" name="title" placeholder="<?php echo trans("title"); ?>"
                           value="<?php echo $page->title; ?>" maxlength="200" required>
                </div>

                <div class="form-group">
                    <label><?php echo trans("link"); ?></label>
                    <input type="text" class="form-control" name="link" placeholder="<?php echo trans("link"); ?>"
                           value="<?php echo $page->link; ?>" required>
                </div>

                <div class="form-group">
                    <label><?php echo trans('menu_order'); ?></label>
                    <input type="number" class="form-control" name="page_order"
                           placeholder="<?php echo trans('menu_order'); ?>"
                           value="<?php echo $page->page_order; ?>" min="0" max="99999">
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('parent_link'); ?></label>
                    <select name="parent_id" class="form-control">
                        <option value=""><?php echo trans('none'); ?></option>
                        <?php foreach ($menu_links as $item): ?>
                            <?php if ($item["type"] != "category" && $item["location"] == "header" && $item['parent_id'] == "0" && $item['id'] != $page->id): ?>
                                <?php if ($item["id"] == $page->parent_id): ?>
                                    <option value="<?php echo $item["id"]; ?>"
                                            selected><?php echo $item["title"]; ?></option>
                                <?php else: ?>
                                    <option value="<?php echo $item["id"]; ?>"><?php echo $item["title"]; ?></option>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12 col-lang">
                            <label><?php echo trans('show_on_menu'); ?></label>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-lang">
                            <input type="radio" id="rb_show_on_menu_1" name="page_active" value="1" class="flat-orange" <?php echo ($page->page_active == '1') ? 'checked' : ''; ?>>&nbsp;&nbsp;
                            <label for="rb_show_on_menu_1" class="cursor-pointer"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-lang">
                            <input type="radio" id="rb_show_on_menu_2" name="page_active" value="0" class="flat-orange" <?php echo ($page->page_active != '1') ? 'checked' : ''; ?>>&nbsp;&nbsp;
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
