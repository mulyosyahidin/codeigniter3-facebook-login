<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        $this->load->library('facebook');
        $this->load->model('Facebook_model');

        $this->load->helper('url');
    }

    public function index()
    {
        $redirect_to = site_url('login/with_facebook');
        $params['flash'] = $this->session->flashdata('fb_flash');
        $params['facebook_login_url'] = $this->facebook->create_auth_url($redirect_to);

        $this->load->view('login_with_facebook', $params);
    }

    public function with_facebook()
    {
        $code = $this->input->get('code');

        if ($code)
        {
            try {
                $helper = $this->facebook->create_helper();
                $access_token = $this->facebook->get_access_token();

                $this->facebook->set_access_token($access_token);
            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                exit('Graph returned an error: ' . $e->getMessage());
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                exit('Facebook SDK returned an error: ' . $e->getMessage());
            }

            if (!isset($access_token)) {
                if ($helper->getError()) {
                    header('HTTP/1.0 401 Unauthorized');
                    echo "Error: " . $helper->getError() . "\n";
                    echo "Error Code: " . $helper->getErrorCode() . "\n";
                    echo "Error Reason: " . $helper->getErrorReason() . "\n";
                    echo "Error Description: " . $helper->getErrorDescription() . "\n";
                } else {
                    header('HTTP/1.0 400 Bad Request');
                    echo 'Bad request';
                }
                exit;
            }

            $user = $this->facebook->get_user();
            $uid = $user['id'];
            $email = $user['email'];
            $name = $user['name'];

            if ($this->Facebook_model->is_facebook_user_exist($email, $uid))
            {
                $data = array('is_login' => TRUE, 'uid' => $uid);
                $this->session->set_userdata('login_data', $data);

                $this->session->set_flashdata('fb_flash', 'Berhasil login!');
                redirect('dashboard');
            }
            else
            {
                $this->session->set_flashdata('fb_flash', 'Akun <b>'. $name .'</b> dengan email <b>'. $email .'</b> belum terdaftar melalui Facebook.<br>Silahkan mendaftar terlebih dahulu');
                redirect('register');
            }
        }
        else
        {
            show_404();
        }
    }
}