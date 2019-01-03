<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('add_image'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('gallery/add_image_post'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('blog/admin/_messages'); ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('title'); ?></label>
                    <input type="text" class="form-control"
                           name="title" id="title" placeholder="<?php echo trans('title'); ?>"
                           value="<?php echo old('title'); ?>">
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('category'); ?></label>
                    <select name="category_id" class="form-control" required>
                        <option value=""><?php echo trans('select_category'); ?></option>
                        <?php foreach ($categories as $item): ?>
                            <?php if ($item->id == old('category_id')): ?>
                                <option value="<?php echo html_escape($item->id); ?>" selected>
                                    <?php echo html_escape($item->name); ?></option>
                            <?php else: ?>
                                <option value="<?php echo html_escape($item->id); ?>"><?php echo html_escape($item->name); ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('image'); ?></label>
                    <div class="col-sm-12 p0">
                        <div class="row">
                            <div class="col-sm-12">
                                <a class='btn btn-success btn-sm'>
                                    <?php echo trans('select_image'); ?>
                                    <input type="file" id="Multifileupload" name="file" size="40" class="uploadFile"
                                           accept=".png, .jpg, .jpeg, .gif" required>
                                </a>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="row">
                                <div id="MultidvPreview">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_image'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>


    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?php echo trans('images'); ?></h3>
                </div>
            </div><!-- /.box-header -->


            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dataTable" id="cs_datatable" role="grid"
                                   aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?php echo trans('id'); ?></th>
                                    <th><?php echo trans('image'); ?></th>
                                    <th><?php echo trans('title'); ?></th>
                                    <th><?php echo trans('category'); ?></th>
                                    <th><?php echo trans('date_added'); ?></th>
                                    <th class="max-width-120"><?php echo trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($images as $item): ?>
                                    <tr>
                                        <td><?php echo html_escape($item->id); ?></td>
                                        <td>
                                            <img src="<?php echo base_url() . html_escape($item->path_small); ?>" alt="" width="200" class="img-responsive">
                                        </td>
                                        <td><?php echo html_escape($item->title); ?></td>
                                        <td>
                                            <?php echo html_escape($item->category_name); ?>
                                        </td>
                                        <td style="min-width: 100px;"><?php echo nice_date($item->created_at, 'd.m.Y'); ?></td>

                                        <td>
                                            <!-- form delete image -->
                                            <?php echo form_open('gallery/delete_image_post'); ?>

                                            <input type="hidden" name="id" value="<?php echo html_escape($item->id); ?>">

                                            <div class="dropdown">
                                                <button class="btn btn-danger dropdown-toggle btn-select-option" type="button"
                                                        data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                    <span class="caret"></span></button>

                                                <ul class="dropdown-menu">

                                                    <li>
                                                        <a class="p0">
                                                            <button type="submit" class="btn-list-button"
                                                                    onclick="return confirm('<?php echo trans("confirm_image"); ?>');">
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
    </div>
</div>
