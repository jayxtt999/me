<?php
/**
 * Created by PhpStorm.
 * User: xiett
 * Date: 15-4-4
 * Time: 下午11:07
 */
//http://www.me.me/cccc.php?i=71828
$s = 1;
$i = $_GET['i'];
for ($i; $i <= 83000; $i++) {//70420;
    if ($s == 50) {
        echo "<script>window.location.href='http://www.me.me/cccc.php?i=$i'</script>";
        exit;
    }
    $url = "http://www.gbsq.org/JYBBS/jforum.html";
//设置header头
    $headers['Host'] = 'www.gbsq.org';
    $headers['Cache-Control'] = 'max-age=0';
    $headers['User-Agent'] = 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36';
    $headers['Content-Type'] = 'multipart/form-data; boundary=charles-multipart1428159124904-205023';
    $headerArr = array();
    foreach ($headers as $n => $v) {
        $header[] = $n . ':' . $v;
    }
//设置登录数据
    $post_data = array(
        "module" => "user",
        "action" => "validateLogin",
        "username" => "甘道夫",
        "password" => "aaacd123",
        "captchaResponse1" => "1234",
        "redirect" => "",
        "loginsubmit" => "立即登录",
    );
//设置cookie
    $cookie_jar = dirname(__FILE__) . "/pic.cookie";
//curl start
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, "http://www.gbsq.org/JYBBS/posts/list/0/66447.html"); //构造来路
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header); //设置头信息的地方
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
    $res = curl_exec($ch);
    curl_close($ch);
//登录结束，评论开始
    $commentUrl = "http://www.gbsq.org/JYBBS/posts/list/0/66445.html#74604";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header); //设置头信息的地方
    curl_setopt($ch, CURLOPT_REFERER, "http://www.gbsq.org/JYBBS/posts/66445.html"); //构造来路
//设置评论数据
    $comment = mt_rand(10, 84);
    $post_data = array(
        "action" => "insertSave",
        "module" => "posts",
        "forum_id" => "98642", //社区id
        "start" => "0",
        "topic_id" => $i, //文章id
        "quick" => "1",
        "quick" => "1",
        "message" => "<p><img src='http://img.baidu.com/hi/jx2/j_00" . $comment . ".gif' _src='http://img.baidu.com/hi/jx2/j_00" . $comment . ".gif'/></p>",
        "post" => "12121212",
    );
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
    $res = curl_exec($ch);
    curl_close($ch);
    echo $i . $res . "<br/>";
    if (strpos($res, "400")) {
        continue;
    }
    $s++;
    ob_flush();
    flush();
    sleep(5);
}
ob_end_flush();
exit;


