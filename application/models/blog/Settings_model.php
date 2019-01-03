<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'application_name' => $this->input->post('application_name', true),
            'registration_system' => $this->input->post('registration_system', true),
            'comment_system' => $this->input->post('comment_system', true),
            'slider_active' => $this->input->post('slider_active', true),
            'site_color' => $this->input->post('site_color', true),
            'site_lang' => $this->input->post('site_lang', true),
            'show_pageviews' => $this->input->post('show_pageviews', true),
            'show_rss' => $this->input->post('show_rss', true),
            'facebook_url' => $this->input->post('facebook_url', true),
            'twitter_url' => $this->input->post('twitter_url', true),
            'google_url' => $this->input->post('google_url', true),
            'instagram_url' => $this->input->post('instagram_url', true),
            'pinterest_url' => $this->input->post('pinterest_url', true),
            'linkedin_url' => $this->input->post('linkedin_url', true),
            'vk_url' => $this->input->post('vk_url', true),
            'optional_url_button_name' => $this->input->post('optional_url_button_name', true),
            'logo_path' => $this->input->post('logo_path', true),
            'favicon_path' => $this->input->post('favicon_path', true),
            'about_footer' => $this->input->post('about_footer', true),
            'head_code' => $this->input->post('head_code', false),
            'copyright' => $this->input->post('copyright', true),
            'contact_text' => $this->input->post('contact_text', false),
            'contact_address' => $this->input->post('contact_address', true),
            'contact_email' => $this->input->post('contact_email', true),
            'contact_phone' => $this->input->post('contact_phone', true),
            'mail_protocol' => $this->input->post('mail_protocol', true),
            'mail_host' => $this->input->post('mail_host', true),
            'mail_port' => $this->input->post('mail_port', true),
            'mail_username' => $this->input->post('mail_username', true),
            'mail_password' => $this->input->post('mail_password', true),
            'mail_title' => $this->input->post('mail_title', true),
            'facebook_comment' => $this->input->post('facebook_comment', false),
            'pagination_per_page' => $this->input->post('pagination_per_page', true)
        );
        return $data;
    }

    //get settings
    public function get_settings()
    {
        $query = $this->db->get_where('settings', array('id' => 1));
        return $query->row();
    }

    //update settings
    public function update_settings()
    {
        $data = $this->settings_model->input_values();

        //get file
        $file = $_FILES['logo'];
        if (!empty($file['name'])) {
            //upload logo
            $data["logo_path"] = $this->upload_model->logo_upload($file);
        }

        //get file
        $file = $_FILES['favicon'];
        if (!empty($file['name'])) {
            //upload logo
            $data["favicon_path"] = $this->upload_model->favicon_upload($file);
        }

        $this->db->where('id', 1);
        return $this->db->update('settings', $data);
    }

    //update layout
    public function update_layout()
    {
        $data = array(
            'layout' => $this->input->post('layout', true),
        );

        $this->db->where('id', 1);
        return $this->db->update('settings', $data);
    }


    //send email
    public function send_email($to, $subject, $message)
    {
        $this->load->library('email');

        $settings = $this->settings_model->get_settings();

        if ($settings->mail_protocol == "mail") {
            $config = Array(
                'protocol' => 'mail',
                'smtp_host' => $settings->mail_host,
                'smtp_port' => $settings->mail_port,
                'smtp_user' => $settings->mail_username,
                'smtp_pass' => $settings->mail_password,
                'smtp_timeout' => 100,
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE
            );
        } else {
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => $settings->mail_host,
                'smtp_port' => $settings->mail_port,
                'smtp_user' => $settings->mail_username,
                'smtp_pass' => $settings->mail_password,
                'smtp_timeout' => 100,
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE
            );
        }

        //initialize
        $this->email->initialize($config);

        //send email
        $this->email->from($settings->mail_username, $settings->mail_title);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        $this->email->set_newline("\r\n");

        return $this->email->send();
    }

}