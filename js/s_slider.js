jQuery.fn.simpleslider = function( options )
{

	var settings = $.extend({
		autoHeight: '',
		perPage:1,
		speed:500,
		sep_width:0,
		autoPlayTime:0,
		orientation:"horisontal",
		btns_effect:"",
		onlist_begin:function(){},
		onlist_end:function(){} ,
		__mousedrag:{mouse_x_start:0,mouse_x_offset:0,drag_state:""},
		first : true
	}, options );;

	var methods =
	{
		//== INIT ==
		init: function( e_this )
		{
			settings._this = e_this;
			settings.width = 0;
			settings.height = 0;
			settings.s_container_width = 0;
			settings.s_container_height = 0;


			$(e_this).attr('count',$('.s_item',e_this).length);

		
			methods.refresh();
			methods.init_load();
			methods.init_resize();
			methods.__init_arrows();
			methods.__init_bullets();
			methods.init_autoplay();
			methods.__init_mousemove_right_left();



			//s_item
			/*$('.s_item',settings._this).each( function(i)
			{
				alert( $(this).attr("_id") );
			} );*/


		},
		init_resize: function()
		{
			$( settings._this ).on( "refresh", function() 
			{
				methods.refresh();
			});
			$(window).resize(function()
			{
				methods.refresh();
			});
		},
		init_load: function()
		{
			$(window).load(function(){
				methods.refresh();
				$('.s_item',settings._this).height($('.s_container',settings._this).height());

			});
		},
		refresh: function()
		{
			if ($('.s_item',settings._this).length == 0) {$(settings._this).hide();return;}

			if (settings.orientation == "horisontal")
			{
				methods.s_container_width = $('.s_container',settings._this).width();
				if (settings.perPage > 1 && settings.sep_width > 0)
				{
					settings.width = (methods.s_container_width-(settings.perPage-1)*settings.sep_width)/settings.perPage;
					if (settings.first == true)
					{
						$('.s_item:not(:first)',settings._this).before("<div class='sep'></div>");
						$('.sep',settings._this).width(settings.sep_width);
					}
				}
				else
					settings.width = methods.s_container_width/settings.perPage;
				$('.s_item',settings._this).width(settings.width);
				
				if (settings.autoHeight == true)
				{
					var _height = 0;
					$('.s_item',settings._this).height('auto');
					$('.s_item',settings._this).each(function(){
						if ($(this).outerHeight() > _height) _height = $(this).outerHeight();
					});
					$('.s_container',settings._this).height(_height);
				}

			}
			else
			{
				$(this).addClass('m_vertical');
				methods.s_container_height = $('.s_container',this).height();
				if (settings.perPage > 1 && settings.sep_width > 0)
				{
					settings.height = (methods.s_container_height-(settings.perPage-1)*settings.sep_width)/settings.perPage;
					if (settings.first == true)
					{
						$('.s_item:not(:first)',this).before("<div class='sep'></div>");
						$('.sep',this).height(settings.sep_width);
					}
				}
				else
					settings.height = methods.s_container_height/settings.perPage;
				
				$('.s_item',this).height(settings.height);
			}
			
			var s_container = $('.s_container',settings._this);
			$('.btn_left',settings._this).css('margin-top',($(s_container).outerHeight()-$('.btn_left',settings._this).height())/2+"px");
			$('.btn_right',settings._this).css('margin-top',($(s_container).outerHeight()-$('.btn_left',settings._this).height())/2+"px");

			settings.first = false;
		},
		//arrows
		slide_left: function(event,$target)
		{
			// Click Ì‡ÎÂ‚Ó Ì‡˜‡ÎÓ
			//	if (event.which == 1) 
				if (typeof event == "undefined") clearTimeout(settings.timer);
				else if (event.which == 1) clearTimeout(settings.timer);



				s_container = $('.s_container',settings._this);
				simple_slider_container = $('.simple_slider_container',settings._this);
				s_items = $('.s_item',settings._this);
				count = s_items.length;

				bullet = $('.bullet',settings._this);

				if ($(s_container).find('.simple_slider_container:animated').length == 0)
				{
					s_items = $('.s_item',simple_slider_container);
					if ($target == undefined)
					{
						if (settings.perPage > 1 && settings.sep_width > 0)
						{
							simple_slider_container.prepend("<div class='sep'></div>");
							if (settings.orientation == "horisontal")
							{
								$('.sep',simple_slider_container).width(settings.sep_width);
								simple_slider_container.css('left','-'+($(s_items[0]).width()+settings.sep_width)+'px');
							}
							else
							{
								$('.sep',simple_slider_container).height(settings.sep_width);
								simple_slider_container.css('top','-'+($(s_items[0]).height()+settings.sep_width)+'px');
							}
						}
						else
						{
							if (settings.orientation == "horisontal")
							{
								simple_slider_container.css('left','-'+$(s_items[0]).width()+'px');
							}
							else
								simple_slider_container.css('top','-'+$(s_items[0]).height()+'px');

						}

						var l_temp = $(s_items[count-1]);
						simple_slider_container.prepend(  l_temp.clone()  );
						l_temp.remove();
					}
					else
					{
						$i = 0;
						while ($('.s_item:eq(0)',simple_slider_container).attr('num') != $target)
						{
							var l_temp = $(s_items[s_items.length-1-$i]);
							simple_slider_container.prepend(l_temp.clone());
							//l_temp.remove();
							$i++;
						}
						if (settings.orientation == "horisontal")
							simple_slider_container.css('left','-'+$(s_items[0]).width()*$i+'px');
						else
							simple_slider_container.css('top','-'+$(s_items[0]).height()*$i+'px');
						
						if (settings.perPage > 1 && settings.sep_width > 0)
						{
							$('.sep',simple_slider_container).remove();
							$('.s_item:not(:first)',simple_slider_container).before("<div class='sep'></div>");
							
							if (settings.orientation == "horisontal")
								$('.sep',simple_slider_container).width(settings.sep_width);
							else
								$('.sep',simple_slider_container).height(settings.sep_width);
							
						}

					}
					
					if (settings.orientation == "horisontal") settings.way = {left : 0}; else settings.way = {top : 0};


					//«¿√ŒÀŒ¬Œ 
					settings.onlist_begin( simple_slider_container );

					simple_slider_container.animate(settings.way,{duration:settings.speed,easing:"swing",
						complete: function()
						{
							$parent = $(this).parents('.simple_slider').eq(0);
							$count = $parent.attr('count');
							//$count = $('.s_item',$parent).length;
//alert($count);
							bullet = $('.bullet',$parent);
					        
							$('.s_item:gt('+($count-1)+')',this).remove();
							
							if (settings.perPage > 1 && settings.sep_width > 0)
							{
								$('.sep',this).remove();
								$('.s_item:not(:first)',this).before("<div class='sep'></div>");
								if (settings.orientation == "horisontal")
									$('.sep',this).width(settings.sep_width);
								else
									$('.sep',this).height(settings.sep_width);
							}//end_ if					        
					        
							$('span',bullet).removeClass('current');
							$('span',bullet).eq($('.s_item:eq(0)',this).attr('num')).addClass('current');

							//«¿√ŒÀŒ¬Œ 
							settings.onlist_end( simple_slider_container );
						}//end_ complete
					});
					
				}
			// Click Ì‡ÎÂ‚Ó ÍÓÌÂˆ
		},
		// Click Ì‡Ô‡‚Ó Ì‡˜‡ÎÓ
		slide_right: function(event,$target)
		{
			if (typeof event == "undefined") clearTimeout(settings.timer);
			else if (event.which == 1) clearTimeout(settings.timer);

			
			s_container = $('.s_container',settings._this);
			simple_slider_container = $('.simple_slider_container',settings._this);
			s_items = $('.s_item',settings._this);
			count = s_items.length;

			if (  $(s_container).find('.simple_slider_container:animated').length==0  )
			{
				s_items = $('.s_item',simple_slider_container);
				if ($target == undefined)
				{
					if (settings.perPage > 1 && settings.sep_width > 0)
					{
						simple_slider_container.append("<div class='sep'></div>");
						if (settings.orientation == "horisontal")
						{
							$('.sep',simple_slider_container).width(settings.sep_width);
							$left = simple_slider_container.position().left - $(s_items[count-1]).width()-settings.sep_width;
						}
						else
						{
							$('.sep',simple_slider_container).height(settings.sep_width);
							$left = simple_slider_container.position().top - $(s_items[count-1]).height()-settings.sep_width;
						}
						
					}
					else
					{
						if (settings.orientation == "horisontal")
							$left = simple_slider_container.position().left - $(s_items[count-1]).width();
						else
						{
							$left = simple_slider_container.position().top - $(s_items[count-1]).height();
						}
					}


					simple_slider_container.append($(s_items[0]).clone());
				}
				else
				{
					$i = 0;
					while ($('.s_item:eq('+$i+')',simple_slider_container).attr('num') != $target)
					{
						simple_slider_container.append($(s_items[$i]).clone());
						$i++;
					}
					
					if (settings.perPage > 1 && settings.sep_width > 0)
					{
						$('.sep',simple_slider_container).remove();
						$('.s_item:not(:first)',simple_slider_container).before("<div class='sep'></div>");
						if (settings.orientation == "horisontal")
						{
							$('.sep',simple_slider_container).width(settings.sep_width);
							$left = simple_slider_container.position().left - $(s_items[0]).width()*$i-$i*settings.sep_width;
						}
						else
						{
							$('.sep',simple_slider_container).height(settings.sep_width);
							$left = simple_slider_container.position().top - $(s_items[0]).height()*$i-$i*settings.sep_width;
						}
					}
					else
					{
						if (settings.orientation == "horisontal")
							$left = simple_slider_container.position().left - $(s_items[0]).width()*$i;
						else
							$left = simple_slider_container.position().top - $(s_items[0]).height()*$i;							
					}
				}//end_ if_ target
				if (settings.orientation == "horisontal") settings.way = {left : $left}; else settings.way = {top : $left};


				//«¿√ŒÀŒ¬Œ 
				settings.onlist_begin( simple_slider_container );

				simple_slider_container.animate(settings.way,{duration:settings.speed,easing:"swing", 
					complete: function()
					{
						if (settings.orientation == "horisontal")
							$(this).css('left','0px');
						else
							$(this).css('top','0px');
						$parent = $(this).parents('.simple_slider').eq(0);
						$count = $parent.attr('count');
						bullet = $('.bullet',$parent);
						if ($target == undefined)
						{
							$('.s_item:lt(1)',this).remove();
						}
						else
						{
							$('.s_item:lt('+($('.s_item',$parent).length-$count)+')',this).remove();
						}
						
						if (settings.perPage > 1 && settings.sep_width > 0)
						{
							$('.sep',this).remove();
							$('.s_item:not(:first)',this).before("<div class='sep'></div>");
							
							if (settings.orientation == "horisontal")
								$('.sep',this).width(settings.sep_width);
							else
								$('.sep',this).height(settings.sep_width);
						}
						$('span',bullet).removeClass('current');
						num = $($('.s_item',this).get(0)).attr('num');
						$('span',bullet).eq(num).addClass('current');

						//«¿√ŒÀŒ¬ »
						settings.onlist_end( simple_slider_container );
					}//end_ complete
				});//end_ animate
			}
			// Click Ì‡Ô‡‚Ó ÍÓÌÂˆ
		},

		__init_arrows: function()
		{
			switch (settings.btns_effect)
			{
				case "fade":
					$('.btn_container div',settings._this).fadeOut( 200 );
					$(settings._this).hover(
					function(){$('.btn_container div',settings._this).stop();$('.btn_container div',settings._this).fadeIn( 200 );},
					function(){$('.btn_container div',settings._this).stop();$('.btn_container div',settings._this).fadeOut( 200 );}
					);
				break
			}

		
			$('.btn_left',settings._this).click( function(event,$target)
			{
				methods.slide_left(event,$target);
			} );

			$('.btn_right',settings._this).click( function(event,$target)
			{
				methods.slide_right(event,$target);
			} );

		},
		__init_bullets: function()
		{
		
			$('.s_item',settings._this).each(function()
			{
				$num = $('.s_item',settings._this).index(this);
				$('.bullet',settings._this).append('<span></span>');
				$(this).attr('num',$num);
			});

			$('.bullet span:first',settings._this).addClass('current');
			if ($('.s_item',settings._this).length <= settings.perPage) 
			{
				$('.bullet',settings._this).hide();
				$('.btn_left',settings._this).hide();
				$('.btn_right',settings._this).hide();
			}

		
		
			$('.bullet span',settings._this).click(function(event){
				if (event.which == 1) clearTimeout(settings.timer);
				$element = $(this).parents('.simple_slider');
				$target = $('.bullet span',$element).index(this);
				if ($target > $('.s_item:eq(0)',$element).attr('num')) methods.slide_right('',[$target]);
				if ($target < $('.s_item:eq(0)',$element).attr('num')) methods.slide_left('',[$target]);
			});
		},
		init_autoplay : function()
		{
			if (settings.autoPlayTime > 0 && $('.s_item',settings._this).length > settings.perPage) 
			//	settings.timer = setInterval(function(settings._this){$('.btn_right',settings._this).trigger("click");}, settings.autoPlayTime, settings._this);
			settings.timer = setInterval(function(){$('.btn_right',settings._this).trigger("click");}, settings.autoPlayTime);

		},
		__init_mousemove_right_left: function()
		{
			var l_slider_container = $(".slider-container ul",settings._this);
			$("li",l_slider_container).on( 'dragstart', function(){ return false; } );


			$(".s_container",settings._this).on( "touchstart click", function(e)
			{
				var pos = methods.__get_mouse_pos(e);
				console.log(pos);
				//pos x
				settings.__mousedrag.mouse_x_start  = pos.x;
				settings.__mousedrag.drag_state = "start";
			});

			//MOUSE MOVE
			$(".s_container",settings._this).on( "touchmove", function(e)
			{
				e.preventDefault()
				if ( settings.__mousedrag.drag_state=="start" ) settings.__mousedrag.drag_state = "move";
				if ( settings.__mousedrag.drag_state=="move" )
				{
					//console.log( 'touchmove.state '+settings.__mousedrag.drag_state );
					var pos = methods.__get_mouse_pos(e);
					//console.log( 'touchmove.state '+settings.__mousedrag.drag_state+" = "+pos.x );
					settings.__mousedrag.mouse_x_offset = settings.__mousedrag.mouse_x_start-pos.x;
					if ( settings.__mousedrag.mouse_x_start-pos.x>100 )
					{
						e.stopPropagation();
						methods.slide_right();
						settings.__mousedrag.drag_state = "move_end";
					}//end_ if
					if ( pos.x-settings.__mousedrag.mouse_x_start>100 )
					{
						methods.slide_left();
						settings.__mousedrag.drag_state = "move_end";
					}//end_ if
				}//end_ if
			});

			$(".s_container",settings._this).on( "touchend", function(e)
			{
				//console.log( 'touchend.state '+settings.__mousedrag.drag_state );
				settings.__mousedrag.drag_state = "";
			});
		},
		//mobile
		__get_mouse_pos: function(e)
		{
			//e.preventDefault();
			var event = window.event;
			return { 'x': event.touches[0].pageX, 'y': event.touches[0].pageY };
		}
	};//end_ var_ methods

	if (this.length>1)
	{
		return this.each(function()
		{
			$(this).simpleslider( options );
		});//end_ func_ each
	}else
	{
		return this.each(function()
		{
			methods.init(this);
		});//end_ func_ each			
	}//end_ if

};//end_ func_ simpleslider
