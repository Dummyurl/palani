<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans('comments'); ?></h3>
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
                            <th width="20"><?php echo trans('id'); ?></th>
                            <th><?php echo trans('name'); ?></th>
                            <th><?php echo trans('email'); ?></th>
                            <th><?php echo trans('comment'); ?></th>
                            <th style="min-width: 20%"><?php echo trans('post'); ?></th>
                            <th style="min-width: 10%"><?php echo trans('date_added'); ?></th>
                            <th class="max-width-120"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php $i = 1; foreach ($comments as $item): ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo html_escape($item->username); ?></td>
                                <td><?php echo html_escape($item->email); ?></td>
                                <td class="break-word"><?php echo html_escape($item->comment); ?></td>
                                <td><?php echo html_escape($item->title); ?></td>
                                <td><?php echo nice_date($item->created_at, 'd.m.Y h:i'); ?></td>

                                <td>
                                    <!-- form delete comment-->
                                    <?php echo form_open('admin/delete_comment_post'); ?>

                                    <input type="hidden" name="id" value="<?php echo html_escape($item->id); ?>">

                                    <div class="dropdown">
                                        <button class="btn btn-danger dropdown-toggle btn-select-option"
                                                type="button"
                                                data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                            <span class="caret"></span></button>

                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="p0">
                                                    <button type="submit" class="btn-list-button"
                                                            onclick="return confirm('<?php echo trans("confirm_comment"); ?>');">
                                                        <i class="fa fa-trash i-delete"></i><?php echo trans('delete'); ?>
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
