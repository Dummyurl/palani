<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-12">
        <!-- form start -->
        <?php echo form_open_multipart('admin/settings_post'); ?>

        <input type="hidden" name="logo_path" value="<?php echo html_escape($settings->logo_path); ?>">
        <input type="hidden" name="favicon_path" value="<?php echo html_escape($settings->favicon_path); ?>">

        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><?php echo trans('general_settings'); ?></a></li>
                <!-- <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><?php echo trans('email_settings'); ?></a></li>
                <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><?php echo trans('contact_settings'); ?></a></li>
                <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false"><?php echo trans('social_media_settings'); ?></a></li> -->
                <li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false"><?php echo trans('visual_settings'); ?></a></li>
               <!--  <li class=""><a href="#tab_6" data-toggle="tab" aria-expanded="false"><?php echo trans('facebook_comments'); ?></a></li> 
                <li class=""><a href="#tab_7" data-toggle="tab" aria-expanded="false"><?php echo trans('head_code'); ?></a></li>-->
                <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content settings-tab-content">
                <!-- include message block -->
                <?php $this->load->view('blog/admin/_messages'); ?>

                <div class="tab-pane active" id="tab_1">

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('language'); ?></label>

                        <select name="site_lang" class="form-control custom-select max-600">
                            <option value="english" <?php echo ($settings->site_lang == "english") ? "selected" : ""; ?>><?php echo trans('english'); ?></option>
                            <option value="french" <?php echo ($settings->site_lang == "french") ? "selected" : ""; ?>><?php echo trans('french'); ?></option>
                            <option value="german" <?php echo ($settings->site_lang == "german") ? "selected" : ""; ?>><?php echo trans('german'); ?></option>
                            <option value="portuguese" <?php echo ($settings->site_lang == "portuguese") ? "selected" : ""; ?>><?php echo trans('portuguese'); ?></option>
                            <option value="russian" <?php echo ($settings->site_lang == "russian") ? "selected" : ""; ?>><?php echo trans('russian'); ?></option>
                            <option value="turkish" <?php echo ($settings->site_lang == "turkish") ? "selected" : ""; ?>><?php echo trans('turkish'); ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('app_name'); ?></label>
                        <input type="text" class="form-control max-600" name="application_name" placeholder="<?php echo trans('app_name'); ?>"
                               value="<?php echo html_escape($settings->application_name); ?>">
                    </div>

                   <!--  <div class="form-group">
                        <div class="row">
                            <div class="col-sm-2 col-xs-12 col-lang">
                                <label><?php echo trans('registration_system'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <?php if ($settings->registration_system == 1): ?>
                                    <input type="checkbox" name="registration_system" checked data-toggle="toggle"
                                           data-on="On" data-off="Off" data-onstyle="success" data-offstyle="danger"
                                           value="1">
                                <?php else: ?>
                                    <input type="checkbox" name="registration_system" data-toggle="toggle" data-on="On"
                                           data-off="Off" data-onstyle="success" data-offstyle="danger" value="1">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-2 col-xs-12 col-lang">
                                <label><?php echo trans('comment_system'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <?php if ($settings->comment_system == 1): ?>
                                    <input type="checkbox" name="comment_system" checked data-toggle="toggle"
                                           data-on="On" data-off="Off" data-onstyle="success" data-offstyle="danger"
                                           value="1">
                                <?php else: ?>
                                    <input type="checkbox" name="comment_system" data-toggle="toggle" data-on="On"
                                           data-off="Off" data-onstyle="success" data-offstyle="danger" value="1">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-2 col-xs-12 col-lang">
                                <label><?php echo trans('slider'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <?php if ($settings->slider_active == 1): ?>
                                    <input type="checkbox" name="slider_active" checked data-toggle="toggle"
                                           data-on="On" data-off="Off" data-onstyle="success" data-offstyle="danger"
                                           value="1">
                                <?php else: ?>
                                    <input type="checkbox" name="slider_active" data-toggle="toggle" data-on="On"
                                           data-off="Off" data-onstyle="success" data-offstyle="danger" value="1">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-2 col-xs-12 col-lang">
                                <label><?php echo trans('show_post_view_counts'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <?php if ($settings->show_pageviews == 1): ?>
                                    <input type="checkbox" name="show_pageviews" checked data-toggle="toggle"
                                           data-on="On"
                                           data-off="Off" data-onstyle="success" data-offstyle="danger" value="1">
                                <?php else: ?>
                                    <input type="checkbox" name="show_pageviews" data-toggle="toggle" data-on="On"
                                           data-off="Off" data-onstyle="success" data-offstyle="danger" value="1">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-2 col-xs-12 col-lang">
                                <label><?php echo trans('rss'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                                <?php if ($settings->show_rss == 1): ?>
                                    <input type="checkbox" name="show_rss" checked data-toggle="toggle"
                                           data-on="On"
                                           data-off="Off" data-onstyle="success" data-offstyle="danger" value="1">
                                <?php else: ?>
                                    <input type="checkbox" name="show_rss" data-toggle="toggle" data-on="On"
                                           data-off="Off" data-onstyle="success" data-offstyle="danger" value="1">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('pagination_number_posts'); ?></label>
                        <input type="number" class="form-control" name="pagination_per_page" value="<?php echo html_escape($settings->pagination_per_page); ?>" required style="max-width: 200px;">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('optional_url_name'); ?></label>
                        <input type="text" class="form-control" name="optional_url_button_name"
                               placeholder="<?php echo trans('optional_url_name'); ?>"
                               value="<?php echo html_escape($settings->optional_url_button_name); ?>">
                    </div>


                    <div class="form-group">
                        <label class="control-label"><?php echo trans('footer_about_section'); ?></label>
                        <textarea class="form-control text-area" name="about_footer" placeholder="<?php echo trans('footer_about_section'); ?>"
                                  style="min-height: 70px;"><?php echo html_escape($settings->about_footer); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('copyright'); ?></label>
                        <input type="text" class="form-control" name="copyright"
                               placeholder="<?php echo trans('copyright'); ?>"
                               value="<?php echo html_escape($settings->copyright); ?>">
                    </div>
                </div><!-- /.tab-pane -->

                <div class="tab-pane" id="tab_2">
                    <div class="form-group">
                        <label class="control-label"><?php echo trans('protocol'); ?></label>

                        <select name="mail_protocol" class="form-control custom-select">
                            <option value="smtp" <?php echo ($settings->mail_protocol == "smtp") ? "selected" : ""; ?>><?php echo trans('smtp'); ?></option>
                            <option value="mail" <?php echo ($settings->mail_protocol == "mail") ? "selected" : ""; ?>><?php echo trans('mail'); ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('title'); ?></label>
                        <input type="text" class="form-control" name="mail_title"
                               placeholder="<?php echo trans('title'); ?>" value="<?php echo html_escape($settings->mail_title); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('host'); ?></label>
                        <input type="text" class="form-control" name="mail_host"
                               placeholder="<?php echo trans('host'); ?>" value="<?php echo html_escape($settings->mail_host); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('port'); ?></label>
                        <input type="text" class="form-control" name="mail_port"
                               placeholder="<?php echo trans('port'); ?>" value="<?php echo html_escape($settings->mail_port); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('username'); ?></label>
                        <input type="text" class="form-control" name="mail_username"
                               placeholder="<?php echo trans('username'); ?>" value="<?php echo html_escape($settings->mail_username); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('password'); ?></label>
                        <input type="password" class="form-control" name="mail_password"
                               placeholder="<?php echo trans('password'); ?>" value="<?php echo html_escape($settings->mail_password); ?>">
                    </div>

                    <div class="callout" style="max-width: 500px;margin-top: 30px;">
                        <h4><?php echo trans('gmail_smtp'); ?></h4>

                        <p><strong><?php echo trans('host'); ?>:&nbsp;&nbsp;</strong>ssl://smtp.googlemail.com</p>
                        <p><strong><?php echo trans('port'); ?>:&nbsp;&nbsp;</strong>465</p>
                    </div>

                </div><!-- /.tab-pane -->

                <div class="tab-pane" id="tab_3">
                    <div class="form-group">
                        <label class="control-label"><?php echo trans('address'); ?></label>
                        <input type="text" class="form-control" name="contact_address"
                               placeholder="<?php echo trans('address'); ?>" value="<?php echo html_escape($settings->contact_address); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('email'); ?></label>
                        <input type="text" class="form-control" name="contact_email"
                               placeholder="<?php echo trans('email'); ?>" value="<?php echo html_escape($settings->contact_email); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('phone'); ?></label>
                        <input type="text" class="form-control" name="contact_phone"
                               placeholder="<?php echo trans('phone'); ?>" value="<?php echo html_escape($settings->contact_phone); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('contact_text'); ?></label>
                        <textarea id="ckEditor" class="form-control" name="contact_text"
                                  placeholder="<?php echo trans('contact_text'); ?>"><?php echo html_escape($settings->contact_text); ?></textarea>
                    </div>


                </div><!-- /.tab-pane -->

                <div class="tab-pane" id="tab_4">
                    <div class="form-group">
                        <label class="control-label">Facebook <?php echo trans('url'); ?></label>
                        <input type="text" class="form-control" name="facebook_url"
                               placeholder="Facebook <?php echo trans('url'); ?>" value="<?php echo html_escape($settings->facebook_url); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label">Twitter <?php echo trans('url'); ?></label>
                        <input type="text" class="form-control"
                               name="twitter_url" placeholder="Twitter <?php echo trans('url'); ?>"
                               value="<?php echo html_escape($settings->twitter_url); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label">Google <?php echo trans('url'); ?></label>
                        <input type="text" class="form-control"
                               name="google_url" placeholder="Google <?php echo trans('url'); ?>"
                               value="<?php echo html_escape($settings->google_url); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label">Instagram <?php echo trans('url'); ?></label>
                        <input type="text" class="form-control" name="instagram_url" placeholder="Instagram <?php echo trans('url'); ?>"
                               value="<?php echo html_escape($settings->instagram_url); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label">Pinterest <?php echo trans('url'); ?></label>
                        <input type="text" class="form-control" name="pinterest_url" placeholder="Pinterest <?php echo trans('url'); ?>"
                               value="<?php echo html_escape($settings->pinterest_url); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label">LinkedIn <?php echo trans('url'); ?></label>
                        <input type="text" class="form-control" name="linkedin_url" placeholder="LinkedIn <?php echo trans('url'); ?>"
                               value="<?php echo html_escape($settings->linkedin_url); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label">VK <?php echo trans('url'); ?></label>
                        <input type="text" class="form-control" name="vk_url"
                               placeholder="VK <?php echo trans('url'); ?>" value="<?php echo html_escape($settings->vk_url); ?>">
                    </div>
                </div><!-- /.tab-pane -->

                <div class="tab-pane" id="tab_5">

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('select_color'); ?></label>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="custom-checkbox">
                                    <input type="radio" name="site_color" id="color1" value="default"
                                           class="regular-checkbox" <?php echo ($settings->site_color === "default" ||
                                        $settings->site_color === "") ? "checked" : ""; ?>/>
                                    <label for="color1"></label>
                                </div>

                                <div class="custom-checkbox color-red">
                                    <input type="radio" name="site_color" id="color2" value="red"
                                           class="regular-checkbox"
                                        <?php echo ($settings->site_color === "red") ? "checked" : ""; ?>/>
                                    <label for="color2"></label>
                                </div>

                                <div class="custom-checkbox color-green">
                                    <input type="radio" name="site_color" id="color3" value="green"
                                           class="regular-checkbox"
                                        <?php echo ($settings->site_color === "green") ? "checked" : ""; ?>/>
                                    <label for="color3"></label>
                                </div>

                                <div class="custom-checkbox color-orange">
                                    <input type="radio" name="site_color" id="color4" value="orange"
                                           class="regular-checkbox" <?php echo ($settings->site_color === "orange") ? "checked" : ""; ?>/>
                                    <label for="color4"></label>
                                </div>

                                <div class="custom-checkbox color-purple">
                                    <input type="radio" name="site_color" id="color5" value="purple"
                                           class="regular-checkbox" <?php echo ($settings->site_color === "purple") ? "checked" : ""; ?>/>
                                    <label for="color5"></label>
                                </div>

                                <div class="custom-checkbox color-mountain-meadow">
                                    <input type="radio" name="site_color" id="color6" value="mountain-meadow"
                                           class="regular-checkbox" <?php echo ($settings->site_color === "mountain-meadow") ? "checked" : ""; ?>/>
                                    <label for="color6"></label>
                                </div>

                                <div class="custom-checkbox color-blue">
                                    <input type="radio" name="site_color" id="color7" value="blue"
                                           class="regular-checkbox" <?php echo ($settings->site_color === "blue") ? "checked" : ""; ?>/>
                                    <label for="color7"></label>
                                </div>

                                <div class="custom-checkbox color-yellow">
                                    <input type="radio" name="site_color" id="color8" value="yellow"
                                           class="regular-checkbox" <?php echo ($settings->site_color === "yellow") ? "checked" : ""; ?>/>
                                    <label for="color8"></label>
                                </div>

                                <div class="custom-checkbox color-dark">
                                    <input type="radio" name="site_color" id="color9" value="dark"
                                           class="regular-checkbox" <?php echo ($settings->site_color === "dark") ? "checked" : ""; ?>/>
                                    <label for="color9"></label>
                                </div>

                                <div class="custom-checkbox color-pink">
                                    <input type="radio" name="site_color" id="color10" value="pink"
                                           class="regular-checkbox" <?php echo ($settings->site_color === "pink") ? "checked" : ""; ?>/>
                                    <label for="color10"></label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group hidden">
                        <label class="control-label"><?php echo trans('logo'); ?> (180x50 px)</label>
                        <div class="col-sm-12 p0">
                            <div class="row">
                                <div class="col-sm-3">
                                    <?php if (!empty($settings->logo_path)): ?>
                                        <img src="<?php echo base_url() . html_escape($settings->logo_path); ?>" alt="">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <a class='btn btn-default btn-sm'>
                                        <?php echo trans('change_logo'); ?>
                                        <input type="file" name="logo" size="40" class="uploadFile"
                                               accept=".png, .jpg, .jpeg, .gif"
                                               onchange="$('#upload-file-info1').html($(this).val());">
                                    </a>
                                </div>
                            </div>

                            <span class='label label-info' id="upload-file-info1"></span>
                        </div>
                    </div>
                    <br>
                    <div class="form-group hidden">
                        <label class="control-label"><?php echo trans('favicon'); ?></label>
                        <div class="col-sm-12 p0">
                            <div class="row">
                                <div class="col-sm-3">
                                    <?php if (!empty($settings->favicon_path)): ?>
                                        <img src="<?php echo base_url() . html_escape($settings->favicon_path); ?>" alt="">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <a class='btn btn-default btn-sm'>
                                        <?php echo trans('change_favicon'); ?>
                                        <input type="file" name="favicon" size="40" class="uploadFile"
                                               accept=".png, .jpg, .jpeg, .gif"
                                               onchange="$('#upload-file-info2').html($(this).val());">
                                    </a>
                                </div>
                            </div>

                            <span class='label label-info' id="upload-file-info2"></span>
                        </div>
                    </div>
                </div><!-- /.tab-pane -->

                <div class="tab-pane" id="tab_6">

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('facebook_comments_code'); ?></label>
                        <textarea class="form-control text-area" name="facebook_comment" placeholder="<?php echo trans('facebook_comments_code'); ?>"
                                  style="min-height: 140px;"><?php echo html_escape($settings->facebook_comment); ?></textarea>
                    </div>

                </div><!-- /.tab-pane -->

                <div class="tab-pane" id="tab_7">

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('head_code'); ?></label>
                        <textarea class="form-control text-area" name="head_code" placeholder="<?php echo trans('head_code'); ?>"
                                  style="min-height: 140px;"><?php echo html_escape($settings->head_code); ?></textarea>
                    </div>

                </div><!-- /.tab-pane -->

            </div><!-- /.tab-content -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
        </div><!-- nav-tabs-custom -->

        <?php echo form_close(); ?>
    </div><!-- /.col -->
</div>
