<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Home_Core_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('bcrypt');
    }


    /**
     * Login
     */
    public function login()
    {

        
        //check if logged in
        if ($this->auth_model->is_logged_in() == true) {
            redirect(base_url());
        }

        $data["page"] = $this->page_model->get_page("login");

        $data['title'] = get_page_title($data['page']);
        $data['description'] = get_page_description($data['page']);
        $data['keywords'] = get_page_keywords($data['page']);

        $this->load->view('blog/partials/_header', $data);
        $this->load->view('blog/auth/login');
        $this->load->view('blog/partials/_footer');
    }


    /**
     * Login Post
     */
    public function login_post()
    {


        //check if logged in
        if ($this->auth_model->is_logged_in() == true) {
            redirect(base_url());
        }

        //validate inputs
        $this->form_validation->set_rules('username', trans("username"), 'required|xss_clean|max_length[100]');
        $this->form_validation->set_rules('password', trans("password"), 'required|xss_clean|max_length[30]');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            redirect($this->agent->referrer());
        } else {

            $result = $this->auth_model->login();

            if ($result == "banned") {
                //user banned
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("message_ban_error"));
                redirect($this->agent->referrer());

            } elseif ($result == "success") {
                redirect(base_url());
            } else {
                //error
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("login_error"));
                redirect($this->agent->referrer());
            }

        }
    }


    /**
     * Register
     */
    public function register()
    {
        //check if logged in
        if ($this->auth_model->is_logged_in() == true) {
            redirect(base_url());
        }

        $this->is_registration_active();

        $data["page"] = $this->page_model->get_page("register");

        $data['title'] = get_page_title($data['page']);
        $data['description'] = get_page_description($data['page']);
        $data['keywords'] = get_page_keywords($data['page']);

        $this->load->view('blog/partials/_header', $data);
        $this->load->view('blog/auth/register');
        $this->load->view('blog/partials/_footer');
    }


    /**
     * Register Post
     */
    public function register_post()
    {
        //check if logged in
        if ($this->auth_model->is_logged_in() == true) {
            redirect(base_url());
        }

        //validate inputs
        $this->form_validation->set_rules('username', trans("username"), 'required|xss_clean|min_length[4]|max_length[100]|is_unique[users.username]');
        $this->form_validation->set_rules('email', trans("email"), 'required|xss_clean|max_length[200]|is_unique[users.email]');
        $this->form_validation->set_rules('password', trans("password"), 'required|xss_clean|min_length[4]|max_length[30]');
        $this->form_validation->set_rules('confirm_password', trans("confirm_password"), 'required|xss_clean|matches[password]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            redirect($this->agent->referrer());
        } else {
            //register
            if ($this->auth_model->register()) {
                $this->session->set_flashdata('success', trans("message_register_success"));
                redirect(base_url());
            } else {
                //error
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("message_register_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Logout
     */
    public function logout()
    {
        $this->auth_model->logout();
        redirect('login');
    }


    /**
     * Update Profile
     */
    public function update_profile()
    {
        //check if logged in
        if ($this->auth_model->is_logged_in() == false) {
            redirect('login');
        }

        $data["page"] = $this->page_model->get_page("update-profile");

        $data['title'] = get_page_title($data['page']);
        $data['description'] = get_page_description($data['page']);
        $data['keywords'] = get_page_keywords($data['page']);

        $this->load->view('blog/partials/_header', $data);
        $this->load->view('blog/auth/update_profile');
        $this->load->view('blog/partials/_footer');
    }


    /**
     * Update Profile Post
     */
    public function update_profile_post()
    {
        //check if logged in
        if ($this->auth_model->is_logged_in() == false) {
            redirect('login');
        }

        $this->form_validation->set_rules('email', html_escape(trans("email")), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            redirect($this->agent->referrer());
        } else {
            $email = $this->input->post('email', true);
            $slug = $this->input->post('slug', true);

            //check slug
            $user_slug = $this->auth_model->get_user_by_slug($slug);
            if (!empty($user_slug)) {

                if ($user_slug->id != user()->id) {
                    $this->session->set_flashdata('error', trans("message_slug_error"));
                    redirect($this->agent->referrer());
                }
            }


            //is email unique
            if (!$this->auth_model->is_unique_email($email, user()->id)) {
                $this->session->set_flashdata('error', html_escape(trans("email_unique_error")));
                redirect($this->agent->referrer());
            }
            if ($this->auth_model->update_user(user()->id)) {
                $this->session->set_flashdata('success', html_escape(trans("message_profile")));
            }
            redirect($this->agent->referrer());
        }
    }


    /**
     * Change Password
     */
    public function change_password()
    {
        //check if logged in
        if ($this->auth_model->is_logged_in() == false) {
            redirect('login');
        }

        $data["page"] = $this->page_model->get_page("change-password");

        $data['title'] = get_page_title($data['page']);
        $data['description'] = get_page_description($data['page']);
        $data['keywords'] = get_page_keywords($data['page']);

        $this->load->view('blog/partials/_header', $data);
        $this->load->view('blog/auth/change_password');
        $this->load->view('blog/partials/_footer');
    }


    /**
     * Change Password Post
     */
    public function change_password_post()
    {
        //check if logged in
        if ($this->auth_model->is_logged_in() == false) {
            redirect('login');
        }

        $this->form_validation->set_rules('old_password', html_escape(trans("old_password")), 'required|xss_clean|max_length[30]');
        $this->form_validation->set_rules('password', html_escape(trans("password")), 'required|xss_clean|min_length[4]|max_length[30]');
        $this->form_validation->set_rules('password_confirmation', html_escape(trans("confirm_password")), 'required|xss_clean|max_length[30]|matches[password]');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->change_password_input_values());
            redirect($this->agent->referrer());
        } else {
            if ($this->auth_model->change_password()) {
                $this->session->set_flashdata('success', html_escape(trans("message_change_password")));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', html_escape(trans("change_password_error")));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Reset Password
     */
    public function reset_password()
    {
        //check if logged in
        if ($this->auth_model->is_logged_in() == true) {
            redirect(base_url());
        }

        $this->is_registration_active();

        $data["page"] = $this->page_model->get_page("reset-password");

        $data['title'] = get_page_title($data['page']);
        $data['description'] = get_page_description($data['page']);
        $data['keywords'] = get_page_keywords($data['page']);

        $this->load->view('blog/partials/_header', $data);
        $this->load->view('blog/auth/reset_password');
        $this->load->view('blog/partials/_footer');
    }


    /**
     * Reset Password Post
     */
    public function reset_password_post()
    {
        //check if logged in
        if ($this->auth_model->is_logged_in() == true) {
            redirect(base_url());
        }

        $email = $this->input->post('email', true);

        //get user
        $user = $this->auth_model->get_user_by_email($email);

        //if user not exists
        if (empty($user)) {
            $this->session->set_flashdata('error', html_escape(trans("reset_password_error")));
            redirect($this->agent->referrer());
        } else {
            //generate new password
            $new_password = $this->auth_model->reset_password($email);

            $subject = trans("reset_password");
            $message = trans("mail_password_change") . "<strong>" . $new_password . "</strong>";

            //send email
            if ($this->settings_model->send_email($email, $subject, $message)) {
                $this->session->set_flashdata('success', html_escape(trans("reset_password_success")));
                redirect($this->agent->referrer());
            }
        }
    }

    public function is_registration_active()
    {
        if ($this->settings->registration_system != 1) {
            redirect(base_url());
        }
    }
}
