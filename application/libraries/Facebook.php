<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Facebook
{
    protected $CI;
    private $FB;

    protected $app_id;
    protected $app_secret;
    protected $default_graph_version;

    protected $helper;
    protected $access_token;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->config('facebook');

        $this->app_id = $this->CI->config->item('app_id', 'facebook');
        $this->app_secret = $this->CI->config->item('app_secret', 'facebook');
        $this->default_graph_version = $this->CI->config->item('default_graph_version', 'facebook');

        $this->FB = new Facebook\Facebook([
            'app_id' => $this->app_id,
            'app_secret' => $this->app_secret,
            'default_graph_version' => $this->default_graph_version,
        ]);
    }

    public function create_auth_url($redirect_uri = '')
    {
        $helper = $this->FB->getRedirectLoginHelper();

        $permissions = ['email'];
        $login_url = $helper->getLoginUrl($redirect_uri, $permissions);

        return $login_url;
    }

    public function create_helper()
    {
        $this->helper = $this->FB->getRedirectLoginHelper();

        return $this->helper;
    }

    public function get_access_token()
    {
        $access_token = $this->helper->getAccessToken();

        return $access_token;
    }

    public function set_access_token($token)
    {
        $this->access_token = $token;

        return $this;
    }

    public function get_oauth2_client()
    {
        return $this->FB->getOAuth2Client();
    }

    public function get_user()
    {
        try {
            $response = $this->FB->get('/me?fields=id,name,email,picture', $this->access_token);
        }
        catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
        }
        catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
        }

        return $response->getGraphUser();
    }
}
