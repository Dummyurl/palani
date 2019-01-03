<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--navigation-->
<div class="nav-desktop">
    <div class="collapse navbar-collapse navbar-left">
        <ul class="nav navbar-nav">
            <?php $total_item = 0; ?>
            <?php $menu_item_count = 1; ?>

            <?php foreach ($main_menu as $menu_item): ?>

                <?php if ($menu_item['visibility'] == 1 && $menu_item['location'] == "header" && $menu_item['parent_id'] == "0"): ?>
                    <?php if ($menu_item_count <= $settings->menu_limit && $menu_item['visibility'] == 1 && $menu_item['location'] == "header" && $menu_item['parent_id'] == "0"): ?>

                        <?php $sub_links = helper_get_sub_menu_links($menu_item['id'], $menu_item['type']); ?>

                        <?php if (!empty($sub_links)): ?>

                            <li class="dropdown <?php echo (uri_string() == 'category/' . $menu_item['slug'] ||
                            uri_string() == $menu_item['slug'] || (uri_string() == "" && $menu_item['slug'] == "index")) ? 'active' : ''; ?>">
                            <a class="dropdown-toggle disabled" data-toggle="dropdown"
                            href="<?php echo $menu_item['link']; ?>">
                            <?php echo html_escape($menu_item['title']); ?>
                            <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu-cnt">
                            <ul class="dropdown-menu top-dropdown">

                                <?php foreach ($sub_links as $sub_item): ?>
                                    <?php if ($sub_item["visibility"] == 1): ?>
                                        <li>
                                            <a role="menuitem" href="<?php echo $sub_item['link']; ?>">
                                                <?php echo html_escape($sub_item['title']); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>


                            </ul>
                        </div>
                    </li>

                    <?php else: ?>
                        <li class="<?php echo (uri_string() == 'category/' . $menu_item['slug'] ||
                        uri_string() == $menu_item['slug'] || (uri_string() == "" && $menu_item['slug'] == "index")) ? 'active' : ''; ?>">
                        <a href="<?php echo $menu_item['link']; ?>">
                            <?php echo html_escape($menu_item['title']); ?>
                        </a>
                    </li>
                <?php endif; ?>


                <?php $menu_item_count++; ?>
            <?php endif; ?>
            <?php $total_item++; ?>
        <?php endif; ?>

    <?php endforeach; ?>

    <?php if ($total_item > $settings->menu_limit): ?>
        <li class="dropdown">
            <a class="dropdown-toggle dropdown-more" data-toggle="dropdown" href="#">
                <i class="fa fa-ellipsis-h more-sign"></i>
            </a>

            <div class="dropdown-menu-cnt-more">
                <ul class="dropdown-menu top-dropdown">
                    <?php $menu_item_count = 1; ?>
                    <?php foreach ($main_menu as $menu_item): ?>

                        <?php if ($menu_item['visibility'] == 1 && $menu_item['location'] == "header" && $menu_item['parent_id'] == "0"): ?>
                            <?php if ($menu_item_count > $settings->menu_limit): ?>

                                <?php $sub_links = helper_get_sub_menu_links($menu_item['id'], $menu_item['type']); ?>

                                <?php if (!empty($sub_links)): ?>

                                    <li class="li-sub-dropdown">
                                        <a class="dropdown-toggle disabled" data-toggle="dropdown"
                                        href="<?php echo $menu_item['link']; ?>">
                                        <?php echo html_escape($menu_item['title']); ?> <span
                                        class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu sub-dropdown">

                                        <?php foreach ($sub_links as $sub_item): ?>
                                            <?php if ($sub_item["visibility"] == 1): ?>
                                                <li>
                                                    <a role="menuitem" href="<?php echo $sub_item['link']; ?>">
                                                        <?php echo html_escape($sub_item['title']); ?>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                    </ul>
                                </li>

                                <?php else: ?>
                                    <li>
                                        <a href="<?php echo $menu_item['link']; ?>">
                                            <?php echo html_escape($menu_item['title']); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>


                            <?php endif; ?>

                            <?php $menu_item_count++; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>

            </div>
        </li>
    <?php endif; ?>
</ul>

<ul class="nav navbar-nav nav-right">
    <?php if (auth_check()) : ?>
        <li class="dropdown profile-dropdown nav-item-right">
            <a href="#" class="dropdown-toggle image-profile-drop" data-toggle="dropdown"
            aria-expanded="false">
            <?php 
            $currentuser = get_userdata();
            $profile_img = '';
            $social_profile_img = '';
            if(isset($currentuser['profile_img'])&&!empty($currentuser['profile_img'])){
                $profile_img = $currentuser['profile_img'];
            }                           
            if(isset($currentuser['picture_url'])&&!empty($currentuser['picture_url'])){
                $social_profile_img = $currentuser['picture_url'];
            }
            $img1 = '';
            if($social_profile_img != ''){
                $img1 = $social_profile_img;
            }
            if($profile_img != ''){
                $file_to_check = FCPATH . '/assets/images/' . $profile_img;
                if (file_exists($file_to_check)) {
                    $img1 = base_url() . 'assets/images/'.$profile_img;
                }
            }
            $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
            
            ?>                        
            <img src="<?php echo $img; ?>"   alt="<?php echo html_escape(user()->username); ?>">
            <?php echo html_escape(character_limiter(user()->username, 20, '...')); ?>&nbsp;<i
            class="caret"></i>
        </a>
        <div class="dropdown-menu-cnt">
            <ul class="dropdown-menu top-dropdown">
                <?php if (is_admin() || is_author()): ?>
                <li>
                    <a href="<?php echo base_url(); ?>blog/admin">
                        <i class="fa fa-cog"></i>&nbsp;
                        <?php echo html_escape(trans("admin_panel")); ?>
                    </a>
                </li>
                               <!--  <li>
                                    <a href="<?php echo base_url(); ?>profile/<?php echo user()->slug; ?>">
                                        <i class="fa fa-bars"></i>&nbsp;
                                        <?php echo html_escape(trans("my_posts")); ?>
                                    </a>
                                </li> -->
                            <?php endif; ?>
                            <li>
                                <a href="<?php echo base_url(); ?>reading-list">
                                    <i class="fa fa-star"></i>&nbsp;
                                    <?php echo html_escape(trans("reading_list")); ?>
                                </a>
                            </li>
                           <!--  <li>
                                <a href="<?php echo base_url(); ?>update-profile">
                                    <i class="fa fa-user"></i>&nbsp;
                                    <?php echo html_escape(trans("update_profile")); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>change-password">
                                    <i class="fa fa-lock"></i>&nbsp;
                                    <?php echo html_escape(trans("change_password")); ?>
                                </a>
                            </li> -->
                            <li>
                                <a href="<?php echo base_url(); ?>logout"
                                 onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                                 <i class="fa fa-sign-out"></i>&nbsp;
                                 <?php echo html_escape(trans("logout")); ?>
                             </a>

                             <?php echo form_open('logout', array('id' => 'logout-form', 'class' => 'hidden', 'method' => 'get')); ?>
                             <?php echo form_close(); ?>
                         </li>
                     </ul>
                 </div>
             </li>
             <?php else : ?>
                <?php if ($this->settings->registration_system == 1): ?>
                    <li class="nav-item-right <?php echo (uri_string() == 'login') ? 'active' : ''; ?>">
                        <a href="<?php echo base_url(); ?>login">
                            <?php echo html_escape(trans("login")); ?>
                        </a>
                    </li>
                    <li class="nav-item-right <?php echo (uri_string() == 'register') ? 'active' : ''; ?>">
                        <a href="<?php echo base_url(); ?>register">
                            <?php echo html_escape(trans("register")); ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <li class="nav-item-right">
                <a href="#" data-toggle="modal-search" class="search-icon"><i class="fa fa-search"></i></a>
            </li>
        </ul>


    </div>
</div>

<!--navigation-->
<div class="nav-mobile">
    <div class="collapse navbar-collapse navbar-left">
        <div class="row">
            <ul class="nav navbar-nav">

                <?php foreach ($main_menu as $menu_item): ?>
                    <?php if ($menu_item['visibility'] == 1 && $menu_item['parent_id'] == "0" && ($menu_item['location'] == "header" || $menu_item['location'] == "footer")): ?>

                        <?php $sub_links = helper_get_sub_menu_links($menu_item['id'], $menu_item['type']); ?>

                        <?php if (!empty($sub_links)): ?>

                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="<?php echo $menu_item['link']; ?>">
                                    <?php echo html_escape($menu_item['title']); ?>
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php if ($menu_item['type'] == "category"): ?>
                                        <li>
                                            <a role="menuitem" href="<?php echo $menu_item['link']; ?>">
                                                <?php echo trans("all"); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php foreach ($sub_links as $sub_item): ?>
                                        <?php if ($sub_item["visibility"] == 1): ?>
                                            <li>
                                                <a role="menuitem" href="<?php echo $sub_item['link']; ?>">
                                                    <?php echo html_escape($sub_item['title']); ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                </ul>
                            </li>

                            <?php else: ?>
                                <li>
                                    <a href="<?php echo $menu_item['link']; ?>">
                                        <?php echo html_escape($menu_item['title']); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                        <?php endif; ?>
                    <?php endforeach; ?>


                    <?php if (auth_check()) : ?>
                        <li class="dropdown profile-dropdown nav-item-right">

                            <a href="#" class="dropdown-toggle image-profile-drop" data-toggle="dropdown"
                            aria-expanded="false">
                            <?php if (!empty(user()->avatar)) : ?>
                                <img src="<?php echo base_url() . user()->avatar; ?>"
                                alt="<?php echo html_escape(user()->username); ?>">
                                <?php else : ?>
                                    <img src="<?php echo base_url(); ?>blog_assets/img/user.png"
                                    alt="<?php echo html_escape(user()->username); ?>">
                                <?php endif; ?>
                                <?php echo html_escape(character_limiter(user()->username, 20, '...')); ?>&nbsp;<i
                                class="caret"></i>
                            </a>

                            <ul class="dropdown-menu">
                                <?php if (is_admin() || is_author()): ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin">
                                        <i class="fa fa-cog"></i>&nbsp;
                                        <?php echo html_escape(trans("admin_panel")); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>profile/<?php echo user()->slug; ?>">
                                        <i class="fa fa-bars"></i>&nbsp;
                                        <?php echo html_escape(trans("my_posts")); ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li>
                                <a href="<?php echo base_url(); ?>reading-list">
                                    <i class="fa fa-star"></i>&nbsp;
                                    <?php echo html_escape(trans("reading_list")); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>update-profile">
                                    <i class="fa fa-user"></i>&nbsp;
                                    <?php echo html_escape(trans("update_profile")); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>change-password">
                                    <i class="fa fa-lock"></i>&nbsp;
                                    <?php echo html_escape(trans("change_password")); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>logout"
                                 onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                                 <i class="fa fa-sign-out"></i>&nbsp;
                                 <?php echo html_escape(trans("logout")); ?>
                             </a>

                             <?php echo form_open('logout', array('id' => 'logout-form', 'class' => 'hidden', 'method' => 'get')); ?>
                             <?php echo form_close(); ?>
                         </li>
                     </ul>
                 </li>
                 <?php else : ?>
                    <?php if ($this->settings->registration_system == 1): ?>
                        <li class="nav-item-right <?php echo (uri_string() == 'login') ? 'active' : ''; ?>">
                            <a href="<?php echo base_url(); ?>login">
                                <?php echo html_escape(trans("login")); ?>
                            </a>
                        </li>
                        <li class="nav-item-right <?php echo (uri_string() == 'register') ? 'active' : ''; ?>">
                            <a href="<?php echo base_url(); ?>register">
                                <?php echo html_escape(trans("register")); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
