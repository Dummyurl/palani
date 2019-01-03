<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("add_post"); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('admin_post/add_post_post', ['onkeypress' => 'return event.keyCode != 13;']); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('blog/admin/_messages'); ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans("title"); ?></label>
                    <input type="text" class="form-control" name="title" placeholder="<?php echo trans("title"); ?>"
                           value="<?php echo old('title'); ?>" required>
                </div>

                <div class="form-group hidden">
                    <label class="control-label"><?php echo trans("slug"); ?>
                        <small>(<?php echo trans("slug_exp"); ?>)</small>
                    </label>
                    <input type="text" class="form-control" name="title_slug" placeholder="<?php echo trans("slug"); ?>"
                           value="<?php echo old('title_slug'); ?>">
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('summary'); ?> & <?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)</label>
                    <textarea class="form-control text-area"
                              name="summary" placeholder="<?php echo trans('summary'); ?> & <?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)"><?php echo old('summary'); ?></textarea>
                </div>

                <div class="form-group hidden">
                    <label class="control-label"><?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)</label>
                    <input type="text" class="form-control" name="keywords"
                           placeholder="<?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)" value="<?php echo old('keywords'); ?>">
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('category'); ?></label>
                    <select name="category_id" class="form-control max-600" onchange="get_sub_categories(this.value);" required>
                        <option value=""><?php echo trans('select_category'); ?></option>
                        <?php foreach ($categories as $item): ?>
                            <?php if ($item->id == old('category_id')): ?>
                                <option value="<?php echo html_escape($item->id); ?>"
                                        selected><?php echo html_escape($item->name); ?></option>
                            <?php else: ?>
                                <option value="<?php echo html_escape($item->id); ?>"><?php echo html_escape($item->name); ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div id="subcategories">
                    <div class="form-group">
                        <label class="control-label"><?php echo trans('subcategory'); ?></label>
                        <select name="subcategory_id" class="form-control max-600">
                            <option value=""><?php echo trans('select_category'); ?></option>
                        </select>
                    </div>
                </div>


                <?php if (is_author()): ?>
                    <input type="hidden" name="visibility" value="0">&nbsp;&nbsp;
                <?php else: ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12 col-lang">
                            <label><?php echo trans('visibility'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                            <input type="radio" name="visibility" value="1" id="rb_visibility_1" class="flat-orange" checked>
                            <label for="rb_visibility_1" class="option-label"><?php echo trans('show'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                            <input type="radio" name="visibility" value="0" id="rb_visibility_2" class="flat-orange">
                            <label for="rb_visibility_2" class="option-label"><?php echo trans('hide'); ?></label>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (is_author()): ?>
                    <input type="hidden" name="is_slider" value="0">&nbsp;&nbsp;
                <?php else: ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12 col-lang">
                                <label><?php echo trans('add_slider'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="is_slider" value="1" id="rb_is_slider_1" class="flat-orange" checked>
                                <label for="rb_is_slider_1" class="option-label"><?php echo trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="is_slider" value="0" id="rb_is_slider_2" class="flat-orange">
                                <label for="rb_is_slider_2" class="option-label"><?php echo trans('no'); ?></label>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>


                <?php if (is_author()): ?>
                    <input type="hidden" name="is_picked" value="0">&nbsp;&nbsp;
                <?php else: ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12 col-lang">
                                <label><?php echo trans('add_picked'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="is_picked" value="1" id="rb_is_picked_1" class="flat-orange" checked>
                                <label for="rb_is_picked_1" class="option-label"><?php echo trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="is_picked" value="0" id="rb_is_picked_2" class="flat-orange">
                                <label for="rb_is_picked_2" class="option-label"><?php echo trans('no'); ?></label>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (is_author()): ?>
                    <input type="hidden" name="need_auth" value="0">&nbsp;&nbsp;
                <?php else: ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12 col-lang">
                                <label><?php echo trans('show_only_registered'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="need_auth" value="1" id="rb_need_auth_1" class="flat-orange">
                                <label for="rb_need_auth_1" class="option-label"><?php echo trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="need_auth" value="0" id="rb_need_auth_2" class="flat-orange" checked>
                                <label for="rb_need_auth_2" class="option-label"><?php echo trans('no'); ?></label>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('tags'); ?></label>
                    <input id="tags-input" type="text" name="tags" data-role="tagsinput" class="form-control"/>
                    <small>(<?php echo trans('type_tag'); ?>)</small>
                </div>


                <div class="form-group">
                    <label class="control-label"><?php echo trans('main_image'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <a class='btn btn-success btn-sm'>
                                <?php echo trans('select_image'); ?>
                                <input type="file" id="Multifileupload" name="file" size="40" class="uploadFile"
                                       accept=".png, .jpg, .jpeg, .gif">
                            </a>
                            <a class='btn btn-danger btn-sm' id="btn_delete_file_image" onclick="reset_file_input();"><?php echo trans('delete'); ?></a>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="row">
                            <div id="MultidvPreview">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('additional_images'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <a class='btn btn-success btn-sm'>
                                <?php echo trans('add_images'); ?>
                                <input type="file" id="Multifileupload1" name="add_file[]" size="40"
                                       class="uploadFile" accept=".png, .jpg, .jpeg, .gif" multiple>
                            </a>
                            <a class='btn btn-danger btn-sm' id="btn_delete_multi_file_image" onclick="reset_multi_file_input();"><?php echo trans('delete_all'); ?></a>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div id="MultidvPreview1">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('optional_url'); ?></label>
                    <input type="text" class="form-control"
                           name="optional_url" placeholder="<?php echo trans('optional_url'); ?>"
                           value="<?php echo old('optional_url'); ?>">
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('content'); ?></label>
                    <textarea id="ckEditor" class="form-control"
                              name="content" placeholder="<?php echo trans('content'); ?>" required><?php echo old('content'); ?></textarea>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_post'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
</div>

