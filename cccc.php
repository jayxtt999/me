<?php
/**
 * Created by PhpStorm.
 * User: xiett
 * Date: 15-4-4
 * Time: 下午11:07
 */
$comment = array(
    "不错呀",
    "支持楼主",
    "赞赞赞",
    "么么哒",
    "萌萌哒",
);

for ($i = 66600; $i <= 66708; $i++) {//66528;

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

print str_repeat(" ", 4096);

//登录结束    测试评论



    $commentUrl = "http://www.gbsq.org/JYBBS/posts/list/0/66445.html#74604";
    $ch = curl_init();
    //$url = "http://www.gbsq.org/JYBBS/posts/58198.".$i;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header); //设置头信息的地方
    curl_setopt($ch, CURLOPT_REFERER, "http://www.gbsq.org/JYBBS/posts/66445.html"); //构造来路
//设置评论数据
    /*$comment = file_get_contents("http://apix.sinaapp.com/joke/?appkey=trialuser");
    $comment = file_get_contents("http://apix.sinaapp.com/joke/?appkey=trialuser");
    $comment = str_replace("\\n\\n技术支持 方倍工作室", "", $comment);
    $comment[5] = str_replace("\"", "", $comment);*/
    $post_data = array(
        "action" => "insertSave",
        "module" => "posts",
        "forum_id" => "98642", //社区id
        "start" => "0",
        "topic_id" => $i, //文章id
        "quick" => "1",
        "quick" => "1",
        "message" => "<p>".$comment[mt_rand(0,4)]
  ."</p>",
        "post" => "12121212",
    );
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
    $res = curl_exec($ch);
    curl_close($ch);
    echo $i . "<br/>";
    sleep(1);
    ob_flush();
    flush();
}
ob_end_flush();
exit;


