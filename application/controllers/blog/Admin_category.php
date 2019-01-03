<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_category extends Admin_Core_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    public function __construct()
    {
        parent::__construct();

        //check auth
        if (!is_admin() && !is_author()) {
            redirect('login');
        }
    }


    /**
     * Categories
     */
    public function categories()
    {
        prevent_author();
        $data['title'] = trans("categories");
        $data['categories'] = $this->category_model->get_categories();

        $this->load->view('blog/admin/_header', $data);
        $this->load->view('blog/admin/categories', $data);
        $this->load->view('blog/admin/_footer');
    }

    /**
     * Add Category Post
     */
    public function add_category_post()
    {
        prevent_author();

        //validate inputs
        $this->form_validation->set_rules('name', trans("category_name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors_form', validation_errors());
            $this->session->set_flashdata('form_data', $this->category_model->input_values());
            redirect($this->agent->referrer());
        } else {
            if ($this->category_model->add_category()) {
                //last id
                $last_id = $this->db->insert_id();
                //update slug
                $this->category_model->update_slug($last_id);
                $this->session->set_flashdata('success_form', trans("category") . " " . trans("msg_suc_added"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('form_data', $this->category_model->input_values());
                $this->session->set_flashdata('error_form', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Update Category
     */
    public function update_category()
    {
        prevent_author();

        $id = $this->input->get("id");

        $data['title'] = trans("update_category");
        //get category
        $data['category'] = $this->category_model->get_category($id);

        if (empty($data['category'])) {
            redirect($this->agent->referrer());
        }

        $data['categories'] = $this->category_model->get_categories();

        $this->load->view('blog/admin/_header', $data);
        $this->load->view('blog/admin/update_category', $data);
        $this->load->view('blog/admin/_footer');
    }


    /**
     * Update Category Post
     */
    public function update_category_post()
    {
        prevent_author();

        //validate inputs
        $this->form_validation->set_rules('name', trans("category_name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->category_model->input_values());
            redirect($this->agent->referrer());
        } else {
            //category id
            $id = $this->input->post('category_id', true);
            $parent_id = $this->input->post('parent_id', true);
            if ($this->category_model->update_category($id)) {

                //update slug
                $this->category_model->update_slug($id);

                $redirect_url = $this->input->post('redirect_url', true);

                $this->session->set_flashdata('success', trans("category") . " " . trans("msg_suc_updated"));

                if (!empty($redirect_url)) {
                    redirect('admin/' . $redirect_url);
                } else {
                    if ($parent_id != 0):
                        redirect('admin_category/subcategories');
                    else:
                        redirect('admin_category/categories');
                    endif;
                }

            } else {
                $this->session->set_flashdata('form_data', $this->category_model->input_values());
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Delete Category Post
     */
    public function delete_category_post()
    {
        prevent_author();

        $id = $this->input->post('category_id', true);

        //check subcategories
        if (count($this->category_model->get_subcategories_by_parent_id($id)) > 0) {
            $this->session->set_flashdata('error', trans("msg_delete_subcategories"));
            redirect($this->agent->referrer());
        }

        //check if category has posts
        if ($this->post_model->get_all_category_post_count($id) > 0) {
            $this->session->set_flashdata('error', trans("msg_delete_posts"));
            redirect($this->agent->referrer());
        }

        if ($this->category_model->delete_category($id)) {
            $this->session->set_flashdata('success', trans("category") . " " . trans("msg_suc_deleted"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }


    /**
     * Subcategories
     */
    public function subcategories()
    {
        prevent_author();
        $data['title'] = trans("subcategories");
        $data['categories'] = $this->category_model->get_categories();
        $data['subcategories'] = $this->category_model->get_subcategories();

        $this->load->view('blog/admin/_header', $data);
        $this->load->view('blog/admin/subcategories', $data);
        $this->load->view('blog/admin/_footer');
    }

    //get sub categorie
    public function get_sub_categories()
    {
        $id = $this->input->post('parent_id', true);

        $data['subcategories'] = $this->category_model->get_subcategories_by_parent_id($id);
        $this->load->view('blog/admin/_get_sub_categories', $data);
    }

    /**
     * Gallery Category
     */
    public function gallery_categories()
    {
        prevent_author();
        $data['title'] = trans("categories");

        $data['categories'] = $this->gallery_category_model->get_categories();

        $this->load->view('blog/admin/_header', $data);
        $this->load->view('blog/admin/gallery_categories', $data);
        $this->load->view('blog/admin/_footer');
    }


    /**
     * Add Gallery Category Post
     */
    public function add_gallery_category_post()
    {
        prevent_author();

        //validate inputs
        $this->form_validation->set_rules('name', trans("category_name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors_form', validation_errors());
            $this->session->set_flashdata('form_data', $this->gallery_category_model->input_values());
            redirect($this->agent->referrer());
        } else {
            if ($this->gallery_category_model->add_category()) {
                $this->session->set_flashdata('success_form', trans("category") . " " . trans("msg_suc_added"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('form_data', $this->gallery_category_model->input_values());
                $this->session->set_flashdata('error_form', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Update Gallery Category
     */
    public function update_gallery_category()
    {
        $id = $this->input->get("id");

        prevent_author();
        $data['title'] = trans("update_category");
        //get category
        $data['category'] = $this->gallery_category_model->get_category($id);

        if (empty($data['category'])) {
            redirect($this->agent->referrer());
        }

        $this->load->view('blog/admin/_header', $data);
        $this->load->view('blog/admin/update_gallery_category', $data);
        $this->load->view('blog/admin/_footer');
    }


    /**
     * Update Gallery Category Post
     */
    public function update_gallery_category_post()
    {
        prevent_author();

        //validate inputs
        $this->form_validation->set_rules('name', trans("category_name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->gallery_category_model->input_values());
            redirect($this->agent->referrer());
        } else {
            //category id
            $id = $this->input->post('category_id', true);
            if ($this->gallery_category_model->update_category($id)) {
                $this->session->set_flashdata('success', trans("category") . " " . trans("msg_suc_updated"));
                redirect('admin_category/gallery_categories');
            } else {
                $this->session->set_flashdata('form_data', $this->gallery_category_model->input_values());
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Delete Gallery Category Post
     */
    public function delete_gallery_category_post()
    {
        prevent_author();

        $id = $this->input->post('category_id', true);

        //check if category has posts
        if ($this->gallery_image_model->get_category_image_count($id) > 0) {
            $this->session->set_flashdata('error', trans("msg_delete_images"));
            redirect($this->agent->referrer());
        }

        if ($this->gallery_category_model->delete_category($id)) {
            $this->session->set_flashdata('success', trans("category") . " " . trans("msg_suc_deleted"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }


}
