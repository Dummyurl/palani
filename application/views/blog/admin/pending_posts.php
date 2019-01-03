<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans("pending_posts"); ?></h3>
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
                                                <li>
                                                    <a class="p0">
                                                        <button type="submit" name="option" value="approve"
                                                                class="btn-list-button">
                                                            <i class="fa fa-check"></i><?php echo trans("approve"); ?>
                                                        </button>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <li>
                                                <a href="<?php echo base_url(); ?>admin_post/update_post?id=<?php echo html_escape($item->id); ?>&redirect_url=pending_posts">
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