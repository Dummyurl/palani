<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans("posts"); ?></h3>
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
                            <th width="20"><?php echo trans("id"); ?></th>
                            <th><?php echo trans("image"); ?></th>
                            <th style="min-width: 57px;"><?php echo trans("title"); ?></th>
                            <th><?php echo trans("category"); ?></th>
                            <th><?php echo trans("author"); ?></th>
                            <th><?php echo trans("visibility"); ?></th>
                            <th><?php echo trans("slider"); ?></th>
                            <th style="max-width: 40px;"><?php echo trans("slider_order"); ?></th>
                            <th><?php echo trans("our_picks"); ?></th>
                            <th><?php echo trans("date_added"); ?></th>
                            <th class="max-width-120"><?php echo trans("options"); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php $i = 1; foreach ($posts as $item): ?>
                            <tr>
                                <td><?php echo html_escape($i++); ?></td>
                                <td>
                                    <img src="<?php echo base_url() . html_escape($item->image_small); ?>" alt="">
                                </td>
                                <td class="break-word">
                                    <?php echo html_escape($item->title); ?>
                                </td>
                                <td>
                                    <?php
                                    $category = helper_get_category($item->category_id);
                                    if (!empty($category)):?>
                                        <label class="label bg-purple"><?php echo html_escape($category->name); ?></label>
                                    <?php endif;
                                    ?>
                                    <?php
                                    $category = helper_get_category($item->subcategory_id);
                                    if (!empty($category)):?>
                                        <label class="label bg-teal"><?php echo html_escape($category->name); ?></label>
                                    <?php endif;
                                    ?>
                                </td>
                                <td>
                                    <?php $author = get_user($item->user_id);
                                    if (!empty($author)): ?>
                                        <a href="<?php echo base_url(); ?>profile/<?php echo html_escape($author->slug); ?>" target="_blank">
                                            <strong><?php echo html_escape($author->username); ?></strong>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($item->visibility == 0): ?>
                                        <label class="label label-danger"><i class="fa fa-eye"></i></label>
                                    <?php else: ?>
                                        <label class="label label-success"><i class="fa fa-eye"></i></label>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($item->is_slider): ?>
                                        <label class="label label-success"><?php echo trans("yes"); ?></label>
                                    <?php else: ?>
                                        <label class="label label-danger"><?php echo trans("no"); ?></label>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($item->is_slider): ?>

                                        <?php echo form_open('admin_post/post_slider_order_post'); ?>
                                        <div class="slider-order">
                                            <div class="slider-order-left">
                                                <input type="hidden" name="id"
                                                       value="<?php echo html_escape($item->id); ?>">
                                                <input type="number" name="slider_order" class="form-control"
                                                       value="<?php echo html_escape($item->slider_order); ?>" min="0" max="99999" onkeypress="return isNumberKey(event)">
                                            </div>
                                            <div class="slider-order-right">
                                                <button type="submit" class="btn btn-sm btn-success"><i
                                                            class="fa fa-check"></i></button>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($item->is_picked): ?>
                                        <label class="label label-success"><?php echo trans("yes"); ?></label>
                                    <?php else: ?>
                                        <label class="label label-danger"><?php echo trans("no"); ?></label>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo nice_date($item->created_at, 'd.m.Y'); ?></td>

                                <td>
                                    <!-- form delete user -->
                                    <?php echo form_open('admin_post/post_options_post'); ?>

                                    <input type="hidden" name="post_id" value="<?php echo html_escape($item->id); ?>">

                                    <div class="dropdown">
                                        <button class="btn btn-danger dropdown-toggle btn-select-option"
                                                type="button" data-toggle="dropdown"><?php echo trans("select_option"); ?>
                                            <span class="caret"></span></button>

                                        <ul class="dropdown-menu pull-right options-list">
                                            <?php if (is_admin()): ?>
                                                <?php if ($item->is_slider): ?>
                                                    <li>
                                                        <a class="p0">
                                                            <button type="submit" name="option" value="add_delete_slider"
                                                                    class="btn-list-button">
                                                                <i class="fa fa-minus"></i><?php echo trans("remove_slider"); ?>
                                                            </button>
                                                        </a>
                                                    </li>
                                                <?php else: ?>
                                                    <li>
                                                        <a class="p0">
                                                            <button type="submit" name="option" value="add_delete_slider"
                                                                    class="btn-list-button">
                                                                <i class="fa fa-plus"></i><?php echo trans("add_slider"); ?>
                                                            </button>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>


                                                <?php if ($item->is_picked): ?>
                                                    <li>
                                                        <a class="p0">
                                                            <button type="submit" name="option" value="add_delete_picked"
                                                                    class="btn-list-button">
                                                                <i class="fa fa-minus"></i><?php echo trans("remove_picked"); ?>
                                                            </button>
                                                        </a>
                                                    </li>
                                                <?php else: ?>
                                                    <li>
                                                        <a class="p0">
                                                            <button type="submit" name="option" value="add_delete_picked"
                                                                    class="btn-list-button">
                                                                <i class="fa fa-plus"></i><?php echo trans("add_picked"); ?>
                                                            </button>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <li>
                                                <a href="<?php echo base_url(); ?>admin_post/update_post?id=<?php echo html_escape($item->id); ?>">
                                                    <i class="fa fa-edit i-edit"></i><?php echo trans("edit"); ?></a></li>
                                            <li>
                                                <a class="p0">
                                                    <button type="submit" name="option" value="delete"
                                                            class="btn-list-button"
                                                            onclick="return confirm('<?php echo trans("confirm_post"); ?>');">
                                                        <i class="fa fa-trash i-delete"></i><?php echo trans("delete"); ?>
                                                    </button>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>

                                    <?php echo form_close(); ?><!-- form end -->

                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>