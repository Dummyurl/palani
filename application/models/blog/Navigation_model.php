<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Navigation_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'title' => $this->input->post('title', true),
            'link' => $this->input->post('link', true),
            'page_order' => $this->input->post('page_order', true),
            'page_active' => $this->input->post('page_active', true),
            'parent_id' => $this->input->post('parent_id', true),
        );
        return $data;
    }

    //add link
    public function add_link()
    {
        $data = $this->input_values();

        //slug for title
        if (empty($data["slug"])) {
            $data["slug"] = str_slug($data["title"]);
        }

        return $this->db->insert('pages', $data);
    }

    //update link
    public function update_link($id)
    {
        $data = $this->input_values();
        //slug for title
        if (empty($data["slug"])) {
            $data["slug"] = str_slug($data["title"]);
        }

        $this->db->where('id', $id);
        return $this->db->update('pages', $data);
    }

    //get parent link
    public function get_parent_link($parent_id, $type)
    {
        if ($type == "page" || $type == "link") {
            $this->db->where('id', $parent_id);
            $query = $this->db->get('pages');
            return $query->row();
        }
        if ($type == "category") {
            $this->db->where('id', $parent_id);
            $query = $this->db->get('categories');
            return $query->row();
        }
    }

    //get parent links
    public function get_menu_links()
    {
        $menu = array();
        foreach ($this->page_model->get_pages() as $page) {
            $item = array(
                'order' => $page->page_order,
                'id' => $page->id,
                'parent_id' => $page->parent_id,
                'title' => $page->title,
                'slug' => $page->slug,
                'link' => base_url() . $page->slug,
                'type' => "page",
                'location' => $page->location,
                'visibility' => $page->page_active,
            );

            if (!empty($page->link)) {
                $item["link"] = $page->link;
                $item["type"] = "link";
            }

            array_push($menu, $item);
        }

        foreach ($this->category_model->get_categories() as $category) {
            $item = array(
                'order' => $category->category_order,
                'id' => $category->id,
                'parent_id' => $category->parent_id,
                'title' => $category->name,
                'slug' => $category->slug,
                'link' => base_url() . "category/" . $category->slug,
                'type' => "category",
                'location' => "header",
                'visibility' => $category->show_on_menu,
            );
            array_push($menu, $item);
        }

        sort($menu);
        return $menu;
    }

    //get sub links
    public function get_sub_links($id, $type)
    {
        $menu = array();

        if ($type == "page" || $type == "link") {

            foreach ($this->page_model->get_subpages($id) as $page) {
                $item = array(
                    'order' => $page->page_order,
                    'id' => $page->id,
                    'parent_id' => $page->parent_id,
                    'title' => $page->title,
                    'slug' => $page->slug,
                    'link' => base_url() . $page->slug,
                    'type' => "page",
                    'visibility' => $page->page_active,
                );

                if (!empty($page->link)) {
                    $item["link"] = $page->link;
                }
                array_push($menu, $item);
            }

        }

        if ($type == "category") {

            foreach ($this->category_model->get_subcategories_by_parent_id($id) as $category) {
                $item = array(
                    'order' => $category->category_order,
                    'id' => $category->id,
                    'parent_id' => $category->parent_id,
                    'title' => $category->name,
                    'slug' => $category->slug,
                    'link' => base_url() . "category/" . $category->slug,
                    'type' => "category",
                    'visibility' => $category->show_on_menu,
                );
                array_push($menu, $item);
            }

        }

        sort($menu);
        return $menu;
    }

    //update menu limit
    public function update_menu_limit()
    {
        $data = array(
            'menu_limit' => $this->input->post('menu_limit', true),
        );

        $this->db->where('id', 1);
        return $this->db->update('settings', $data);
    }
}