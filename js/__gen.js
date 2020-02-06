
window.c_genDebug=0;
window.c_genCssDup = [];
function generateCSSItem( e_path )
{
	if ( e_path.length==0 ) return;

	var l_text = e_path.join(" ");
	if ( (e_path[e_path.length-1]).indexOf("{")<=0 )
		l_text = l_text + " {}";

	if ( typeof(window.c_genCssDup[l_text])!="undefined" ) return;
	if ( e_path.length==0 ) return;

	//Если контейнер только один, то стили ненужны
	if ( e_path.length==1 && e_path[0].indexOf("container")>0 )
	{
		//console.log( "!!!!!!!!!!!"+e_path );
		return;
	}

	//var l_text = $("textarea:first").text()+"\nCSS: "+e_path.join(" ");
	window.c_genCssDup[l_text] = l_text;

	//Если контейнер в начале и элементов больше 1, то печатаем, но контейнер выкидываем
	if ( e_path[0].indexOf("container")>0 )
	{
		l_text = $.trim(l_text.replace(".container",""));
	}

	//Если контейнер есть и не в конце вроде(header .container .row1 .logo1 {}) то нафиг он нужен
	if ( l_text.indexOf("container")>0  && e_path[e_path.length-1].indexOf("container")<=0 )
	{
		l_text = $.trim(l_text.replace(".container ",""));
	}



	if (window.c_genDebug==1) l_text = "["+window.c_recCounter+"]" + l_text;



	$("textarea:first").text( $("textarea:first").text()+"\n"+l_text );
}//end_ func



window.c_recPath = [];
//window.c_recDom = "";
window.c_recCounter = 0;
window.c_level = 0;
function recurDom( e_object )
{
	if (window.c_genDebug==1) 
	{
		console.log( window.c_recCounter+"; level["+window.c_level+"]; ", "=== Enter ===", e_object );
	}
	window.c_recCounter++;
	//if (window.c_recCounter>100) return;

	e_object = $(e_object);
	var l_par_tag_name     = $.trim(e_object.get(0).tagName.toLowerCase());
	var l_par_tag_id     = $.trim(e_object.attr("id"));
	if ( typeof(l_par_tag_id)=="undefined" ) l_par_tag_id = "";
	l_par_tag_id = $.trim(l_par_tag_id.toLowerCase());
	var l_par_tag_children = e_object.children();
	var l_par_tag_class_name   = $.trim(e_object.get(0).className.toLowerCase());

	var l_par_tag_html = $.trim(e_object.html());
	var l_par_tag_text = $.trim(e_object.text());

	if ( ("-=-="+l_par_tag_id).indexOf("map")>0 ) return;
	if ( ("-=-="+l_par_tag_id).indexOf("form_popup")>0 ) return;
	if ( l_par_tag_class_name=="disclamer_switch" || l_par_tag_class_name=="disclamer" ) return;
	if ( l_par_tag_class_name=="simple_slider" ) return;

	l_need_before_after = 0;
	if ( ("-="+l_par_tag_class_name).indexOf("bah")>0 )
	{
		l_par_tag_class_name = $.trim(l_par_tag_class_name.replace("bah",""));
		l_need_before_after = 1;
	}


	//window.c_recDom = window.c_recDom + e_object.get(0).tagName + "\n";


	var l_ispush = 0;
	if ( l_par_tag_name=="header" )
	{
		window.c_recPath.push( l_par_tag_name );
		l_ispush = 1;
	}else if ( l_par_tag_class_name!="" )
	{
		if ( l_par_tag_class_name.indexOf(" ")>0 )
		{
			l_par_tag_class_name = $.trim(""+l_par_tag_class_name.replace("popup","")).replace(" ",".").replace(" ",".").replace(" ",".").replace(" ",".").replace(" ",".");
		}
		window.c_recPath.push( "."+l_par_tag_class_name );
		l_ispush = 1;
	}else if ( l_par_tag_id!="" )
	{
		window.c_recPath.push( "#"+l_par_tag_id );
		l_ispush = 1;
	}
	l_par_tag_class_name = $.trim(l_par_tag_class_name);
	if ( l_ispush==0 )
	{
		switch( l_par_tag_name )
		{
			case "header":
			case "footer":
			case "font":
			case "span":
			case "b":
			case "strong":
			case "i":
			case "ul":
			case "li":
			case "u":
			case "img":
			case "table":
			case "tr":
			case "th":
			case "td":
			case "p":
				window.c_recPath.push( l_par_tag_name );
				l_ispush = 1;
				break;
		}
	}

	if ( l_ispush==0 && l_par_tag_text=="" )
	{		
		window.c_recPath.push( l_par_tag_name );
		l_ispush = 1;
	}

	if (window.c_genDebug==1) 
	{
		console.log( "level["+window.c_level+"]; ", "Enter recPath:", window.c_recPath );
	}
	generateCSSItem( window.c_recPath );

	//Если тег A, создаём доп классы вроде before, after, hover
	if ( l_par_tag_name=="a" || l_need_before_after==1 )
	{
		//var l_temp_reg = $(window.c_recPath).clone();
		var a =  JSON.stringify(window.c_recPath);

		var l_temp_reg =  JSON.parse(a);
		l_temp_reg[l_temp_reg.length-1] = l_temp_reg[l_temp_reg.length-1] + ":before{ content:''; }";
		generateCSSItem( l_temp_reg );

		var l_temp_reg =  JSON.parse(a);
		l_temp_reg[l_temp_reg.length-1] = l_temp_reg[l_temp_reg.length-1] + ":after{ content:''; }";
		generateCSSItem( l_temp_reg );
		var l_temp_reg =  JSON.parse(a);
		l_temp_reg[l_temp_reg.length-1] = l_temp_reg[l_temp_reg.length-1] + ":hover";
		generateCSSItem( l_temp_reg );
	}

	if (window.c_genDebug==1) 
	{
		console.log( "level["+window.c_level+"]; ", "Children len:", l_par_tag_children.length );
	}
	$(l_par_tag_children).each( function(i)
	{
		if (window.c_genDebug==1) 
		{
			console.log( "level["+window.c_level+"]; ", "Children "+i+":", this );
		}
		//console.log( window.c_recDom );

		window.c_level++;
		recurDom( this );
		window.c_level--;
		//var l_tag_name = $(this).get(0).tagName.toLowerCase();
		//var l_class_name = $(this).get(0).className.toLowerCase();
		//var l_tag_children = $(this).children();

//console.log( l_tag_name+" "+l_class_name );
		//l_tag_children
	} );
	//console.log( e_object.children().length );

	if (l_ispush==1)
		window.c_recPath.pop();	
}



function initDOM( e_object )
{
	$("html").prepend("<textarea style='width:100%; height:500px;'></textarea>");
	recurDom(e_object);
}





$( function()
{
	//initDOM( $("body") );
	initDOM( $("header") );
	//initDOM( $("footer") );
} );





