<?

try
{
	$l_data_arr = json_decode($_POST["data"],true);

	$l_whash = "aa972581747cb49df92ecea15f26f8dc";
	$l_apiak = "2a42715a534defc4"; 
	$l_uuid_company = $_SERVER["HTTP_HOST"];//"mysite.com";
	
	$l_text_to_manager = "Посетитель заполнил форму на сайте ".$l_data_arr["title"];
	$l_domain = $_SERVER["HTTP_HOST"];//ford-rolfaltufievo.com
	$l_phone = preg_replace("/[^0-9]/", '', $l_data_arr["phone"] );
	$l_url = $l_data_arr["url"];
	$l_referrer = trim($l_data_arr["referrer"]);
	//$l_page_url = trim($l_data_arr["page_url"]);
	$l_user_agent = trim($l_data_arr["user_agent"]);


	$l_utm = array();
	if ( strpos($l_url,"utm")>0 )
	{
		$l_utm = parse_utm($l_url,$l_url);
	}elseif ( strpos($l_referrer,"utm")>0 )
	{
		$l_utm = parse_utm($l_referrer,$l_referrer);
	}//end_ if
	
	
	
	
	//GA CLIENT ID
	if ( isset($l_data_arr["ga"]) && is_array($l_data_arr["ga"]) )
	{
		foreach( $l_data_arr["ga"] as $l_ga_item )
		{
			$l_ga_client = $l_ga_item["clientId"];
			break;
		}//end_ foreach
	}else
	$l_ga_client = "";
	//END_ GA CLIENT ID
	
	
	
	
	
	//====================================================================================
	//== Определяем тип звонка
	$l_perehod_type = "";
	//Прямой переход - typein
	if ( $l_referrer=="" )
	{
		$l_perehod_type = "typein";
	}
	//Реферальный переход - referral
	else
	{
		if ( 
			strpos($l_referrer,"yandex")>0 || 
			strpos($l_referrer,"google")>0 ||
			strpos($l_referrer,"mail.ru")>0 ||
			strpos($l_referrer,"rambler")>0 ||
			strpos($l_referrer,"bing")>0 ||
			strpos($l_referrer,"msn")>0 ||
			strpos($l_referrer,"yahoo.com")>0
		)
		{
			$l_perehod_type = "organic";
		}
		else $l_perehod_type = "referral";
	}//end_ if
	
	
	if ( count($l_utm["utm"])>0 )
	{
		$l_perehod_type = "cpc";
	}//end_ if
	//== Определяем тип звонка
	//====================================================================================





	$l_url_vars = array(
			'unique' => $l_uuid_company,
			'apiak' => $l_apiak,
			'whash' => $l_whash,
			//'utc' => 'Europe/Moscow',
			'ga_client_id' => $l_ga_client,
			'ip_client'=>ip(),
			'calls' =>array(
					array(
						'client' => $l_phone,
						'text_to_manager'=>$l_text_to_manager,
						'manager'=>0,
						'site'=>$l_domain,
						'utm' => array(
	                                            'utm_source' => 	defvar($l_utm["utm"]["UTM source"],""),//'organic',
	                                            'utm_medium' => 	defvar($l_utm["utm"]["UTM medium"],""),//'some_data',
	                                            'utm_campaign' =>  	defvar($l_utm["utm"]["UTM campaign"],""),//'some_data',
	                                            'utm_content' =>  	defvar($l_utm["utm"]["UTM content"],""),//'some_data',
	                                            'utm_term' =>  	defvar($l_utm["utm"]["UTM term"],""),//'some_data',
	                                            'entry_point' => 	$l_url,//$l_referrer,//"http://facebook.com",//referrer
	                                            'user_agent' => 	$l_user_agent//'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2712.0 Safari/537.36'
	                                        )
					)
	                        )
		);//end_ array
	
	
	
	//1) Если прямой переход
	if ( $l_perehod_type=="typein" )
	{
		$l_url_vars["calls"][0]["utm"] = array(
			'utm_type'=>'typein',
		'entry_point' => $l_url,//$l_referrer,//"http://facebook.com",//referrer
		'user_agent' => $l_user_agent//'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2712.0 Safari/537.36'
	);
	}//end_ if
	//2) Реферальный переход
	if ( $l_perehod_type=="referral" )
	{
		$l_url_vars["calls"][0]["utm"] = array( 
			'utm_type'=>'referral',
			'utm_source' => $l_referrer,
			'entry_point' => $l_url,//$l_referrer,//"http://facebook.com",//referrer
			'user_agent' => $l_user_agent//'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2712.0 Safari/537.36'
		);
	}//end_ if
	//3) Органик(поисковик)
	if ( $l_perehod_type=="organic" )
	{
		$l_referrer_host = parse_url( $l_referrer, PHP_URL_HOST );
		$l_referrer_host = trim(str_replace("www.","",$l_referrer_host));
		$l_url_vars["calls"][0]["utm"] = array( 
			'utm_type'=>'organic',
			'utm_source' => $l_referrer_host,
			'entry_point' => $l_url,//$l_referrer,//"http://facebook.com",//referrer
			'user_agent' => $l_user_agent//'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2712.0 Safari/537.36'
		);
	}//end_ if
	//4) cpc
	if ( $l_perehod_type=="cpc" )
	{
	}//end_ if
	
	
	$l_url_vars_build_query = http_build_query($l_url_vars);
	
	$protocol = 'http://';
	$url = $protocol . 'api.callkeeper.ru/makeCalls?'.$l_url_vars_build_query;
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($curl);
	curl_close($curl);




	$l_str = "===========================================================\n";
	$l_str .= date("d-m-Y H:i:s")."  ".$l_url_vars_build_query."\n";
	$l_str .= "GET: ".print_r($_GET,true);
	$l_str .= "POST: ".print_r($_POST,true);
	$l_str .= "VARS: ".print_r($l_url_vars,true);
	$l_str .= "RESPONSE: ".$response."\n\n\n";
	file_put_contents( "callkeeper.txt", $l_str, FILE_APPEND );

} catch (Exception $e)
{
	$l_save_str  = $e->getMessage()."\n";
	$l_save_str .= print_r($_GET,true)."\n";
	$l_save_str .= print_r($_SERVER,true)."\n";
	$l_save_str .= "-----------------------------------------------\n";
	file_put_contents( "callkeeper.error.txt", $l_save_str, FILE_APPEND );
}
























































function parse_utm( $e_url, $e_referrer )
{
//echo $e_url;exit;
	//===== Реклама(платная на яндексе или гугле) ======
        //парсим url на переменные
	$e_url = str_replace("#","/",$e_url);
	$l_url_arr = parse_url($e_url);
	parse_str( $l_url_arr["query"], $l_url_vars );

	$l_result = array();

	//Прямые переходы с гугла или яндекса
	$l_result["pay_system"] = "";
	$l_result["pay_system_rus"] = "";
	//YANDEX PAY
	if ( stripos("-=".$e_referrer,"yandex")>0 )
	{
		$l_result["pay_system"] = "yandex";
		$l_result["pay_system_rus"] = "Yandex";
	}//end_ if
	//GOOGLE PAY
	if ( stripos("-=".$e_referrer,"google")>0 )
	{
		$l_result["pay_system"] = "google";
		$l_result["pay_system_rus"] = "Google";
	}//end_ if
	//INSTA
	if ( stripos("-=".$e_referrer,"instagram")>0 )
	{
		$l_result["pay_system"] = "insta";
		$l_result["pay_system_rus"] = "Instagram";
	}//end_ if
	//FB
	if ( stripos("-=".$e_referrer,"facebook.")>0 )
	{
		$l_result["pay_system"] = "fb";
		$l_result["pay_system_rus"] = "Facebook";
	}//end_ if
	//VK
	if ( stripos("-=".$e_referrer,"vk.")>0 )
	{
		$l_result["pay_system"] = "vk";
		$l_result["pay_system_rus"] = "VK";
	}//end_ if
	//bing
	if ( stripos("-=".$e_referrer,"bing.")>0 )
	{
		$l_result["pay_system"] = "bing";
		$l_result["pay_system_rus"] = "Bing";
	}//end_ if
	//msn
	if ( stripos("-=".$e_referrer,"msn.")>0 )
	{
		$l_result["pay_system"] = "msn";
		$l_result["pay_system_rus"] = "Msn";
	}//end_ if
	//msn
	if ( stripos("-=".$e_referrer,"rambler.")>0 )
	{
		$l_result["pay_system"] = "rambler";
		$l_result["pay_system_rus"] = "RA";
	}//end_ if
	//mail.ru
	if ( stripos("-=".$e_referrer,"mail.ru")>0 )
	{
		$l_result["pay_system"] = "mailru";
		$l_result["pay_system_rus"] = "Mail.Ru";
	}//end_ if
	//yahoo
	if ( stripos("-=".$e_referrer,"yahoo.")>0 )
	{
		$l_result["pay_system"] = "yahoo";
		$l_result["pay_system_rus"] = "Yahoo!";
	}//end_ if



	//Рекламная компания яндекса
	if ( 
		stripos("-=".$e_referrer,"yabs.yandex.ru")>0 || 
		stripos("-=".$e_url,"yclid")>0 ||
		stripos("-=".$l_url_vars["utm_source"],"yandex")>0
	)
	{
		$l_result["pay_system"] = "pay-yandex";
		$l_result["pay_system_rus"] = "YANDEX.Direct";
	}//end_ if
	//Рекламная компания гугла
	if ( 
		stripos("-=".$e_referrer,"googleadservices.com")>0 || 
		stripos("-=".$e_url,"gclid")>0 ||
		stripos("-=".$l_url_vars["utm_source"],"google")>0
	)
	{
		$l_result["pay_system"] = "pay-google";
		$l_result["pay_system_rus"] = "Google Adwords";
	}//end_ if
	//Рекламная компания VK
	if ( 
		stripos("-=".$e_referrer,"vk.com")>0 || 
		stripos("-=".$l_url_vars["utm_source"],"vk")>0
	)
	{
		$l_result["pay_system"] = "pay-vk";
		$l_result["pay_system_rus"] = "VK";
	}//end_ if
	//Рекламная компания INSTA
	if ( 
		stripos("-=".$e_referrer,"instagram.")>0 || 
		stripos("-=".$l_url_vars["utm_source"],"instagram")>0
	)
	{
		$l_result["pay_system"] = "pay-insta";
		$l_result["pay_system_rus"] = "Instagram";
	}//end_ if
	//Рекламная компания FB
	if ( 
		stripos("-=".$e_referrer,"facebook.")>0 || 
		stripos("-=".$l_url_vars["utm_source"],"facebook")>0
	)
	{
		$l_result["pay_system"] = "pay-fb";
		$l_result["pay_system_rus"] = "Facebook";
	}//end_ if

	//UTM
	$l_result["utm"] = array();
	//UTM HTML
	$l_result["utm_html"] = array();

	if ( isset($l_url_vars["utm_source"]) )
	{
		$l_result["utm"]["UTM source"] = $l_url_vars["utm_source"];
		$l_result["utm_html"][] = "<b>UTM source</b> ".$l_url_vars["utm_source"];
	}//end_ if
	if ( isset($l_url_vars["utm_medium"]) )
	{
		$l_result["utm"]["UTM medium"] = $l_url_vars["utm_medium"];
		$l_result["utm_html"][] = "<b>UTM medium</b> ".$l_url_vars["utm_medium"];
	}//end_ if
	if ( isset($l_url_vars["utm_campaign"]) )
	{
		//== CODE PAGE ==
		//== CHARSET_X_WIN
		if ( !is_array($l_url_vars["utm_campaign"]) )
		{
			$l_utm_term_code_val = ( $l_url_vars["utm_campaign"] );
			$l_url_vars["utm_campaign"] = $l_utm_term_code_val;
		}
		//== END_ CHARSET_X_WIN ==

		$l_result["utm"]["UTM campaign"] = $l_url_vars["utm_campaign"];
		$l_result["utm_html"][] = "<b>UTM campaign</b> ".$l_url_vars["utm_campaign"];
	}//end_ if
	if ( isset($l_url_vars["utm_content"]) ) 	
	{
		//== CODE PAGE ==
		//== CHARSET_X_WIN
		if ( !is_array($l_url_vars["utm_content"]) )
		{
			$l_utm_term_code_val = ( $l_url_vars["utm_content"] );
			$l_url_vars["utm_content"] = $l_utm_term_code_val;
		}
		//== END_ CHARSET_X_WIN ==

		$l_result["utm"]["UTM content"] = $l_url_vars["utm_content"];
		$l_result["utm_html"][] = "<b>UTM content</b> ".$l_url_vars["utm_content"];
	}//end_ if

	if ( isset($l_url_vars["utm_term"]) )
	{
		//== CODE PAGE ==
		//== CHARSET_X_WIN
		if ( !is_array($l_url_vars["utm_term"]) )
		{
			$l_utm_term_code_val = ( $l_url_vars["utm_term"] );
			$l_url_vars["utm_term"] = $l_utm_term_code_val;
		}
		//== END_ CHARSET_X_WIN ==

		$l_result["utm"]["UTM term"] = $l_url_vars["utm_term"];
		$l_result["utm_html"][] = "<b>UTM term</b> ".$l_url_vars["utm_term"];
	}//end_ if

	//UTM HTML
	if ( count($l_result["utm_html"])==0 )
	{
		$l_result["utm_html"] = "";
	}else
	{
		$l_result["utm_html"] = implode("<br>",$l_result["utm_html"]);
	}//end_ if

	return $l_result;
}//end_ func


function defvar( $e_var_cur_value, $e_var_def_value )
{

	if ( ($e_var_cur_value=="")||($e_var_cur_value==null) )
	{
		return $e_var_def_value;
	}//end_ if
	else
	{
		return $e_var_cur_value;
	}
}//end_ function _def_ var


function ip()
{
	if (getenv('REMOTE_ADDR')) $ip = getenv('REMOTE_ADDR'); 
	elseif(getenv('HTTP_X_FORWARDED_FOR')) $ip = getenv('HTTP_X_FORWARDED_FOR'); 
	else $ip = getenv('HTTP_CLIENT_IP');

	$error='';$not_detect='0.0.0.0'; 
	$ipnum=explode('.', $ip);
	if (sizeof($ipnum) == '4')
	{
		for($i=0;$i<4;$i++)
		{
			if ($ipnum[$i] != intval($ipnum[$i]) || $ipnum[$i] > 255 || $ipnum[$i] < 0) $error='1';
		}
	}
	else $error='1';
	$real_ip = ($error) ? $not_detect : $ip;
	return $real_ip;
} 







?>