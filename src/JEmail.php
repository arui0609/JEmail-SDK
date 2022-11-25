<?php
/**
 *
 * User: songrui
 * Date: 2022/11/24
 * Email: <sr_yes@foxmail.com>
 */
namespace Arui\JEmail;

use Illuminate\Support\Facades\Log;

class JEmail
{
    use Request;
    var $token;

    public $config = [];

    public function __construct()
    {
        $this->config = config('j_cloud',[]);
        if(!$this->config){
            throw new \Exception("miss param j cloud,please run 'php artisan '");
        }
    }


    /**
     * 刷新access_token
     */

    public function getNewToken()
    {
        $url = 'https://jaccount.sjtu.edu.cn/oauth2/token';
        $post_data = array(
            'grant_type' => 'password',
            'client_id' => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
            'scope' => 'send_notification',
            'username' => $this->config["username"],
            'password' => $this->config["password"],
        );
        $token_json = $this->request_posts($url, $post_data);
        $token_info = json_decode($token_json, JSON_OBJECT_AS_ARRAY);
        if(!isset($token_info['access_token'])){
            Log::error("获取access_token失败",$token_info);
            throw new \Exception("获取access_token失败");
        }
        return $token_info['access_token'];
    }

    /**
     * 发送邮件
     */

    public function sendEmail($data)
    {
        $url = "https://api.sjtu.edu.cn/v1/notification?access_token=" . $this->getNewToken();//发邮件
        $data = json_encode($data, true);
        $result_data = $this->send_emails($url, $data, "PUT");//发邮件
        $result_data = json_decode($result_data, JSON_OBJECT_AS_ARRAY);
        if($result_data['error'] === 'success'){
            return true;
        }else{
            return false;
        }
    }


    /**
     * 获取邮件的新的token
     * @param string $url
     * @param array $post_data
     * @return bool|string
     */
    public function getEmailNewToken()
    {
        $url = "https://jaccount.sjtu.edu.cn/oauth2/token";
        $data = [
            "grant_type" => "client_credentials",
            "scope" => "notifications",
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
        ];
        $token_json = $this->request_posts($url, $data);
        return json_decode($token_json, true)['access_token'];
    }


    /**
     * 获取已发送的邮件信息
     * @param string $url
     * @param array $post_data
     * @return bool|string
     */
    public function getAreadySend($id, $access_token)
    {
        $url = "https://api.sjtu.edu.cn/v1/notification/status?id=" . $id . "&&access_token=" . $access_token;
        $result = $this->request_get($url);
        return json_decode($result,JSON_OBJECT_AS_ARRAY);
    }
}
