function initYandexMapWaitOnHover() {
    function loadScript(url, callback) {
        var script = document.createElement("script");

        if (script.readyState) {  // IE
            script.onreadystatechange = function () {
                if (script.readyState == "loaded" ||
                    script.readyState == "complete") {
                    script.onreadystatechange = null;
                    callback();
                }
            };
        } else {  // Другие браузеры
            script.onload = function () {
                callback();
            };
        }

        script.src = url;
        document.getElementsByTagName("head")[0].appendChild(script);
    }

    var check_if_load = 0;

    function __load_yandex() {
        if (check_if_load == 0) {
            /*var instance = $.fancybox.open(
            {
                animationDuration:0,
                afterShow: function( instance, current )
                {
                    //console.info( instance );
                    $(".fancybox-content").remove();
                    instance.showLoading();
                }

            });*/
            check_if_load = 1;
            //animationDuration
            loadScript("https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;loadByRequire=1", function () {
                /*instance.hideLoading();
                instance.close();*/
                ymaps.load(initYandexMap);
            });
        }
    }//end_ func


    $('#map1').on("touchstart", function () {
        __load_yandex();
    });
    $('#map1').mouseenter(function () {
        __load_yandex();
    });
    $('#map1').click(function () {
        __load_yandex();
    });
}//end_ func


function initYandexMap() {
    ymaps.ready(function () {



// искать все объекты с именем Москва, но вывести только первый
        /*var geocoder = new ymaps.Geocoder("Москва");
        ymaps.Events.observe(geocoder, geocoder.Events.Load, function ()
        {
            if (this.length()) {
                alert("Найдено :" + this.length());
                map.addOverlay(this.get(0));
                map.panTo(this.get(0).getGeoPoint())
            } else {
                alert("Ничего не найдено");
            }
        })*/


        /*var myProvider = {
            suggest: function (request, options)
        {
            //console.log( "-=-=", options.results );
                var res = find(arr, request),
                    arrayResult = [],
                        results = Math.min(options.results, res.length);
                    for (var i = 0; i < results; i++) {
                    arrayResult.push({displayName: res[i], value: res[i]})
                }
                return ymaps.vow.resolve(arrayResult);
            }
        }*/

        var _ball_bg = 'img/map.balloon.png';
        var _ball_Offset = [-26, -43];
        var _ball_Size = [31, 43];


        var myMap1 = new ymaps.Map('map1',
            {
                center: [55.75969980398249,37.706814953826896],
                zoom: 9,
                controls: ['zoomControl']
            },
            {
                searchControlProvider: 'yandex#search'
            });


        //baloon 1
        var myPlacemark1 = new ymaps.Placemark( [55.86146406889051,37.58040899999989],
          {
            balloonContent:"<b>РОЛЬФ Диамант</b><br>Москва, Алтуфьевское ш., 31, стр. 1",
            hintContent: "РОЛЬФ Диамант"
                }, {
            iconLayout: 'default#image',
                  iconImageHref: _ball_bg,
                  iconImageSize: _ball_Size,
                  iconImageOffset: _ball_Offset
          });
          myMap1.geoObjects.add(myPlacemark1);

          //baloon 2
            var myPlacemark2 = new ymaps.Placemark( [55.72010906900426,37.776224],
          {
            balloonContent:"<b>РОЛЬФ Восток</b><br>Москва, Рязанский пр-т, д. 24, к.3",
            hintContent: "РОЛЬФ Восток"
                }, {
            iconLayout: 'default#image',
                  iconImageHref: _ball_bg,
                  iconImageSize: _ball_Size,
                  iconImageOffset: _ball_Offset
          });
          myMap1.geoObjects.add(myPlacemark2);


          //baloon 3
            var myPlacemark3 = new ymaps.Placemark( [55.85994806888662,37.68801849999996],
          {
            balloonContent:"<b>РОЛЬФ Сити</b><br>Москва, Ярославское ш., д. 31",
            hintContent: "РОЛЬФ Сити"
                }, {
            iconLayout: 'default#image',
                  iconImageHref: _ball_bg,
                  iconImageSize: _ball_Size,
                  iconImageOffset: _ball_Offset
          });
          myMap1.geoObjects.add(myPlacemark3);


          //baloon 4
            var myPlacemark4 = new ymaps.Placemark( [55.90567363918124,37.412751407409594],
          {
            balloonContent:"<b>РОЛЬФ Химки</b><br>Химки, Ленинградское ш., вл. 21",
            hintContent: "РОЛЬФ Химки"
                }, {
            iconLayout: 'default#image',
                  iconImageHref: _ball_bg,
                  iconImageSize: _ball_Size,
                  iconImageOffset: _ball_Offset
          });
          myMap1.geoObjects.add(myPlacemark4);


          //baloon 5
            var myPlacemark5 = new ymaps.Placemark( [55.76735576269619,37.522951768508904],
          {
            balloonContent:"<b>РОЛЬФ Центр</b><br>Москва, 2-й Магистральный т-к, 5А",
            hintContent: "РОЛЬФ Центр"
                }, {
            iconLayout: 'default#image',
                  iconImageHref: _ball_bg,
                  iconImageSize: _ball_Size,
                  iconImageOffset: _ball_Offset
          });
          myMap1.geoObjects.add(myPlacemark5);

          //baloon 6
            var myPlacemark6 = new ymaps.Placemark( [55.656859069079985,37.53606849999994],
          {
            balloonContent:"<b>РОЛЬФ Юг</b><br>Москва, ул. Обручева, д. 27, корп. 1",
            hintContent: "РОЛЬФ Юг"
                }, {
            iconLayout: 'default#image',
                  iconImageHref: _ball_bg,
                  iconImageSize: _ball_Size,
                  iconImageOffset: _ball_Offset
          });
          myMap1.geoObjects.add(myPlacemark6);




        //map instance
        window._map = myMap1;
        //new map collection

    });//end_ ready
}//end_ func


function initFancy() {

    $(".fancybox-gallery").fancybox(
        {
            theme: 'light',
            helpers: {thumbs: true},
            openEffect: 'fade',
            closeEffect: 'fade',
            nextEffect: 'fade',
            prevEffect: 'fade',
            'showNavArrows': true
        });

    $(".popup").click(function () {
        var _form_id = $(this).attr('href');

        var _form_title = $(this).attr('_title');
        var _form_comment = $(this).attr('_comment');
        var _form_name = $(this).attr('_form_name');
        var _form_type_model_name = $(this).attr('form_type_model_name');
        var _form_diler = $(this).attr('form_diler');

        var _select_val = $(this).attr('_select_val');

        $(".popup_container").attr('data-flash-title', _form_title);
        $(".popup_container .form_title").html(_form_title);


        $.fancybox.open($(_form_id).html(),
            {
                padding: 0,
                content: $(_form_id).html(),
                //	modal: true,
                scrolling: "no",
                margin: 5,
                /*closeBtn: false,*/
                afterShow: function () {


                    $(".popup_container input[name='title']").val(_form_title);
                    $(".popup_container input[name='comment']").val(_form_comment);
                    $(".popup_container input[name='form_name']").val(_form_name);
                    $(".popup_container input[name='form_type_model_name']").val(_form_type_model_name);
                    $(".popup_container input[name='form_diler']").val(_form_diler);
                    $(".popup_container").attr("data-callkeeper_name", _form_title);
                    $(".popup_container").attr('data-flash-title', _form_title);


                    $("input[name=phone]").inputmask("+7(999) 999-99-99");
                    //_init_inputmask();

                    if (typeof(_select_val) != "undefined") $('.popup_container select').val(_select_val);


                }
            });
        return false;

    });
}//end_ func


function initForm() {
    $("body").on('change', '.agree', function () {
        var _form = $(this).closest('form');
        if ($('.agree:not(:checked)', _form).length == 0)
            $(_form).removeClass("not_agree");
        else
            $(_form).addClass("not_agree");

    });

    $("input[name=phone]").inputmask("+7(999) 999-99-99");

    console.log("!!!!!!");
    $("body").on("submit", "form", function () {
        console.log("!!!!!!");
        if ($(this).hasClass("not_agree")) return false;
        var l_form_object = $(this);
        $("input,textarea,select", this).closest(".form-group").removeClass("has-danger");
        var l_err = false;
        $("input,select,textarea", this).each(function ()//.nacc
        {
            if ($(this)[0].tagName == "SELECT" || $(this)[0].tagName == "INPUT") {
                if ($(this).attr("type") != "submit") {
                    var l_val = $.trim($(this).val());
                    var reg_email = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                    if ($(this).hasClass("nacc")) {
                        //Необходимые поля
                        if ($.trim($(this).val()) == "") {
                            l_err = true;
                            $(this).closest(".form-group").addClass("has-danger");
                        } else if ($(this).attr("name") == "mail" || $(this).attr("name") == "email") {
                            if (!reg_email.test(l_val)) {
                                l_err = true;
                                $(this).closest(".form-group").addClass("has-danger");
                            }//end_ if
                        }//end_ if
                        if ($(this).hasClass("phone") || $(this).attr("name") == "phone") {
                            var l_phone_num = $(this).val().replace(/\D+/g, "");
                            if (l_phone_num.length != 11) {
                                l_err = true;
                                $(this).closest(".form-group").addClass("has-danger");
                            }//end_ if
                        }//end_ if
                        if ($(this).attr("type") == "checkbox" && !$(this).prop("checked")) {
                            l_err = true;
                            $(this).closest(".form-group").addClass("has-danger");
                        }//end_ if
                        if ($(this).attr("type") == "radio") {
                            var l_ctrl_name = $(this).attr("name");
                            if ($("input[name='" + l_ctrl_name + "']:checked").length == 0)//!$(this).prop( "checked"
                            {
                                l_err = true;
                                $(this).closest(".form-group").addClass("has-danger");
                            }
                        }//end_ if
                    } else {
                        //Не обязательные поля
                        if ($.trim($(this).val()) != "") {
                            if ($(this).attr("name") == "mail" || $(this).attr("name") == "email") {
                                if (!reg_email.test(l_val)) {
                                    l_err = true;
                                    $(this).closest(".form-group").addClass("has-danger");
                                }//end_ if
                            }//end_ if
                        }//end_ if
                    }//end_ if
                }//end_ if
            }//end_ if
        });

        var _phone = $("input[name='phone']", l_form_object).val();
        _phone = "+" + _phone.replace(/\D+/g, "");

        console.log("name" + $("input[name='name']", l_form_object).val());
        console.log("phone" + _phone);
        console.log("center" + $("input[name='center']", l_form_object).val());


        if (l_err == true) {
            var instance = $.fancybox.getInstance();
            if (typeof(instance) == "undefined" || instance == false) {
                alert("В одном или нескольких полях введены неверные данные");
            }
            return false;
        }//end_ if


        _form_title = $("input[name='title']", this).val();
        _form_comment = $("input[name='comment']", this).val();
        _form_name = $("input[name='form_name']", this).val();
        _form_type_model_name = $("input[name='form_type_model_name']", this).val();
        _form_diler = $("input[name='form_diler']", this).val();

        function getSearchEngine() {
            var engines = {
              yandex: 'yandex.ru',
              google: 'google.ru',
              mail: 'mail.ru',
              rambler: 'rambler.ru',
              yahoo: 'yahoo.com',
              bing: 'bing.com'
            };

            var referrer = document.referrer;

            var keys = Object.keys(engines);

            for (var i = 0; i < keys.length; i+=1) {
              var item = keys[i];
              if (referrer.indexOf(item) !== -1) {
                return engines[item];
              }
            }
            return '';
        }

        function getQueryObject () {
            var search = document.location.search.substring(1);
            if (!search) {
              return false;
            }

            return JSON.parse('{"' + decodeURI(search).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g,'":"') + '"}');
        }


        _form = this;
        var formData = $(this).serialize();
        var serchEngine = getSearchEngine();
        var queryObject = getQueryObject();

        formData += '&search_engine=' + serchEngine;
        formData += '&referrer=' + document.referrer;

        if(Object.hasOwnProperty.call(window, 'CallKeeper')) {
          formData += '&ga_client_id='+ window.CallKeeper.a.ga_clid;
        }

        Object.keys(queryObject).forEach(item => {
          formData += '&'+ item + '=' + queryObject[item];
        })


        $.post("email.php", formData, function (data) {

            console.log('form_site :' + window.location.href);
            console.log('form_name :' + _form_name);
            console.log('form_type_model_name :' + _form_type_model_name);
            console.log('form_diler :' + _form_diler);
            console.log('form_action :' + 'send_form');
            console.log('event :' + 'event_ok');


            l_form_object.html('Сообщение успешно отправлено');
            $('form').trigger('reset');



            alert("Спасибо за обращение!<br>Мы свяжемся с Вами в ближайшее время", 5000);

            /*alert("Сообщение успешно отправлено");
            $.fancybox.close();*/
        });

        return false;
    });
}//end_ func


function initTopmenu() {
    //$('.top_menu').height($('.top_menu ul:visible').height());
    //$('.top_menu a > span').click(function(){
    $('.top_menu span').click(function () {
        var _li = $(this).closest('li');
        var _ul = $(this).closest('ul');
        $(' > ul', _li).addClass('show');
        $('.top_menu').height($('> ul', _li).height());
        return false;
    });

    $('.top_menu ul > li ul > li > span').click(function () {
        var _parent = $(this).closest('ul').parents('ul');
        $(this).closest('ul').removeClass('show');
        $('.top_menu').height($(_parent).height());
        return false;
    });

    $('.btn_topmenu').click(function () {
        if ($(this).hasClass('open')) {
            $(this).removeClass('open');
            $('.topmenu_container').removeClass('open');
            $('.top_menu ul').removeClass('show');
        }
        else {
            $(this).addClass('open');
            $('.topmenu_container').addClass('open');
            $('.top_menu').height($('.top_menu > ul').height());
        }
    });
    $(document).mousedown(function (event) {
        if ($(event.target).closest('.topmenu_container').length == 0 && !$(event.target).hasClass('btn_topmenu')) {
            $('.btn_topmenu').removeClass('open');
            $('.topmenu_container').removeClass('open');
            $('.top_menu ul').removeClass('show');
        }
    });


}

function initAnchor() {
    $('.anchor[href^="#"]').click(function () {
        //$('.control_section').click(function(){
        var el = $(this).attr('href');
        var _pos = $(el).offset().top;
        $("html, body").animate({scrollTop: _pos}, 500);
        return false;
    });
    $('.anchor[href^="#"]').on("anchor", function () {
        var el = $(this).attr('href');
        var _pos = $(el).offset().top;
        $("html, body").animate({scrollTop: _pos}, 500);
        return false;
    });
}


function initAlert() {
    window.alert = function (e_msg, e_time) {
        $("body").append("<style>.alert{ font-size: 20px; color:black; }</style>");

        if (typeof(e_time) != "undefined") {
            setTimeout(function () {
                $.fancybox.close();
            }, e_time);
        }

        e_msg = '<div class="alert">' + e_msg + '</div>';

        var instance = $.fancybox.getInstance();
        if (typeof(instance) == "undefined" || instance == false) {
            $.fancybox.open(e_msg);
            return;
        }
        instance.current.$slide.trigger("onReset");
        instance.setContent(instance.current, e_msg);
    }//end_ func
}


function initMenu() {
    $(".mobile-button").click(function () {
        $(this).toggleClass("active");
        if ($(this).hasClass("active")) {
            $("header .menu").addClass("active");
        } else {
            $("header .menu").removeClass("active");
        }//end_ if
    });
}//end_ func


function initMobTable() {
    var i = 1;
    $('.resp_table').each(function () {
        $(this).addClass('resp_table' + i);
        var _add_style = "";
        var j = 1;
        $('th', this).each(function () {
            var _text = $(this).html();
            _text = _text.replace("<br>", " ");
            _text = _text.replace("<br/>", " ");
            _text = _text.replace("</br>", " ");
            _text = _text.replace(/<\/?[^>]+>/g, '');
            _text = _text.replace(/\s{2,}/g, ' ');
            if (_text != "") _add_style += ".resp_table" + i + " tr td:nth-child(" + j + "):before {content:'" + _text + "'}";
            j++;
        });
        $(this).after("<style>" + _add_style + "</style>");

        i++;
    });
}//end_ func


function initSlider() {
    var l_prepage = 4;
    var l_prepage2 = 2;
    if ($("body").width() < 1100) {
        l_prepage = 3;
    }
    if ($("body").width() < 600) {
        l_prepage = 2;
    }
    l_prepage = 1;
    $('#mp_simple_slider').simpleslider({perPage: l_prepage, autoPlayTime: 5000, autoHeight: true, sep_width: 20});
    //$('#mp_simple_slider2').simpleslider({perPage : l_prepage2, autoPlayTime : 555000, autoHeight:true, sep_width:50 });
}//end_ func


function initButtonUpDown() {
    $(".block1 .up").click(function () {
        if ($(".block1 .items:animated").length > 0) return false;
        var l_top = $(".block1 .items").scrollTop();
        l_top = l_top - 36;
        $(".block1 .items").stop(true, true).animate({scrollTop: l_top}, '500');
        return false;
    });
    $(".block1 .down").click(function () {
        if ($(".block1 .items:animated").length > 0) return false;
        var l_top = $(".block1 .items").scrollTop();
        l_top = l_top + 36;
        $(".block1 .items").stop(true, true).animate({scrollTop: l_top}, '500');
        return false;
    });
}


//==========================================================================================
//== CALLKEEPER
function sendCallkeeperData(e_vars) {
    if (typeof(e_vars) == "undefined") e_vars = [];

    if (typeof(e_vars["name"]) == "undefined") e_vars["name"] = "";
    if (typeof(e_vars["phone"]) == "undefined") e_vars["phone"] = "";
    if (typeof(e_vars["title"]) == "undefined") e_vars["title"] = "";

    var l_result = {};

    var l_phone = "";
    var l_name = "";
    var l_title = "";

    try {
        l_phone = e_vars["phone"];
        l_name = e_vars["name"];
        l_title = e_vars["title"];

        l_result.name = l_name;
        l_result.phone = l_phone;
        l_result.title = l_title;

        l_result.url = document.location.href;
        l_result.referrer = document.referrer;
        l_result.user_agent = window.navigator.userAgent;

        console.log("sendCallkeeperData", l_result);

        l_result.ya = [];
        l_result.ga = [];
        clientId = "";
        trackingId = "";


        if (typeof(ga) != "undefined" && typeof(ga) == "function") {
            try {
                ga(function (tracker) {
                    if (typeof(ga.getAll) == "function") {
                        //Ga list
                        l_ga_list = ga.getAll();

                        if (typeof(l_ga_list) == "object" && l_ga_list.length > 0) {
                            for (l_key in l_ga_list) {
                                l_ga = l_ga_list[l_key];
                                clientId = l_ga.get('clientId');
                                trackingId = l_ga.get('trackingId');

                                //new ga push
                                l_ga_find = 0;
                                for (l_temp_ga_key in l_result.ga) {
                                    l_temp_ga_value = l_result.ga[l_temp_ga_key];
                                    if (l_temp_ga_value["trackingId"] == trackingId) l_ga_find = 1;
                                }//end_ for
                                if (l_ga_find != 1) {
                                    l_result.ga.push({"type": "list", "trackingId": trackingId, "clientId": clientId});
                                }//end_ if
                            }//end_ for
                            //!!OLD!!
                            if (l_ga_list.length > 0) {
                                clientId = l_ga_list[0].get('clientId');
                                trackingId = l_ga_list[0].get('trackingId');
                            }//end_ if
                        }//end_ if
                    }//end_ if
                    //!!OLD!!
                    //l_result.push( {"trackingId":trackingId, "clientId":clientId} );
                });
            } catch (err) {

                try {
                    clientId = tracker.get('clientId');
                    trackingId = tracker.get('trackingId');

                    //new ga push
                    l_result.ga.push({"type": "single", "trackingId": trackingId, "clientId": clientId});
                } catch (err) {
                }
            }//end_ try_ catch
        }//end_ if

        if (typeof(Ya) != "undefined" && typeof(Ya) == "object" && typeof(Ya.Metrika) == "function" && typeof(Ya.Metrika.counters) == "function") {
            l_ya_counters = Ya.Metrika.counters();
            if (typeof(l_ya_counters) == "object" && typeof(l_ya_counters.length) != "undefined" && l_ya_counters.length > 0) {
                for (var i = 0; i < l_ya_counters.length; i++) {
                    l_ya_counter = l_ya_counters[i];
                    l_ya_counter_type = l_ya_counter.type;
                    l_ya_counter_id = l_ya_counter.id;
                    l_ya_client_id = window["yaCounter" + l_ya_counter_id].getClientID();
                    l_result.ya.push({
                        "type": l_ya_counter_type,
                        "trackingId": l_ya_counter_id,
                        "clientId": l_ya_client_id
                    });
                }//end_ for_ i
            }//end_ if
        }//end_ if
    } catch (err) {
    }

    //console.log( "[[[",l_result );
    console.log("[[[==", JSON.stringify(l_result));

    $.post("callkeeper.php", {"data": JSON.stringify(l_result)}, function (data) {
    });

}//end_ func
//== CALLKEEPER
//==========================================================================================


$(function () {

    $(document).on("change", "input[name='agree']", function () {
        var _form = $(this).closest('form');
        if ($("input[name='agree']:not(:checked)", _form).length == 0)
            $(_form).removeClass("not_agree");
        else
            $(_form).addClass("not_agree");

    });
    $(document).on("click", "form.not_agree input[type='submit'],form.not_agree button[type='submit'],form.not_agree a.submit", function () {
        var _form = $(this).closest('form');
        if ($(_form).hasClass('not_agree')) return false;
    });

    $(document).on("submit", "form", function () {
        if ($(this).hasClass('not_agree')) return false;
    });


    initAlert();
    initAnchor();
    initMenu();
    //initYandexMap();
    initYandexMapWaitOnHover();
    initFancy();
    initForm();
    //initPlus();
    //initMenu();
    initSlider();
    initMobTable();
    initButtonUpDown();
});





