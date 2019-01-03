<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'name' => $this->input->post('name', true),
            'slug' => $this->input->post('slug', true),
            'description' => $this->input->post('description', true),
            'keywords' => $this->input->post('keywords', true),
            'parent_id' => $this->input->post('parent_id', true),
            'category_order' => $this->input->post('category_order', true),
            'show_on_menu' => $this->input->post('show_on_menu', true),
        );
        return $data;
    }

    //add category
    public function add_category()
    {
        $data = $this->input_values();

        //slug for title
        if (empty($data["slug"])) {
            $data["slug"] = str_slug($data["name"]);
        }

        return $this->db->insert('categories', $data);
    }

    //update category
    public function update_category($id)
    {
        $data = $this->input_values();

        //slug for title
        if (empty($data["slug"])) {
            $data["slug"] = str_slug($data["name"]);
        }

        $this->db->where('id', $id);
        return $this->db->update('categories', $data);
    }

    //update slug
    public function update_slug($id)
    {
        $category = $this->get_category($id);

        if (!empty($this->get_distinct_category_by_slug($category->slug, $id))) {
            $data = array(
                'slug' => $category->slug . "-" . $category->id
            );

            $this->db->where('id', $id);
            return $this->db->update('categories', $data);
        }
    }

    //get post
    public function get_distinct_category_by_slug($slug, $id)
    {
        $this->db->where('categories.slug', $slug);
        $this->db->where('categories.id !=', $id);
        $query = $this->db->get('categories');
        return $query->row();
    }

    //get category
    public function get_category($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('categories');
        return $query->row();
    }

    //get category by slug
    public function get_category_by_slug($slug)
    {
        $this->db->where('categories.slug', $slug);
        $query = $this->db->get('categories');
        return $query->row();
    }

    //get categories
    public function get_categories()
    {
        $this->db->where('parent_id', 0);
        $this->db->order_by('category_order');
        $query = $this->db->get('categories');
        return $query->result();
    }

    //get subcategories
    public function get_subcategories()
    {
        $this->db->where('parent_id !=', 0);
        $this->db->order_by('name');
        $query = $this->db->get('categories');
        return $query->result();
    }

    //get subcategories by id
    public function get_subcategories_by_parent_id($parent_id)
    {
        $this->db->where('parent_id', $parent_id);
        $this->db->order_by('name');
        $query = $this->db->get('categories');
        return $query->result();
    }

    //get category count
    public function get_category_count()
    {
        $query = $this->db->get('categories');
        return $query->num_rows();
    }

    //delete category
    public function delete_category($id)
    {
        $category = $this->get_category($id);
        if (!empty($category)) {
            $this->db->where('id', $id);
            return $this->db->delete('categories');
        }
        return false;
    }

}