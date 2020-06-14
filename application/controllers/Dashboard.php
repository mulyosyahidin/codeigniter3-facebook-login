<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Facebook_model');
        $this->load->helper('url');

        if ( ! $this->session->userdata('login_data')) {
            redirect('login');
        }
    }

    public function index()
    {
        $uid = $this->session->userdata('login_data')['uid'];

        $params['flash'] = $this->session->flashdata('fb_flash');
        $params['data'] = $this->Facebook_model->get_facebook_user_data($uid);

        $this->load->view('dashboard', $params);
    }

    public function logout()
    {
        $this->session->unset_userdata('login_data');
        $this->session->set_flashdata('fb_flash', 'Berhasil Log Out');

        redirect('login');
    }
}