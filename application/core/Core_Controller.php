<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Core_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

    }
}

class Home_Core_Controller extends Core_Controller
{
    public function __construct()
    {
        parent::__construct();

        $global_data['settings'] = $this->settings_model->get_settings();
        $this->settings = $global_data['settings'];

        //set language
        $this->config->set_item('language', $global_data['settings']->site_lang);
        $this->lang->load("site", $this->settings->site_lang);

        //selected layout
        $global_data['layout'] = $global_data['settings']->layout;
        $this->layout = $global_data['settings']->layout;

        //main menu
        $global_data['main_menu'] = $this->navigation_model->get_menu_links();

        //get your data
        $global_data['popular_posts'] = $this->post_model->get_popular_posts();
        $global_data['our_picks'] = $this->post_model->get_our_picks();
        $global_data['random_slider_posts'] = $this->post_model->get_random_slider_posts();
        $global_data['categories'] = $this->category_model->get_categories();
        $global_data['tags'] = $this->tag_model->get_random_tags();
        $global_data['footer_random_posts'] = $this->post_model->get_footer_random_posts();

        //get site primary font
        $this->config->load('fonts');
        $global_data['primary_font'] = $global_data['settings']->primary_font;
        $global_data['primary_font_family'] = $this->config->item($global_data['primary_font'] . '_font_family');
        $global_data['primary_font_url'] = $this->config->item($global_data['primary_font'] . '_font_url');

        //get site secondary font
        $global_data['secondary_font'] = $global_data['settings']->secondary_font;
        $global_data['secondary_font_family'] = $this->config->item($global_data['secondary_font'] . '_font_family');
        $global_data['secondary_font_url'] = $this->config->item($global_data['secondary_font'] . '_font_url');

        //get site tertiary font
        $global_data['tertiary_font'] = $global_data['settings']->tertiary_font;
        $global_data['tertiary_font_family'] = $this->config->item($global_data['tertiary_font'] . '_font_family');
        $global_data['tertiary_font_url'] = $this->config->item($global_data['tertiary_font'] . '_font_url');

        $this->load->vars($global_data);
    }
}

class Admin_Core_Controller extends Core_Controller
{

    public function __construct()
    {
        parent::__construct();

        //get settings
        $global_data['settings'] = $this->settings_model->get_settings();
        $this->settings = $global_data['settings'];

        //set language
        $this->config->set_item('language', $global_data['settings']->site_lang);
        $this->lang->load("site", $this->settings->site_lang);

        $this->config->load('fonts');
        $global_data['primary_font'] = $global_data['settings']->primary_font;
        $global_data['secondary_font'] = $global_data['settings']->secondary_font;
        $global_data['tertiary_font'] = $global_data['settings']->tertiary_font;

        $this->load->vars($global_data);
    }
}