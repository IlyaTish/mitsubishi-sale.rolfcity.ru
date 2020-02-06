<?
header('Content-type: text/html; charset=utf-8');

function SendMail( $e_from, $e_to, $e_subject, $e_text )
{
	$php_ver = phpversion();

	$header  = "";
	$header .= "Content-Type: text/html; charset=utf-8;\n";
	$header .= "From: $e_from\n";
	$header .= "X-Mailer: PHP/".phpversion()."\n";

	mail( $e_to, $e_subject, "<html>$e_text</html>", $header);
}//end_ func


$l_host   = str_replace( "www.", "", $_SERVER["HTTP_HOST"] );


$l_phone = preg_replace("/[^0-9]/", '', $_POST["phone"]);
//echo $l_phone;
if ( strlen(trim($l_phone))!=11 ) exit;

$l_to = "igor.nikolaev@procontext.ru, sblev@rolf.ru, leads@ismart.pro";


switch( $_POST["form"] )
{
	default:
		if ($_POST["center"]) $e_text .= "Центр: ".$_POST["center"]."<br>";
		if ($_POST["name"]) $e_text .= "Имя: ".$_POST["name"]."<br>";
		if ($_POST["phone"]) $e_text .= "Телефон: ".$_POST["phone"]."<br>";
		if ($_POST["email"]) $e_text .= "E-mail: ".$_POST["email"]."<br>";
		if ($_POST["group1"]) $e_text .= "Отдел: ".$_POST["group1"]."<br>";
		if ($_POST["price"]) $e_text .= "Желаемая цена: ".$_POST["price"]."<br>";
		if ($_POST["comment"]) $e_text .= "<br/>".$_POST["comment"]."<br>";
		if ($_POST["href"]) $e_text .= "<br/>http://promo-kia-rolf.lo".$_POST["href"]."<br>";

		SendMail( "robot@".$l_host, $l_to,  $_POST["form_diler"]." - ".$_POST["form_title"].$_POST["title"], $e_text );
		break;

}



function is_empty($var)
{
  $is_scalar = is_scalar($var);
  $has_length = strlen($var);
  return !($var || ($is_scalar && $has_length));
}

$tel = preg_replace('/[^0-9]/', '', $_POST['phone']);
$site_name = "mitsubishi-sale.rolfcity.ru";
$entry_point = "http://mitsubishi-sale.rolfcity.ru/overall/";

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

$params = array(
  'unique' => 'company',
  'apiak' => 'NDUtVCPYnRysMdEj',
  'whash' => 'abda098a0c10d96a1d70fafd9f4fff2a',
  'utc' => 'Europe/Moscow',
  'opening_hours' => '08002200',
  'ga_client_id' => $_POST["ga_client_id"],
  "tool_name" => "Форма обратной связи",
  'ip_client' => $ip,
  'calls' =>
      array(
          array(
              'client' => $tel,
              'site' => $site_name,
              'text_to_manager' => "Посетитель заполнил форму на сайте mitsubishi-sale.rolfcity.ru/overall/"
          )
      )
);

$referrer = $_POST['referrer'];
$search_engine = $_POST["search_engine"];

if (!is_empty($_POST["utm_source"])) {
    $params["calls"][0]["utm"] = array(
        "utm_source" => $_POST["utm_source"],
        "utm_medium" => $_POST["utm_medium"],
        "utm_campaign" => $_POST["utm_campaign"],
        "utm_content" => $_POST["utm_content"],
        "utm_term" => $_POST["utm_term"],
        'entry_point' => $entry_point,
    );
} else if (!is_empty($search_engine)) {
    $params["calls"][0]["utm"] = array(
        "utm_type" => "organic",
        "utm_source" => $search_engine,
        'entry_point' => $entry_point,
    );
} else if (!is_empty($referrer)) {
    $params["calls"][0]["utm"] = array(
        "utm_type" => "referral",
        "utm_source" => $referrer,
        'entry_point' => $entry_point,
    );
} else {
    $params["calls"][0]["utm"] = array(
        "utm_type" => "typein",
        'entry_point' => $entry_point,
    );
}


$url_vars = http_build_query($params);

$protocol = 'https://';
$url = $protocol . 'api.callkeeper.ru/makeCalls?' . $url_vars;
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);
var_dump($response);
var_dump($url);

?>