<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('seo_tools'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin/seo_tools_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('blog/admin/_messages'); ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('site_title'); ?></label>
                    <input type="text" class="form-control" name="site_title"
                           placeholder="<?php echo trans('site_title'); ?>" value="<?php echo html_escape($settings->site_title); ?>">
                </div>

                <div class="form-group">
                    <label><?php echo trans("home_title"); ?></label>
                    <input type="text" class="form-control" name="title" placeholder="<?php echo trans("home_title"); ?>"
                           value="<?php echo html_escape($page->title); ?>" required>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('description'); ?></label>
                    <textarea class="form-control text-area" name="page_description"
                              placeholder="<?php echo trans('description'); ?>"
                              style="min-height: 70px;"><?php echo html_escape($page->page_description); ?></textarea>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('keywords'); ?></label>
                    <textarea class="form-control text-area" name="page_keywords"
                              placeholder="<?php echo trans('keywords'); ?>"
                              style="min-height: 70px;"><?php echo html_escape($page->page_keywords); ?></textarea>
                </div>


                <div class="form-group">
                    <label class="control-label"><?php echo trans('google_analytics'); ?></label>
                    <textarea class="form-control text-area" name="google_analytics"
                              placeholder="<?php echo trans('google_analytics_code'); ?>"
                              style="min-height: 70px;"><?php echo html_escape($settings->google_analytics); ?></textarea>
                </div>

                <!-- /.box-body -->
                <div class="box-footer" style="padding-left: 0; padding-right: 0;">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                </div>
                <!-- /.box-footer -->

                <?php echo form_close(); ?><!-- form end -->
            </div>
            <!-- /.box -->
        </div>
    </div>

    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('generate_sitemap'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('sitemap/generate_sitemap_post'); ?>
            <div class="box-body">

                <div class="form-group">
                    <label class="label-sitemap"><?php echo trans('frequency'); ?></label>
                    <small class="small-sitemap"><?php echo trans('frequency_exp'); ?></small>

                    <select name="frequency" class="form-control">
                        <option value="none"><?php echo trans('none'); ?></option>
                        <option value="always"><?php echo trans('always'); ?></option>
                        <option value="hourly"><?php echo trans('hourly'); ?></option>
                        <option value="daily"><?php echo trans('daily'); ?></option>
                        <option value="weekly"><?php echo trans('weekly'); ?></option>
                        <option value="monthly" selected><?php echo trans('monthly'); ?></option>
                        <option value="yearly"><?php echo trans('yearly'); ?></option>
                        <option value="never"><?php echo trans('never'); ?></option>
                    </select>

                </div>

                <div class="form-group">
                    <label class="label-sitemap"><?php echo trans('last_modification'); ?></label>
                    <small class="small-sitemap"><?php echo trans('last_modification_exp'); ?></small>
                    <div class="form-radio">
                        <input type="radio" name="last_modification" value="none" class="flat-orange"> <span><?php echo trans('none'); ?></span>
                    </div>

                    <div class="form-radio">
                        <input type="radio" name="last_modification" value="server_response" class="flat-orange" checked> <span><?php echo trans('server_response'); ?></span>
                    </div>

                    <div class="form-radio">
                        <input type="radio" name="last_modification" value="custom" class="flat-orange">
                        <span> <?php echo trans('use_this_date'); ?> </span>
                        <input type="text" class="form-control input-custom-time" name="lastmod_time" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="label-sitemap"><?php echo trans('priority'); ?></label>
                    <small class="small-sitemap"><?php echo trans('priority_exp'); ?></small>
                    <div class="form-radio">
                        <input type="radio" name="priority" value="none" class="flat-orange"> <span><?php echo trans('none'); ?></span>
                    </div>

                    <div class="form-radio">
                        <input type="radio" name="priority" value="automatically" class="flat-orange" checked> <span><?php echo trans('priority_none'); ?></span>
                    </div>

                </div>

                <!-- /.box-body -->
                <div class="box-footer" style="padding-left: 0; padding-right: 0;">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('generate'); ?></button>
                </div>
                <!-- /.box-footer -->

                <?php echo form_close(); ?><!-- form end -->
            </div>
            <!-- /.box -->
        </div>
    </div>

</div>

