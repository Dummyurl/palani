<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-5 col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("add_link"); ?></h3>
            </div>
            <!-- /.box-header -->


            <!-- form start -->
            <?php echo form_open('admin/add_menu_link_post'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php if (empty($this->session->flashdata("mes_menu_limit"))):
                    $this->load->view('blog/admin/_messages_form');
                endif; ?>

                <div class="form-group">
                    <label><?php echo trans("title"); ?></label>
                    <input type="text" class="form-control" name="title" placeholder="<?php echo trans("title"); ?>"
                           value="<?php echo old('title'); ?>" maxlength="200" required>
                </div>

                <div class="form-group">
                    <label><?php echo trans("link"); ?></label>
                    <input type="text" class="form-control" name="link" placeholder="<?php echo trans("link"); ?>"
                           value="<?php echo old('link'); ?>" required>
                </div>

                <div class="form-group">
                    <label><?php echo trans('menu_order'); ?></label>
                    <input type="number" class="form-control" name="page_order"
                           placeholder="<?php echo trans('menu_order'); ?>"
                           value="<?php echo old('page_order'); ?>" min="0" max="99999">
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('parent_link'); ?></label>
                    <select name="parent_id" class="form-control">
                        <option value=""><?php echo trans('none'); ?></option>
                        <?php foreach ($menu_links as $item): ?>
                            <?php if ($item["type"] != "category" && $item["location"] == "header" && $item['parent_id'] == "0"): ?>
                                <?php if ($item["id"] == old('parent_id')): ?>
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
                            <input type="radio" id="rb_show_on_menu_1" name="page_active" value="1" class="flat-orange"
                                   checked>&nbsp;&nbsp;
                            <label for="rb_show_on_menu_1" class="cursor-pointer"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-lang">
                            <input type="radio" id="rb_show_on_menu_2" name="page_active" value="0"
                                   class="flat-orange">&nbsp;&nbsp;
                            <label for="rb_show_on_menu_2" class="cursor-pointer"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>

            </div>

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_link'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("menu_limit"); ?></h3>
            </div>
            <!-- /.box-header -->


            <!-- form start -->
            <?php echo form_open('admin/menu_limit_post'); ?>

            <div class="box-body">

                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("mes_menu_limit"))):
                    $this->load->view('blog/admin/_messages_form');
                endif; ?>

                <div class="form-group">
                    <label><?php echo trans('menu_limit'); ?></label>
                    <input type="number" class="form-control" name="menu_limit"
                           placeholder="<?php echo trans('menu_limit'); ?>"
                           value="<?php echo $settings->menu_limit; ?>" min="1" max="99999" required>
                </div>

            </div>

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>


    <div class="col-md-7 col-sm-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title"><?php echo trans('navigation'); ?></h3>
                </div>
            </div><!-- /.box-header -->

            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('blog/admin/_messages'); ?>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dataTable" id="cs_datatable" role="grid"
                                   aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th style="max-width: 75px;"><?php echo trans('menu_order'); ?></th>
                                    <th><?php echo trans('title'); ?></th>
                                    <th><?php echo trans('parent_link'); ?></th>
                                    <th><?php echo trans('visibility'); ?></th>
                                    <th class="max-width-120"><?php echo trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($menu_links as $menu_item): ?>
                                    <?php if ($menu_item["location"] == "header"): ?>
                                        <tr>
                                            <td><?php echo html_escape($menu_item["order"]); ?></td>
                                            <td><?php echo html_escape($menu_item["title"]); ?></td>
                                            <td>
                                                <?php $parent = helper_get_parent_link($menu_item["parent_id"], $menu_item["type"]); ?>
                                                <?php if (!empty($parent)): ?>
                                                    <?php if ($menu_item["type"] == "page" || $menu_item["type"] == "link"):
                                                        echo $parent->title;
                                                    endif; ?>

                                                    <?php if ($menu_item["type"] == "category"):
                                                        echo $parent->name;
                                                    endif; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($menu_item["visibility"] == 0): ?>
                                                    <label class="label label-danger"><i class="fa fa-eye"></i></label>
                                                <?php else: ?>
                                                    <label class="label label-success"><i class="fa fa-eye"></i></label>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <?php if ($menu_item["type"] == "category"): ?>

                                                    <?php echo form_open('admin_category/delete_category_post'); ?>
                                                    <input type="hidden" name="category_id" value="<?php echo $menu_item["id"]; ?>">

                                                    <div class="dropdown">
                                                        <button class="btn btn-danger dropdown-toggle btn-select-option" type="button"
                                                                data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                            <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="<?php echo base_url(); ?>admin_category/update_category?id=<?php echo $menu_item["id"]; ?>&redirect_url=navigation"><i
                                                                            class="fa fa-edit i-edit"></i><?php echo trans('edit'); ?>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="p0">
                                                                    <button type="submit" class="btn-list-button"
                                                                            onclick="return confirm('<?php echo trans("confirm_category"); ?>');">
                                                                        <i class="fa fa-trash i-delete"></i><?php echo trans('delete'); ?>
                                                                    </button>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <?php echo form_close(); ?>

                                                <?php endif; ?>


                                                <?php if ($menu_item["type"] == "page"): ?>

                                                    <?php echo form_open('admin/delete_page_post'); ?>
                                                    <input type="hidden" name="id" value="<?php echo $menu_item["id"]; ?>">

                                                    <div class="dropdown">
                                                        <button class="btn btn-danger dropdown-toggle btn-select-option"
                                                                type="button"
                                                                data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                            <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="<?php echo base_url(); ?>admin/update_page/<?php echo $menu_item["id"]; ?>?redirect_url=navigation"><i
                                                                            class="fa fa-edit i-edit"></i><?php echo trans('edit'); ?>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="p0">
                                                                    <button type="submit" class="btn-list-button"
                                                                            onclick="return confirm('<?php echo trans("confirm_page"); ?>');">
                                                                        <i class="fa fa-trash i-delete"></i><?php echo trans("delete"); ?>
                                                                    </button>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <?php echo form_close(); ?>

                                                <?php endif; ?>


                                                <?php if ($menu_item["type"] == "link"): ?>

                                                    <?php echo form_open('admin/delete_navigation_post'); ?>
                                                    <input type="hidden" name="id" value="<?php echo $menu_item["id"]; ?>">

                                                    <div class="dropdown">
                                                        <button class="btn btn-danger dropdown-toggle btn-select-option"
                                                                type="button"
                                                                data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                            <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="<?php echo base_url(); ?>admin/update_menu_link?id=<?php echo $menu_item["id"]; ?>"><i
                                                                            class="fa fa-edit i-edit"></i><?php echo trans('edit'); ?>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="p0">
                                                                    <button type="submit" class="btn-list-button"
                                                                            onclick="return confirm('<?php echo trans("confirm_link"); ?>');">
                                                                        <i class="fa fa-trash i-delete"></i><?php echo trans("delete"); ?>
                                                                    </button>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <?php echo form_close(); ?>

                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>
