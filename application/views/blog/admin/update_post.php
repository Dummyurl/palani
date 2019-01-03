<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("add_post"); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('admin_post/update_post_post', ['onkeypress' => 'return event.keyCode != 13;']); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('blog/admin/_messages'); ?>

                <input type="hidden" name="id" value="<?php echo html_escape($post->id); ?>">
                <input type="hidden" name="redirect_url" value="<?php echo html_escape($this->input->get('redirect_url')); ?>">

                <div class="form-group">
                    <label class="control-label"><?php echo trans("title"); ?></label>
                    <input type="text" class="form-control" name="title" placeholder="<?php echo trans("title"); ?>"
                           value="<?php echo html_escape($post->title); ?>" required>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans("slug"); ?>
                        <small>(<?php echo trans("slug_exp"); ?>)</small>
                    </label>
                    <input type="text" class="form-control" name="title_slug" placeholder="<?php echo trans("slug"); ?>"
                           value="<?php echo html_escape($post->title_slug); ?>">
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('summary'); ?> & <?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)</label>
                    <textarea class="form-control text-area" name="summary"
                              placeholder="<?php echo trans('summary'); ?> & <?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)"><?php echo html_escape($post->summary); ?></textarea>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)</label>
                    <input type="text" class="form-control" name="keywords"
                           placeholder="<?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)" value="<?php echo html_escape($post->keywords); ?>">
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('category'); ?></label>
                    <select name="category_id" class="form-control max-600" onchange="get_sub_categories(this.value);" required>
                        <option value=""><?php echo trans('select_category'); ?></option>
                        <?php foreach ($categories as $item): ?>
                            <?php if ($item->id == $post->category_id): ?>
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
                            <?php foreach ($subcategories as $item): ?>
                                <?php if ($item->id == $post->subcategory_id): ?>
                                    <option value="<?php echo html_escape($item->id); ?>"
                                            selected><?php echo html_escape($item->name); ?></option>
                                <?php else: ?>
                                    <option value="<?php echo html_escape($item->id); ?>"><?php echo html_escape($item->name); ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <?php if (is_author()): ?>
                    <input type="hidden" name="visibility" value="<?php echo $post->visibility; ?>">&nbsp;&nbsp;
                <?php else: ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12 col-lang">
                                <label><?php echo trans('visibility'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="visibility" value="1" id="rb_visibility_1" class="flat-orange" <?php echo ($post->visibility == 1) ? 'checked' : ''; ?>>
                                <label for="rb_visibility_1" class="option-label"><?php echo trans('show'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="visibility" value="0" id="rb_visibility_2" class="flat-orange" <?php echo ($post->visibility == 0) ? 'checked' : ''; ?>>
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
                                <input type="radio" name="is_slider" value="1" id="rb_is_slider_1" class="flat-orange" <?php echo ($post->is_slider == 1) ? 'checked' : ''; ?>>
                                <label for="rb_is_slider_1" class="option-label"><?php echo trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="is_slider" value="0" id="rb_is_slider_2" class="flat-orange" <?php echo ($post->is_slider == 0) ? 'checked' : ''; ?>>
                                <label for="rb_is_slider_2" class="option-label"><?php echo trans('no'); ?></label>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (is_author()): ?>
                    <input type="hidden" name="is_picked" value="<?php echo $post->is_picked; ?>">&nbsp;&nbsp;
                <?php else: ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12 col-lang">
                                <label><?php echo trans('add_picked'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="is_picked" value="1" id="rb_is_picked_1" class="flat-orange" <?php echo ($post->is_picked == 1) ? 'checked' : ''; ?>>
                                <label for="rb_is_picked_1" class="option-label"><?php echo trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="is_picked" value="0" id="rb_is_picked_2" class="flat-orange" <?php echo ($post->is_picked == 0) ? 'checked' : ''; ?>>
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
                                <input type="radio" name="need_auth" value="1" id="rb_need_auth_1" class="flat-orange" <?php echo ($post->need_auth == 1) ? 'checked' : ''; ?>>
                                <label for="rb_need_auth_1" class="option-label"><?php echo trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="need_auth" value="0" id="rb_need_auth_2" class="flat-orange" <?php echo ($post->need_auth == 0) ? 'checked' : ''; ?>>
                                <label for="rb_need_auth_2" class="option-label"><?php echo trans('no'); ?></label>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('tags'); ?></label>
                    <input id="tags-input" type="text" name="tags" data-role="tagsinput"
                           class="form-control" value="<?php echo html_escape($tags); ?>"/>
                    <small>(<?php echo trans('type_tag'); ?>)</small>
                </div>


                <div class="form-group">
                    <label class="control-label"><?php echo trans('main_image'); ?></label>
                    <div class="col-sm-12 p0">
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="<?php echo base_url() . html_escape($post->image_mid); ?>" alt=""
                                     class="thumbnail img-responsive">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <a class='btn btn-success btn-sm'>
                                    <?php echo trans('change_image'); ?>
                                    <input type="file" id="Multifileupload" name="file" size="40"
                                           class="uploadFile" accept=".png, .jpg, .jpeg, .gif">
                                </a>
                            </div>
                        </div>

                        <div id="MultidvPreview">
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label class="control-label"><?php echo trans('additional_images'); ?></label>
                    <div class="col-sm-12 p0">
                        <div class="row">
                            <?php foreach ($post_images as $item) : ?>
                                <?php if ($item) : ?>
                                    <div class="col-sm-3">
                                        <img src="<?php echo base_url() . html_escape($item->image_path); ?>" alt=""
                                             class="thumbnail img-responsive">
                                        <a class="btn btn-danger btn-delete-image"
                                           onclick="deletePostImage('<?php echo html_escape($item->id); ?>');">
                                            <i class="fa fa-times"></i>
                                        </a>

                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <a class='btn btn-success btn-sm'>
                                    <?php echo trans('add_images'); ?>
                                    <input type="file" id="Multifileupload1" name="add_file[]" size="40"
                                           class="uploadFile" accept=".png, .jpg, .jpeg, .gif" multiple>
                                </a>
                            </div>
                        </div>

                        <div id="MultidvPreview1">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('optional_url'); ?></label>
                    <input type="text" class="form-control"
                           name="optional_url" placeholder="<?php echo trans('optional_url'); ?>"
                           value="<?php echo html_escape($post->optional_url); ?>">
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('content'); ?></label>
                    <textarea id="ckEditor" class="form-control"
                              name="content" placeholder="<?php echo trans('content'); ?>"><?php echo html_escape($post->content); ?></textarea>
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