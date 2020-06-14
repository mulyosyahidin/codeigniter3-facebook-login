<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('facebook');
        $this->load->model('Facebook_model');

        $this->load->helper('url');
    }

    public function index()
    {
        $redirect_to = site_url('register/with_facebook');
        $params['facebook_register_url'] = $this->facebook->create_auth_url($redirect_to);
        $params['flash'] = $this->session->flashdata('fb_flash');

        $this->load->view('register_with_facebook', $params);
    }

    public function with_facebook()
    {
        $code = $this->input->get('code');

        if ($code) {
            try {
                $helper = $this->facebook->create_helper();
                $access_token = $this->facebook->get_access_token();

                $this->facebook->set_access_token($access_token);
            }
            catch (Facebook\Exceptions\FacebookResponseException $e) {
                exit('Graph returned an error: ' . $e->getMessage());
            }
            catch (Facebook\Exceptions\FacebookSDKException $e) {
                exit('Facebook SDK returned an error: ' . $e->getMessage());
            }

            if (!isset($access_token)) {
                if ($helper->getError()) {
                    header('HTTP/1.0 401 Unauthorized');
                    echo "Error: " . $helper->getError() . "\n";
                    echo "Error Code: " . $helper->getErrorCode() . "\n";
                    echo "Error Reason: " . $helper->getErrorReason() . "\n";
                    echo "Error Description: " . $helper->getErrorDescription() . "\n";
                }
                else {
                    header('HTTP/1.0 400 Bad Request');
                    echo 'Bad request';
                }
                exit;
            }

            $user = $this->facebook->get_user();

            $uid = $user['id'];
            $name = $user['name'];
            $email = $user['email'];
            $picture = $user['picture'];

            if ($this->Facebook_model->is_facebook_user_has_registered($uid)) {
                $this->session->set_flashdata('fb_flash', '<b>'. $name .'</b> sebelumnya sudah mendaftar menggunakan akun Facebook.<br>Silahkan login di halaman login menggunakan akun Facebook');
                redirect(site_url('register'));
            }
            else {
                $picture_name = strtolower($name);
                $picture_name = str_replace(' ', '-', $picture_name);

                $ch = curl_init($picture['url']);
                $fp = fopen('./assets/users/' . $picture_name .'.jpeg', 'wb');
                    curl_setopt($ch, CURLOPT_FILE, $fp);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_exec($ch);
                    curl_close($ch);
                fclose($fp);

                $user_data = [
                    'oauth_provider' => 'facebook',
                    'oauth_uid' => $uid,
                    'email' => $email,
                    'name' => $name,
                    'profile_picture' => $picture_name .'.jpeg'
                ];

                $this->Facebook_model->register_new_user($user_data);

                $data = array('is_login' => TRUE, 'uid' => $uid);

                $this->session->set_userdata('login_data', $data);

                $this->session->set_flashdata('fb_flash', '<b>Berhasil!</b><br>Kamu berhasil mendaftar menggunakan akun Facebook. Selanjutnya, saat login silahkan gunakan tombol <b>Login with Facebook</b> dan tidak perlu memasukkan username / password');
                redirect('dashboard');
            }
        }
        else {
            show_404();
        }
    }
}