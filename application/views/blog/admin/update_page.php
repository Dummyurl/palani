<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("update_page"); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin/update_page_post'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('blog/admin/_messages'); ?>

                <input type="hidden" value="<?php echo html_escape($page->id); ?>" name="id">
                <input type="hidden" name="redirect_url" value="<?php echo html_escape($this->input->get('redirect_url')); ?>">

                <div class="form-group">
                    <label><?php echo trans("title"); ?></label>
                    <input type="text" class="form-control" name="title" placeholder="<?php echo trans("title"); ?>"
                           value="<?php echo html_escape($page->title); ?>" required>
                </div>

                <?php if ($page->is_custom == 1): ?>
                    <div class="form-group">
                        <label class="control-label"><?php echo trans("slug"); ?>
                            <small>(<?php echo trans("slug_exp"); ?>)</small>
                        </label>
                        <input type="text" class="form-control" name="slug" placeholder="<?php echo trans("slug"); ?>"
                               value="<?php echo html_escape($page->slug); ?>">
                    </div>
                <?php else: ?>
                    <input type="hidden" name="slug" value="<?php echo html_escape($page->slug); ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)</label>
                    <input type="text" class="form-control" name="page_description"
                           placeholder="<?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)"
                           value="<?php echo html_escape($page->page_description); ?>">
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans("keywords"); ?> (<?php echo trans('meta_tag'); ?>)</label>
                    <input type="text" class="form-control" name="page_keywords"
                           placeholder="<?php echo trans("keywords"); ?> (<?php echo trans('meta_tag'); ?>)" value="<?php echo html_escape($page->page_keywords); ?>">
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('parent_link'); ?></label>
                    <select name="parent_id" class="form-control max-600">
                        <option value="0"><?php echo trans('none'); ?></option>
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

                <?php if ($page->slug != "index" && $page->slug != "login" && $page->slug != "register" && $page->slug != "change-password" && $page->slug != "update-profile" && $page->slug != "reset-password" && $page->slug != "rss-channels" && $page->slug != "reading-list"): ?>
                    <div class="form-group">
                        <label><?php echo trans("menu_order"); ?></label>
                        <input type="number" class="form-control" name="page_order" placeholder="<?php echo trans("menu_order"); ?>"
                               value="<?php echo html_escape($page->page_order); ?>" min="0" max="999" required
                               style="width: 200px;">
                    </div>
                <?php else: ?>
                    <input type="hidden" name="page_order" value="<?php echo html_escape($page->page_order); ?>">
                <?php endif; ?>

                <?php if ($page->slug != "index" && $page->slug != "login" && $page->slug != "register" && $page->slug != "change-password" && $page->slug != "update-profile" && $page->slug != "reset-password" && $page->slug != "rss-channels" && $page->slug != "reading-list"): ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12 col-lang">
                                <label><?php echo trans("location"); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="location" value="header" id="location_enabled"
                                       class="flat-orange" <?php echo ($page->location == "header") ? 'checked' : ''; ?>>
                                <label for="location_enabled" class="option-label"><?php echo trans('header'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="location" value="footer" id="location_disabled"
                                       class="flat-orange" <?php echo ($page->location == "footer") ? 'checked' : ''; ?>>
                                <label for="location_disabled" class="option-label"><?php echo trans('footer'); ?></label>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="location" value="<?php echo html_escape($page->location); ?>">
                <?php endif; ?>

                <?php if ($page->slug != "index" && $page->slug != "login" && $page->slug != "register" && $page->slug != "change-password" && $page->slug != "update-profile" && $page->slug != "reset-password" && $page->slug != "reading-list"): ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12 col-lang">
                                <label><?php echo trans('visibility'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="page_active" value="1" id="page_enabled"
                                       class="flat-orange" <?php echo ($page->page_active == 1) ? 'checked' : ''; ?>>
                                <label for="page_enabled" class="option-label"><?php echo trans('show'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="page_active" value="0" id="page_disabled"
                                       class="flat-orange" <?php echo ($page->page_active == 0) ? 'checked' : ''; ?>>
                                <label for="page_disabled" class="option-label"><?php echo trans('hide'); ?></label>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="page_active" value="1">
                <?php endif; ?>

                <?php if ($page->slug != "index" && $page->slug != "login" && $page->slug != "register" && $page->slug != "change-password" && $page->slug != "update-profile" && $page->slug != "reset-password" && $page->slug != "reading-list"): ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12 col-lang">
                                <label><?php echo trans('show_only_registered'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="need_auth" value="1" id="need_auth_enabled"
                                       class="flat-orange" <?php echo ($page->need_auth == 1) ? 'checked' : ''; ?>>
                                <label for="need_auth_enabled" class="option-label"><?php echo trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="need_auth" value="0" id="need_auth_disabled"
                                       class="flat-orange" <?php echo ($page->need_auth == 0) ? 'checked' : ''; ?>>
                                <label for="need_auth_disabled" class="option-label"><?php echo trans('no'); ?></label>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="need_auth" value="0">
                <?php endif; ?>


                <?php if ($page->slug != "index" && $page->slug != "login" && $page->slug != "register" && $page->slug != "change-password" && $page->slug != "update-profile" && $page->slug != "reset-password"): ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12 col-lang">
                                <label><?php echo trans('show_title'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="title_active" value="1" id="title_enabled"
                                       class="flat-orange" <?php echo ($page->title_active == 1) ? 'checked' : ''; ?>>
                                <label for="title_enabled" class="option-label"><?php echo trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="title_active" value="0" id="title_disabled"
                                       class="flat-orange" <?php echo ($page->title_active == 0) ? 'checked' : ''; ?>>
                                <label for="title_disabled" class="option-label"><?php echo trans('no'); ?></label>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="title_active" value="1">
                <?php endif; ?>

                <?php if ($page->slug != "index") : ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12 col-lang">
                                <label><?php echo trans('show_breadcrumb'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="breadcrumb_active" value="1" id="breadcrumb_enabled"
                                       class="flat-orange" <?php echo ($page->breadcrumb_active == 1) ? 'checked' : ''; ?>>
                                <label for="breadcrumb_enabled" class="option-label"><?php echo trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="breadcrumb_active" value="0" id="breadcrumb_disabled"
                                       class="flat-orange" <?php echo ($page->breadcrumb_active == 0) ? 'checked' : ''; ?>>
                                <label for="breadcrumb_disabled" class="option-label"><?php echo trans('no'); ?></label>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="breadcrumb_active" value="1">
                <?php endif; ?>

                <?php if ($page->slug != "index" && $page->slug != "gallery" && $page->slug != "contact" && $page->slug != "login" && $page->slug != "register" && $page->slug != "change-password" && $page->slug != "update-profile" && $page->slug != "reset-password" && $page->slug != "rss-channels" && $page->slug != "reading-list"): ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12 col-lang">
                                <label><?php echo trans('show_right_column'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="right_column_active" value="1" id="right_column_enabled"
                                       class="flat-orange" <?php echo ($page->right_column_active == 1) ? 'checked' : ''; ?>>
                                <label for="right_column_enabled" class="option-label"><?php echo trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <input type="radio" name="right_column_active" value="0" id="right_column_disabled"
                                       class="flat-orange" <?php echo ($page->right_column_active == 0) ? 'checked' : ''; ?>>
                                <label for="right_column_disabled" class="option-label"><?php echo trans('no'); ?></label>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="right_column_active" value="1">
                <?php endif; ?>

                <?php if ($page->is_custom == 1 || $page->slug == "rss-channels"): ?>
                    <div class="form-group">
                        <label><?php echo trans('content'); ?></label>
                        <textarea id="ckEditor" class="form-control" name="page_content"
                                  placeholder="Content" required><?php echo $page->page_content; ?></textarea>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="page_content" value="<?php echo $page->page_content; ?>">
                <?php endif; ?>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right" style="margin-left: 10px;"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
</div>