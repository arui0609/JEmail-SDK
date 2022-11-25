<?php
/**
 *
 * User: songrui
 * Date: 2022/11/25
 * Email: <sr_yes@foxmail.com>
 */
namespace Arui\JEmail;

trait Request
{
    public function request_get($url = '')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($ch, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回

        $data = curl_exec($ch);//运行curl
        if (curl_errno($ch)) {
            echo 'Errno' . curl_error($ch);
        }//捕抓异常
        curl_close($ch);
        return $data;
    }

    protected function request_posts($url = '', $post_data = array())
    {
        if (empty($url) || empty($post_data)) {
            return false;
        }
        $o = "";
        foreach ($post_data as $k => $v) {
            $o .= $k . "=" . $v . "&";
        }
        $post_data = substr($o, 0, -1);
        $postUrl = $url;
        $curlPost = $post_data;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $postUrl); // 要访问的地址
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($ch, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost); // Post提交的数据包
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 设置超时限制防止死循环
        curl_setopt($ch, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


        $data = curl_exec($ch);//运行curl
        if (curl_errno($ch)) {
            echo 'Errno' . curl_error($ch);
        }//捕抓异常
        curl_close($ch);
        return $data;
    }

    //put请求
    protected function send_emails($url = '', $post_data = array(), $method = "PUT")
    {
        //初始化
        $ch = curl_init();
        $headers = ['Content-Type: application/json'];
        // 请求头，可以传数组
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 执行后不直接打印出来
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');     // 请求方式
            curl_setopt($ch, CURLOPT_POST, true);        // post提交
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);   // post的变量
        }
        if ($method == 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
//            return$post_data;
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }
        if ($method == 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 不从证书中检查SSL加密算法是否存在
        $output = curl_exec($ch); //执行并获取HTML文档内容
        curl_close($ch); //释放curl句柄
        return $output;
    }
}
