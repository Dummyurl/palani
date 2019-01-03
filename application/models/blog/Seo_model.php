<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Seo_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'site_title' => $this->input->post('site_title', true),
            'google_analytics' => $this->input->post('google_analytics', false),
        );
        return $data;
    }

    //update seo tools
    public function update()
    {
        $data = $this->input_values();

        $this->update_home_page();

        $this->db->where('id', 1);
        return $this->db->update('settings', $data);
    }

    public function update_home_page()
    {
        $page = $this->page_model->get_page('index');

        if (!empty($page)) {

            $data = array(
                'title' => $this->input->post('title', true),
                'page_description' => $this->input->post('page_description', true),
                'page_keywords' => $this->input->post('page_keywords', true),
            );

            $this->db->where('id', $page->id);
            $this->db->update('pages', $data);
        }
    }
}