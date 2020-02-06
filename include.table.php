<?php


function translit( $e_text )
{
	// Сначала заменяем "односимвольные" фонемы.
	$e_text = strtr( $e_text, "абвгдеёзийклмнопрстуфхъыэ", "abvgdeeziyklmnoprstufh'ie" );
	$e_text = strtr( $e_text, "АБВГДЕЁЗИЙКЛМНОПРСТУФХЪЫЭ", "ABVGDEEZIYKLMNOPRSTUFH'IE" );

	// Затем - "многосимвольные".
	$e_text = strtr( $e_text, array(
                        "ж"=>"zh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh",
                        "щ"=>"shch","ь"=>"", "ю"=>"yu", "я"=>"ya",
                        "Ж"=>"ZH", "Ц"=>"TS", "Ч"=>"CH", "Ш"=>"SH",
                        "Щ"=>"SHCH","Ь"=>"", "Ю"=>"YU", "Я"=>"YA",
                        "ї"=>"i", "Ї"=>"Yi", "є"=>"ie", "Є"=>"Ye" ) );
	// Возвращаем результат.
	return $e_text;

}

function to_url( $e_text )
{
	$e_text = str_replace( "С", "C", $e_text );
	$e_text = strtolower(translit( $e_text ));
	$e_text = preg_replace("/[^a-z0-9]/","_",$e_text);

	return $e_text;
}

function multi_implode($sep, $array) {
    foreach($array as $val)
        $_array[] = is_array($val)? multi_implode($sep, $val) : $val;
    return implode($sep, $_array);
}	
	
	$lines = file('complects.csv');
	if (count($lines) > 1)
	{
		$header = explode(";",iconv("windows-1251","utf-8",$lines[0]));
		unset($lines[0]);
		/*unset($header[4]);
		unset($header[5]);
		unset($header[6]);*/
		
		/*$header_html .= "<tr class='head'>";
		foreach ($header as $l_key => $l_val)
			$header_html .= "<th>".$header[$l_key]."</th>";
		$header_html .= "</tr>";*/
		
		$l_complects = array();
		foreach( $lines as $line )
		{
			$line = iconv("windows-1251","utf-8",$line);
			$line = explode(";",$line);
			$l_model = trim($line[0]);
			$l_complect = trim($line[1]);

			$l_complect = str_replace("\"","",$l_complect);

			$l_complects[$l_model][$l_complect]["model"][] = $l_model;
			$l_complects[$l_model][$l_complect]["engine"][] = $line[2]." ".$line[3];
			//$l_complects[$l_model][$l_complect]["price"][] = str_replace("?","",$line[3]);
			$l_complects[$l_model][$l_complect]["vigoda"][] = $line[4];
			$l_complects[$l_model][$l_complect]["credit"][] = $line[4];
			$l_complects[$l_model][$l_complect]["vigoda_credit"][] = $line[4];
		}
		
		
		$l_sort = array();
		
	

		$l_nodub_arr = array();
	
		foreach ($l_complects as $l_model_name => $l_model_data)
		{
			foreach ($l_model_data as $l_complect_name => $l_complect_data)
			{
				foreach ($l_complect_data["engine"] as $l_key => $l_item)
				{
					$l_model = to_url(strtolower($l_model_name));
				        
					$l_model_url = to_url($l_model);
					$l_complect = str_replace(" ","_",strtolower($l_complect_name));
					if (file_exists("./img/".$l_model."_".$l_complect.".png"))
						$l_image = "./img/".$l_model."_".$l_complect.".png";
					else
						$l_image = "./img/".$l_model.".png";
				        
						
						

$l_nodub_item = trim(str_replace(" ","",$l_model_name.$l_complect_name.$l_item));
if ( isset($l_nodub_arr[$l_nodub_item]) ) continue;
$l_nodub_arr[$l_nodub_item] = 1;
					$l_row = "<tr class='car_".$l_model."'  data-model='".$l_model_url."' data-complect='".$l_complect."' data-complect-name='".$l_complect_name."' data-engine='".$l_complect_data["engine"][0]."'>";
						
					$l_row .= "<td><div class='model'>MITSUBISHI <b>".$l_model_name."</b></div></td>";
					$l_row .= "<td><div class='complect'>".$l_complect_name."</div></td>";
					$l_row .= "<td><div class='engine'>";
					
					/*sort($l_complect_data["price"]);
					$l_price = $l_complect_data["price"][0];
					$l_price_html = number_format($l_price, 0, '.', ' ');
					$l_vigoda = $l_complect_data["vigoda"][0];
					$l_credit = $l_complect_data["credit"][0];
					$l_vigoda_credit = $l_complect_data["vigoda_credit"][0];*/
					
					//if (preg_replace("/[^0-9]/", '', $l_vigoda) != "") $l_vigoda = "Выгода ".$l_vigoda;
						$l_row .= "".$l_item."<br/>";
					$l_row .= "</div></td>";

				
				
						//	$l_row .= "<td><span class='price'>".$l_price."</span>";
						//	$l_row .= "<span class='vigoda'>Выгода до ".$l_complect_data["vigoda"][0]."</span>";
				
						$l_row .= "<td>";
						$l_row .= "<a class='popup button1 blue_blue' href='#form_popup' _title='Узнать цену на MITSUBISHI ".$l_model_name."' data-comment='' data-form_name='credit' data-form_type_model_name='".$l_model_name." ".$l_complect_name."' data-form_diler=''><span>Узнать цену</span></a>";
						$l_row .= "</td>";
						/*$l_row .= "<td>";
						$l_row .= "<a class='popup button1 blue_blue' href='#form_popup' data-title='Купить еще дешевле на Hyundai ".$l_model_name."' data-comment='' data-form_name='credit' data-form_type_model_name='".$l_model_name." ".$l_complect_name."' data-form_diler=''><span>Купить еще дешевле</span></a>";
						$l_row .= "</td>";*/
                                                
                                                /*if ($l_vigoda != "")
						{$l_row .= "<a class='popup link' href='#form_popup' data-title='".$l_vigoda." на Toyota ".$l_model_name."' data-comment='' data-form_name='zakaz_zvonka_fancybox' data-form_type_model_name='".$l_model_name." ".$l_complect_name."' data-form_diler=''><span>".$l_vigoda."</span></a>";}
						if ($l_credit != "")
							{$l_row .= "<a class='popup link' href='#form_popup' data-title='".$l_credit." Toyota ".$l_model_name."' data-comment='' data-form_name='credit' data-form_type_model_name='".$l_model_name." ".$l_complect_name."' data-form_diler=''><span>".$l_credit."</span></a>";}
						if ($l_vigoda_credit != "")
							{$l_row .= "<a class='popup btn' href='#form_popup' data-title='".$l_vigoda_credit." Toyota ".$l_model_name."' data-comment='' data-form_name='credit' data-form_type_model_name='".$l_model_name." ".$l_complect_name."' data-form_diler=''><span>".$l_vigoda_credit."</span></a>";}*/
						
						//if ($l_complect_name == "Conceptline") {
						//$l_row .= "<a class='popup' href='#form_popup' data-title='Выгода по trade-in от 30 000р. Toyota ".$l_model_name."' data-comment='' data-form_name='zakaz_zvonka_fancybox' data-form_type_model_name='".$l_model_name." ".$l_complect_name."' data-form_diler=''><span>Выгода по trade-in от 30 000р.</span></a>";
						//} else {
						//$l_row .= "<a class='popup' href='#form_popup' data-title='Trade-in Toyota ".$l_model_name."' data-comment='' data-form_name='zakaz_zvonka_fancybox' data-form_type_model_name='".$l_model_name." ".$l_complect_name."' data-form_diler=''><span>Trade-in</span></a>";
						//}
						
					preg_match("/([\s0-9]+)/",$line[3],$l_price);
					$l_price = str_replace(" ","",$l_price[1]);
					
					$l_row .= "</tr>";

					$l_price = 0;
					$l_sort[$l_price][] = $l_row;

				}

			}
		}
		
		ksort($l_sort);
		

		$l_table = "<table id='tb_complects' class='resp_table tb_complects'>".$header_html.multi_implode("",$l_sort)."</table>";
	}
?>
<form id="filter_table">
	<div class="select_container">
		<select name="models">
			<option value="">Выберите модель</option>
			<?php
				foreach( $l_complects as $l_model => $l_model_data )
				{
					$l_model = to_url(strtolower($l_model));
					if (!$l_model) continue;
					$l_key = key($l_model_data);
					echo "<option value='".$l_model."' style='text-transform:uppercase;'>".$l_model_data[$l_key]["model"][0]."</option>";
				}//end_ foreach
			?>
		</select>
	</div>
	<div class="select_container">
		<select name="complects">
			<option value="">Выберите комплектацию</option>
		</select>
	</div>
</form>




<script>
	$(function()
	{
		var l_func_show_models = function()
		{
			var l_model  = $('#filter_table select[name=models]').val();
			var l_compl  = $('#filter_table select[name=complects]').val();
			var l_engine = $('#filter_table select[name=engine]').val();

			$(".tb_complects tr").addClass("show");

			//===== MODELS =====
			if ( l_model )
			{
				console.log("model:"+l_model);

				$(".tb_complects tr").removeClass("show");
				$(".tb_complects tr[data-model='"+l_model+"']").addClass("show");

				//FILTER
				$('#filter_table select[name=complects] option:not(:eq(0))').remove();
				$('#filter_table select[name=engine] option:not(:eq(0))').remove();

				//$('#filter_table select[name=complects] option:not(:eq(0))').remove();
				//$('#filter_table select[name=engine] option:not(:eq(0))').remove();
				//$('#filter_table select[name=engine] option:not(:eq(0))').remove();
				_complects = {};
				$(".tb_complects tr.show").each(function()
				{
					_complect = $(this).data('complect');
					_complect_name = $(this).data('complect-name');
					if (_complects[_complect] === undefined)
						$('#filter_table select[name=complects]').append("<option value='"+_complect+"'>"+_complect_name+"</option>");
					_complects[_complect] = _complect_name;
				});
				$('#filter_table select[name=complects]').val( l_compl );
				//END_ FILTER
			}//end_ if
			//===== END_ MODELS =====

			//===== COMPL =====
			if ( l_compl )
			{
				$(".tb_complects tr").removeClass("show");
				$(".tb_complects tr[data-model='"+l_model+"'][data-complect='"+l_compl+"']").addClass("show");

				//FILTER
				//$('#filter_table select[name=complects] option:not(:eq(0))').remove();
				$('#filter_table select[name=engine] option:not(:eq(0))').remove();

				_engines = {};
				$(".tb_complects tr.show").each(function()
				{
					_engine = $(this).data('engine');
					_engine_name = $(this).data('engine');
					if (_engines[_engine] === undefined)
						$('#filter_table select[name=engine]').append("<option value='"+_engine+"'>"+_engine+"</option>");
					_engines[_engine] = _engine_name;
				});
				//END_ FILTER
				$('#filter_table select[name=engine]').val( l_engine );
			}//end_ if
			//===== END_ COMPL =====

			//===== ENGINE =====
			if ( l_engine )
			{
				$(".tb_complects tr").removeClass("show");
				$(".tb_complects tr[data-model='"+l_model+"'][data-complect='"+l_compl+"'][data-engine='"+l_engine+"']").addClass("show");
			}//end_ if
			//===== END_ ENGINE =====

			if ( l_model || l_compl || l_engine )
			{
			}else
			{

			}


			var l_index = 0;

			$(".tb_complects tr").removeClass("megahide");
			$(".tb_complects tr.show").each( function()
			{
				l_index++;
				if (l_index>3)
				{
					console.log("hide");
					$(this).addClass("megahide");
				}
			} );
			$(".tb_complects_showmore").show();

			if ( $(".megahide").length==0 )
				$(".tb_complects_showmore").hide();

		}

		$('#filter_table select[name=models]').change(function()
		{
			$('#filter_table select[name=complects] option:not(:eq(0))').remove();
			$('#filter_table select[name=engine] option:not(:eq(0))').remove();
			l_func_show_models();
		} );
		$('#filter_table select[name=complects]').change(function()
		{
			$('#filter_table select[name=engine] option:not(:eq(0))').remove();
			l_func_show_models();
		} );
		$('#filter_table select[name=engine]').change(function()
		{
			l_func_show_models();
		} );
		$(".tb_complects_showmore").click( function()
		{
			$(".tb_complects tr").removeClass("megahide");
			$(".tb_complects_showmore").hide();
			return false;
		} );
		l_func_show_models();
	});
</script>

<?php
echo $l_table;
?>
<a class="tb_complects_showmore" href="#">Показать ещё</a>

