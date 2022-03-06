<?php
require_once 'vendor/autoload.php';
session_start();

class Page_main extends CI_Controller
{
    /**
     * 主程式
     */
    public function main()
    {
        // 基本參數設定
        $clientID = $this->config->item('clientID');
        $clientSecret = $this->config->item('clientSecret');
        $redirectUrl = 'http://localhost:8080/login/index.php';

        // 設定googleAPI
        $client = $this->setGoogleClient($clientID, $clientSecret, $redirectUrl);
        $loginUrl = $client->createAuthUrl();

        if (!empty($_GET['code'])) {
            $this->settingSessions($client);
        }

        // 確認登入狀態
        $login = !empty($_SESSION['access_token']) ? TRUE : FALSE;
        $data = array(
            'login' => $login,
            'loginUrl' => $loginUrl,
            
        );
        $this->load->view('index', $data);
    }

    /**
     * 登出主程式
     */
    public function logout()
    {
        $client = new Google_Client();
        $client->revokeToken();
        session_destroy();
        header('location:index.php');
    }

    /**
     * 設定googleAPI
     *
     * @param string $clientID 
     * @param string $clientSecret
     * @param string $redirectUrl
     * 
     * @return Object
     */
    private function setGoogleClient($clientID, $clientSecret, $redirectUrl)
    {
        $client = new Google_Client();
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        // 這邊要填寫接受 code 的 API (必須與憑證中設定的網址完全相同)
        $client->setRedirectUri($redirectUrl);
        // 需要授權取得的資源
        $client->addScope('profile');
        $client->addScope('email');
        return $client;
    }

    /**
     * 設定session資料
     * @param object $client 
     */
    private function settingSessions($client)
    {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        if (!isset($token['error'])) {
            $client->setAccessToken($token);
            $_SESSION['access_token'] = $token['access_token'];
            // 使用 Service 去取得使用者資訊以及 email
            $service = new Google_Service_Oauth2($client);
            $user_info = $service->userinfo->get();
            if (!empty($user_info['given_name'])) {
                $_SESSION['user_first_name'] = $user_info['given_name'];
            }
            if (!empty($user_info['family_name'])) {
                $_SESSION['user_last_name'] = $user_info['family_name'];
            }
            if (!empty($user_info['email'])) {
                $_SESSION['user_email_address'] = $user_info['email'];
            }
            if (!empty($user_info['gender'])) {
                $_SESSION['user_gender'] = $user_info['gender'];
            }
            if (!empty($user_info['picture'])) {
                $_SESSION['user_image'] = $user_info['picture'];
            }
        }
    }
}
