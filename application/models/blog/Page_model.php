<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Page_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'title' => $this->input->post('title', true),
            'slug' => $this->input->post('slug', true),
            'page_description' => $this->input->post('page_description', true),
            'page_keywords' => $this->input->post('page_keywords', true),
            'page_content' => $this->input->post('page_content', false),
            'page_order' => $this->input->post('page_order', true),
            'page_active' => $this->input->post('page_active', true),
            'title_active' => $this->input->post('title_active', true),
            'breadcrumb_active' => $this->input->post('breadcrumb_active', true),
            'right_column_active' => $this->input->post('right_column_active', true),
            'location' => $this->input->post('location', true),
            'need_auth' => $this->input->post('need_auth', true),
            'parent_id' => $this->input->post('parent_id', true)
        );
        return $data;
    }

    //add page
    public function add_page()
    {
        $data = $this->page_model->input_values();

        //slug for title
        if (empty($data["slug"])) {
            $data["slug"] = str_slug($data["title"]);
        }
        return $this->db->insert('pages', $data);
    }

    //update page
    public function update_page()
    {
        //set values
        $data = $this->page_model->input_values();

        //slug for title
        if (empty($data["slug"])) {
            $data["slug"] = str_slug($data["title"]);
        }

        //get id
        $id = $this->input->post('id', true);
        $this->db->where('id', $id);
        return $this->db->update('pages', $data);
    }

    //get pages
    public function get_pages()
    {
        $this->db->order_by('page_order');
        $query = $this->db->get('pages');
        return $query->result();
    }

    //get subpages
    public function get_subpages($parent_id)
    {
        $this->db->where('parent_id', $parent_id);
        $this->db->where('page_active', 1);
        $this->db->order_by('page_order');
        $query = $this->db->get('pages');
        return $query->result();
    }

    //get page
    public function get_page($slug)
    {
        $this->db->where('slug', $slug);
        $query = $this->db->get('pages');
        return $query->row();
    }

    //get page by id
    public function get_page_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('pages');
        return $query->row();
    }

    //delete page
    public function delete_page($id)
    {
        $page = $this->get_page_by_id($id);
        if (!empty($page)) {
            $this->db->where('id', $id);
            return $this->db->delete('pages');
        }
        return false;
    }
}