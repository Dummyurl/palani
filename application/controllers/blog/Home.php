<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Home_Core_Controller
{

   

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Index Page
     */
    public function index()
    {
        
        
        //initialize pagination
        $page = $this->security->xss_clean($this->uri->segment(3));
        if (empty($page)) {
            $page = 0;
        }

        if ($page != 0) {
            $page = $page - 1;
        }
        $config['base_url'] = base_url().'blog/home';
        $config['total_rows'] = $this->post_model->get_post_count();
        $config['per_page'] = $this->settings->pagination_per_page;
        $this->pagination->initialize($config);

        $data['page'] = $this->page_model->get_page('index');

        //check page auth
        $this->checkPageAuth($data['page']);

        $data['title'] = get_page_title($data['page']);
        $data['description'] = get_page_description($data['page']);
        $data['keywords'] = get_page_keywords($data['page']);

        $data['slider_posts'] = $this->post_model->get_slider_posts();
        $data['posts'] = $this->post_model->get_paginated_posts($config['per_page'], $page * $config['per_page']);

        $this->load->view('blog/partials/_header', $data);
        $this->load->view('blog/index', $data);
        $this->load->view('blog/partials/_footer');
    }


    /**
     * Gallery Page
     */
    public function gallery()
    {
        $data['page'] = $this->page_model->get_page('gallery');
        //check page auth
        $this->checkPageAuth($data['page']);

        if ($data['page']->page_active == 0) {
            $this->error_404();
        } else {
            $data['title'] = get_page_title($data['page']);
            $data['description'] = get_page_description($data['page']);
            $data['keywords'] = get_page_keywords($data['page']);

            //get gallery categories
            $data['gallery_categories'] = $this->gallery_category_model->get_categories();
            //get gallery images
            $data['gallery_images'] = $this->gallery_image_model->get_images();

            $this->load->view('blog/partials/_header', $data);
            $this->load->view('blog/gallery', $data);
            $this->load->view('blog/partials/_footer');
        }
    }


    /**
     * Contact Page
     */
    public function contact()
    {
        $data['page'] = $this->page_model->get_page('contact');
        //check page auth
        $this->checkPageAuth($data['page']);

        if ($data['page']->page_active == 0) {
            $this->error_404();
        } else {
            $data['title'] = get_page_title($data['page']);
            $data['description'] = get_page_description($data['page']);
            $data['keywords'] = get_page_keywords($data['page']);

            $this->load->view('blog/partials/_header', $data);
            $this->load->view('blog/contact', $data);
            $this->load->view('blog/partials/_footer');
        }
    }


    /**
     * Contact Page Post
     */
    public function contact_post()
    {
        //validate inputs
        $this->form_validation->set_rules('name', trans("name"), 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('email', trans("email"), 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('message', trans("message"), 'required|xss_clean|max_length[5000]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->contact_model->input_values());
            redirect($this->agent->referrer());
        } else {
            if ($this->contact_model->add_contact_message()) {
                $this->session->set_flashdata('success', trans("message_contact_success"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('form_data', $this->contact_model->input_values());
                $this->session->set_flashdata('error', trans("message_contact_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Rss Page
     */
    public function rss_channels()
    {
        $data['page'] = $this->page_model->get_page('rss-channels');

        //check page auth
        $this->checkPageAuth($data['page']);

        if ($this->settings->show_rss == 0 || $data['page']->page_active == 0) {
            $this->error_404();
        } else {

            $data['title'] = get_page_title($data['page']);
            $data['description'] = get_page_description($data['page']);
            $data['keywords'] = get_page_keywords($data['page']);

            $this->load->view('blog/partials/_header', $data);
            $this->load->view('blog/rss_channels', $data);
            $this->load->view('blog/partials/_footer');

        }
    }


    /**
     * Category Page
     */
    public function category($slug)
    {
        $slug = $this->security->xss_clean($slug);

        $data['category'] = $this->category_model->get_category_by_slug($slug);

        //check category exists
        if (empty($data['category'])) {
            redirect(base_url());
        }

        $category_id = $data['category']->id;

        $data['title'] = html_escape($data['category']->name);
        $data['description'] = html_escape($data['category']->description);
        $data['keywords'] = html_escape($data['category']->keywords);

        //initialize pagination
        $page = $this->security->xss_clean($this->input->get('page'));
        if (empty($page)) {
            $page = 0;
        }

        if ($page != 0) {
            $page = $page - 1;
        }

        $config['base_url'] = base_url() . '/category/' . $slug;
        $config['total_rows'] = $this->post_model->get_category_post_count($category_id);
        $config['per_page'] = $this->settings->pagination_per_page;
        $this->pagination->initialize($config);

        //get posts
        if ($data['category']->parent_id == 0) {
            $data['posts'] = $this->post_model->get_paginated_category_posts($category_id, $config['per_page'], $page * $config['per_page']);
        } else {
            $data['posts'] = $this->post_model->get_paginated_subcategory_posts($category_id, $config['per_page'], $page * $config['per_page']);
        }


        $this->load->view('blog/partials/_header', $data);
        $this->load->view('blog/category', $data);
        $this->load->view('blog/partials/_footer');
    }


    /**
     * Tag Page
     */
    public function tag($tag_slug)
    {
        $tag_slug = $this->security->xss_clean($tag_slug);

        $data['tag'] = $this->tag_model->get_tag($tag_slug);

        //check tag exists
        if (empty($data['tag'])) {
            redirect(base_url());
        }

        $data['title'] = html_escape($data['tag']->tag);
        $data['description'] = trans("tag") . ': ' . $data['tag']->tag;
        $data['keywords'] = trans("tag") . ', ' . $data['tag']->tag;


        //initialize pagination
        $page = $this->security->xss_clean($this->input->get('page'));
        if (empty($page)) {
            $page = 0;
        }

        if ($page != 0) {
            $page = $page - 1;
        }

        $config['base_url'] = base_url() . '/tag/' . $tag_slug;
        $config['total_rows'] = $this->post_model->get_tag_post_count($tag_slug);
        $config['per_page'] = $this->settings->pagination_per_page;
        $this->pagination->initialize($config);

        //get posts
        $data['posts'] = $this->post_model->get_paginated_tag_posts($tag_slug, $config['per_page'], $page * $config['per_page']);

        $this->load->view('blog/partials/_header', $data);
        $this->load->view('blog/tag', $data);
        $this->load->view('blog/partials/_footer');
    }


    /**
     * Profile Page
     */
    public function profile($slug)
    {
        $slug = $this->security->xss_clean($slug);

        $data['author'] = $this->auth_model->get_user_by_slug($slug);

        //check author exists
        if (empty($data['author'])) {
            redirect(base_url());
        }

        if ($data['author']->role == "user") {
            redirect(base_url());
        }

        $data['title'] = $data['author']->username;
        $data['description'] = trans("author") . ': ' . $data['author']->username;
        $data['keywords'] = trans("author") . ', ' . $data['author']->username;


        //initialize pagination
        $page = $this->security->xss_clean($this->input->get('page'));
        if (empty($page)) {
            $page = 0;
        }

        if ($page != 0) {
            $page = $page - 1;
        }

        $config['base_url'] = base_url() . '/profile/' . $slug;
        $config['total_rows'] = $this->post_model->get_post_count_by_user($data['author']->id);
        $config['per_page'] = $this->settings->pagination_per_page;
        $this->pagination->initialize($config);

        //get posts
        $data['posts'] = $this->post_model->get_paginated_user_posts($data['author']->id, $config['per_page'], $page * $config['per_page']);

        $this->load->view('blog/partials/_header', $data);
        $this->load->view('blog/profile', $data);
        $this->load->view('blog/partials/_footer');
    }

    /**
     * Reading List Page
     */
    public function reading_list()
    {
        $data["page"] = $this->page_model->get_page("reading-list");

        $data['title'] = get_page_title($data['page']);
        $data['description'] = get_page_description($data['page']);
        $data['keywords'] = get_page_keywords($data['page']);

        //initialize pagination
        $page = $this->security->xss_clean($this->input->get('page'));
        if (empty($page)) {
            $page = 0;
        }

        if ($page != 0) {
            $page = $page - 1;
        }
        $data['post_count'] = $this->reading_list_model->get_reading_list_count();

        $config['base_url'] = base_url() . '/reading-list';
        $config['total_rows'] = $data['post_count'];
        $config['per_page'] = $this->settings->pagination_per_page;
        $this->pagination->initialize($config);

        //get posts
        $data['posts'] = $this->reading_list_model->get_paginated_reading_list($config['per_page'], $page * $config['per_page']);

        $this->load->view('blog/partials/_header', $data);
        $this->load->view('blog/reading_list', $data);
        $this->load->view('blog/partials/_footer');
    }


    /**
     * Search Page
     */
    public function search()
    {
        $q = $this->input->get('q', TRUE);

        $data['q'] = $q;
        $data['title'] = html_escape(trans("search")) . ': ' . $q;
        $data['description'] = html_escape(trans("search")) . ': ' . $q;
        $data['keywords'] = html_escape(trans("search")) . ', ' . $q;

        //initialize pagination
        $page = $this->security->xss_clean($this->input->get('page'));
        if (empty($page)) {
            $page = 0;
        }

        if ($page != 0) {
            $page = $page - 1;
        }
        $data['post_count'] = $this->post_model->get_search_post_count($q);

        $config['base_url'] = base_url() . 'blog/search?q=' . $q;
        $config['total_rows'] = $data['post_count'];
        $config['per_page'] = $this->settings->pagination_per_page;
        $this->pagination->initialize($config);

        //get posts
        $data['posts'] = $this->post_model->get_paginated_search_posts($q, $config['per_page'], $page * $config['per_page']);

        $this->load->view('blog/partials/_header', $data);
        $this->load->view('blog/search', $data);
        $this->load->view('blog/partials/_footer');
    }


    /**
     * Post Page
     */
    public function post($slug)
    {
        $slug = $this->security->xss_clean($slug);

        $data['post'] = $this->post_model->get_post_details($slug);

        //check if post exists
        if (empty($data['post'])) {
            redirect(base_url().'blog');
        }

        $id = $data['post']->id;

        if (!auth_check() && $data['post']->need_auth == 1) {
            $this->session->set_flashdata('error', trans("message_post_auth"));
            redirect(base_url() . 'login');
        }

        //check visibility
        if ($data['post']->visibility != 1) {
            redirect(base_url());
        }

        $data['post_image_count'] = $this->post_image_model->get_post_image_count($id);
        $data['post_images'] = $this->post_image_model->get_post_images($id);
        $data['post_tags'] = $this->tag_model->get_post_tags($id);
        $data['related_posts'] = $this->post_model->get_related_posts($data['post']->category_id, $id);
        $data['comments'] = $this->comment_model->get_limited_comments($id, 5);
        $data['comment_count'] = $this->comment_model->get_post_comment_count($id);

        $data['is_reading_list'] = $this->reading_list_model->is_post_in_reading_list($id);

        $data['page_type'] = "post";
        //set og tags
        $data['og_type'] = "article";
        $data['og_url'] = base_url() . "post/" . html_escape($data['post']->title_slug);
        $data['og_image'] = base_url() . $data['post']->image_mid;

        $data['title'] = html_escape($data['post']->title);
        $data['description'] = html_escape($data['post']->title);
        $data['keywords'] = html_escape($data['post']->keywords);

        

        $this->load->view('blog/partials/_header', $data);
        $this->load->view('blog/post', $data);
        $this->load->view('blog/partials/_footer', $data);

        //increase post hit
        $this->load->helper('cookie');
        $this->post_model->increase_post_hit($id);

    }


    /**
     * Dynamic Page by Name Slug
     */
    public function get_page($slug)
    {
        $slug = $this->security->xss_clean($slug);

        //index page
        if (empty($slug)) {
            redirect(base_url());
        }

        $data['page'] = $this->page_model->get_page($slug);
        //check page auth
        $this->checkPageAuth($data['page']);

        //if not exists
        if (empty($data['page']) || $data['page'] == null) {
            $this->error_404();
        } //check if page disable
        else if ($data['page']->page_active == 0 || $data['page']->link != '') {
            $this->error_404();
        } else {
            $data['title'] = get_page_title($data['page']);
            $data['description'] = get_page_description($data['page']);
            $data['keywords'] = get_page_keywords($data['page']);

            $this->load->view('blog/partials/_header', $data);
            $this->load->view('blog/page', $data);
            $this->load->view('blog/partials/_footer');

        }
    }


    /**
     * Add or Delete from Reading List
     */
    public function add_delete_from_reading_list_post()
    {
        $post_id = $this->input->post('post_id');

        if (empty($post_id)) {
            redirect($this->agent->referrer());
        }

        $is_post_in_reading_list = $this->reading_list_model->is_post_in_reading_list($post_id);

        //delete from list
        if ($is_post_in_reading_list == true) {
            $this->reading_list_model->delete_from_reading_list($post_id);
        } else {
            //add to list
            $this->reading_list_model->add_to_reading_list($post_id);
        }

        redirect($this->agent->referrer());
    }


    /**
     * Add Comment
     */
    public function add_comment_post()
    {
        //input values
        $data = $this->comment_model->input_values();
        $count = $this->input->post('count', true);

        if ($data['post_id'] && $data['user_id'] && $data['comment']) {
            $this->comment_model->add_comment();
        }

        $data['visible_comment_count'] = $count;
        $data['comments'] = $this->comment_model->get_limited_comments($data['post_id'], $count);
        $data['comment_count'] = $this->comment_model->get_post_comment_count($data['post_id']);


        $this->load->view('blog/partials/_comments', $data);
    }


    /**
     * Delete Comment
     */
    public function delete_comment_post()
    {
        $id = $this->input->post('id', true);
        $count = $this->input->post('count', true);

        $comment = $this->comment_model->get_comment($id);
        $post_id = 0;
        //if comment exists
        if (!empty($comment)) {
            $post_id = $comment->post_id;
            $this->comment_model->delete_comment($id);
        }

        $data['visible_comment_count'] = $count;
        $data['comments'] = $this->comment_model->get_limited_comments($post_id, $count);
        $data['comment_count'] = $this->comment_model->get_post_comment_count($post_id);
        $this->load->view('blog/partials/_comments', $data);
    }

    /**
     * Load More Comments
     */
    public function load_more_comments()
    {
        //input values
        $post_id = $this->input->post('post_id', true);
        $count = $this->input->post('count', true);

        $count = $count + 5;

        $data['visible_comment_count'] = $count;
        $data['comments'] = $this->comment_model->get_limited_comments($post_id, $count);
        $data['comment_count'] = $this->comment_model->get_post_comment_count($post_id);
        $this->load->view('blog/partials/_comments', $data);
    }


    /**
     * Add to Newsletter
     */
    public function add_to_newsletter()
    {
        //input values
        $email = $this->input->post('email', true);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->session->set_flashdata('news_error', trans("message_invalid_email"));
        } else {
            if ($email) {
                //check if email exists
                if (empty($this->newsletter_model->get_newsletter($email))) {
                    //addd
                    if ($this->newsletter_model->add_to_newsletter($email)) {
                        $this->session->set_flashdata('news_success', trans("message_newsletter_success"));
                    }
                } else {
                    $this->session->set_flashdata('news_error', trans("message_newsletter_error"));
                }
            }

        }

        redirect($this->agent->referrer() . "#newsletter");
    }

    /**
     * Get Gallery Photos by Category
     */
    public function gallery_get_images_post()
    {
        $data['selected_id'] = $this->input->post('id', true);

        if ($data['selected_id'] == 0) {
            $data['images'] = $this->gallery_image_model->get_images();
        } else {
            $data['images'] = $this->gallery_image_model->get_images_by_category($data['selected_id']);
        }

        $data['categories'] = $this->gallery_category_model->get_categories();
        $this->load->view('blog/partials/_get_photos', $data);
    }

    public function checkPageAuth($page)
    {
        if (!empty($page)) {
            if (!auth_check() && $page->need_auth == 1) {
                $this->session->set_flashdata('error', trans("message_page_auth"));
                redirect(base_url() . 'login');
            }
        }
    }

    public function error_404()
    {
        $data['title'] = "Error 404";
        $data['description'] = "Error 404";
        $data['keywords'] = "error,404";

        $this->load->view('blog/partials/_header', $data);
        $this->load->view('blog/errors/error_404');
        $this->load->view('blog/partials/_footer');
    }


}
