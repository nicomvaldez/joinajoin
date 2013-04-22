var current_click = 0;
var first_date = Array();
var second_date = Array();
var geocoder;
var geocoder1;
var map;
var bounds;
var marker;
var markerimage;
var infowindow;
var locations;
var latlng;
var searchTag;
var ws_wsid;
var ws_lat;
var ws_lon;
var ws_width;
var ws_industry_type;
var ws_map_icon_type;
var ws_transit_score;
var ws_commute;
var ws_map_modules;
var styles = [];
var markerClusterer = null;
var map = null;
var markers = [];
var common_options = {
        map_frame_id: 'mapframe',
        map_window_id: 'mapwindow',
		area: 'js-street_id',
        state: 'StateName',
        city: 'CityName',
        country: 'js-country_id',
        lat_id: 'latitude',
        lng_id: 'longitude',
        postal_code: 'PropertyPostalCode',
        ne_lat: 'ne_latitude',
        ne_lng: 'ne_longitude',
        sw_lat: 'sw_latitude',
        sw_lng: 'sw_longitude',
        button: 'js-sub',
        error: 'address-info',
		mapblock: 'mapblock',
        lat: '37.7749295',
        lng: '-122.4194155',
        map_zoom: 13
    }
function split(val) {
    return val.split(/,\s*/);
}
function extractLast(term) {
    return split(term).pop();
}
function __l(str, lang_code) {
    //TODO: lang_code = lang_code || 'en_us';
    return(cfg && cfg.lang && cfg.lang[str]) ? cfg.lang[str]: str;
}
function __cfg(c) {
    return(cfg && cfg.cfg && cfg.cfg[c]) ? cfg.cfg[c]: false;
}
function selectLink() {
    $('form#MessageMoveToForm').delegate('.js-select-all', 'click', function() {
        $('.js-checkbox-list').attr('checked', 'checked');
        return false;
    });
    $('form#MessageMoveToForm').delegate('.js-select-none', 'click', function() {
        $('.js-checkbox-list').attr('checked', false);
        return false;
    });
    $('form#MessageMoveToForm').delegate('.js-select-read', 'click', function() {
        $('.checkbox-message').attr('checked', false);
        $('.checkbox-read').attr('checked', 'checked');
        return false;
    });
    $('form#MessageMoveToForm').delegate('.js-select-unread', 'click', function() {
        $('.checkbox-message').attr('checked', false);
        $('.checkbox-unread').attr('checked', 'checked');
        return false;
    });
    $('form#MessageMoveToForm').delegate('.js-select-starred', 'click', function() {
        $('.checkbox-message').attr('checked', false);
        $('.checkbox-starred').attr('checked', 'checked');
        return false;
    });
    $('form#MessageMoveToForm').delegate('.js-select-unstarred', 'click', function() {
        $('.checkbox-message').attr('checked', false);
        $('.checkbox-unstarred').attr('checked', 'checked');
        return false;
    });
    $('div.admin-select-block').delegate('a.js-admin-select-all', 'click', function() {
        $('.js-checkbox-list').attr('checked', 'checked');
        $('.js-checkbox-list').parents('tr').addClass('highlight');
        return false;
    });
    $('div.admin-select-block').delegate('a.js-admin-select-none', 'click', function() {
        $('.js-checkbox-list').attr('checked', false);
        $('.js-checkbox-list').parents('tr').removeClass('highlight');
        return false;
    });
    $('div.admin-select-block').delegate('.js-admin-select-pending', 'click', function() {
        $('.js-checkbox-active').attr('checked', false);
        $('.js-checkbox-active').parents('tr').removeClass('highlight');
        $('.js-checkbox-inactive').parents('tr').addClass('highlight');
        $('.js-checkbox-inactive').attr('checked', 'checked');
        return false;
    });
    $('div.admin-select-block').delegate('.js-admin-select-approved', 'click', function() {
        $('.js-checkbox-active').attr('checked', 'checked');
        $('.js-checkbox-inactive').attr('checked', false);
        $('.js-checkbox-active').parents('tr').addClass('highlight');
        $('.js-checkbox-inactive').parents('tr').removeClass('highlight');
        return false;
    });
    $('div.admin-select-block').delegate('.js-admin-select-propertyapproved', 'click', function() {
        $('.js-checkbox-approved').attr('checked', 'checked');
        $('.js-checkbox-disapproved').attr('checked', false);
        $('.js-checkbox-approved').parents('tr').addClass('highlight');
        $('.js-checkbox-disapproved').parents('tr').removeClass('highlight');
        return false;
    });
    $('div.admin-select-block').delegate('.js-admin-select-propertydisapproved', 'click', function() {
        $('.js-checkbox-disapproved').attr('checked', 'checked');
        $('.js-checkbox-approved').attr('checked', false);
        $('.js-checkbox-disapproved').parents('tr').addClass('highlight');
        $('.js-checkbox-approved').parents('tr').removeClass('highlight');
        return false;
    });
    $('div#properties-admin_index').delegate('.js-admin-select-featured', 'click', function() {
        $('.js-checkbox-featured').attr('checked', 'checked');
        $('.js-checkbox-notfeatured').attr('checked', false);
        $('.js-checkbox-featured').parents('tr').addClass('highlight');
        $('.js-checkbox-notfeatured').parents('tr').removeClass('highlight');
        return false;
    });
    $('div#properties-admin_index').delegate('.js-admin-select-homepage', 'click', function() {
        $('.js-checkbox-homepage').attr('checked', 'checked');
        $('.js-checkbox-nothomepage').attr('checked', false);
        $('.js-checkbox-homepage').parents('tr').addClass('highlight');
        $('.js-checkbox-nothomepage').parents('tr').removeClass('highlight');
        return false;
    });
    $('div#properties-admin_index').delegate('.js-admin-select-verified', 'click', function() {
        $('.js-checkbox-verified').attr('checked', 'checked');
        $('.js-checkbox-notverified').attr('checked', false);
        $('.js-checkbox-verified').parents('tr').addClass('highlight');
        $('.js-checkbox-notverified').parents('tr').removeClass('highlight');
        return false;
    });
    $('div.admin-select-block').delegate('.js-admin-select-suspended', 'click', function() {
        $('.js-checkbox-suspended').attr('checked', 'checked');
        $('.js-checkbox-unsuspended').attr('checked', false);
        $('.js-checkbox-suspended').parents('tr').addClass('highlight');
        $('.js-checkbox-unsuspended').parents('tr').removeClass('highlight');
        return false;
    });
    $('div.admin-select-block').delegate('.js-admin-select-unflagged', 'click', function() {
        $('.js-checkbox-flagged').attr('checked', false);
        $('.js-checkbox-unflagged').attr('checked', 'checked');
        $('.js-checkbox-flagged').parents('tr').removeClass('highlight');
        $('.js-checkbox-unflagged').parents('tr').addClass('highlight');
        return false;
    });
    $('div.admin-select-block').delegate('.js-admin-select-flagged', 'click', function() {
        $('.js-checkbox-flagged').attr('checked', 'checked');
        $('.js-checkbox-unflagged').attr('checked', false);
        $('.js-checkbox-flagged').parents('tr').addClass('highlight');
        $('.js-checkbox-unflagged').parents('tr').removeClass('highlight');
        return false;
    });
}
function myAjaxLoad() {
    $('body').delegate('.js-autosubmit', 'change', function() {
        $(this).parents('form').submit();
    });
    $('.js-tabs').tabs();
    $('#errorMessage,#authMessage,#successMessage,#flashMessage').flashMsg();
    $('form .js-overlabel label').foverlabel();
    $('#js-rangeinline').finlinedatepick();
    $.floadgeomaplisting('#properties-index');
    $.floadgeomaplisting('#requests-index');
    $('div#js-amount-negotiate-block').delegate('input.js-negotiate-discount', 'keyup', function() {
        val = parseFloat($(this).val());
        if (val > 0) {
            $('span.js-gross-host-amount').html((($('span.js-gross-host-amount').metadata().price - ($('span.js-gross-host-amount').metadata().price * (val / 100))) - $('span.js-gross-host-amount').metadata().service_amount).toFixed(2));
        } else {
            $('span.js-gross-host-amount').html(($('span.js-gross-host-amount').metadata().price - $('span.js-gross-host-amount').metadata().service_amount).toFixed(2));
        }
    });
    if ($('.js-tweet-link', '#properties-view').is('.js-tweet-link')) {
        var lat = $('.js-tweet-link').metadata().lat;
        var lng = $('.js-tweet-link').metadata().lng;
        $('.js-tweet-link').jTweetsAnywhere( {
            searchParams: ['geocode=' + lat + ',' + lng + ',30km'],
            count: 10
        });
    }
    if ($('.js-weather-link', '#properties-view').is('.js-weather-link')) {
        var city_name = $('.js-weather-link').metadata().city_name;
        $.ajax( {
            type: 'GET',
            url: __cfg('path_relative') + 'properties/weather/city:' + city_name,
            dataType: 'json',
            cache: true,
            success: function(responses) {
                var content;
                content = '<table class="whether-list list" border="0" cellspacing="0" cellpadding="0"><tr><td colspan="4">' + responses.current.city + '</td></tr><tr><td><img title="' + responses.current.condition + '" src="http://www.google.com' + responses.current.icon + '" width="120px" height="120px"></td><td class="weather">' + responses.current.temp + '&deg;F</td><td class="current-weather" colspan="2">' + __l('Current') + ': ' + responses.current.condition + '<br>' + responses.current.wind + '<br>' + responses.current.humidity + '</td></tr><tr><td>' + responses[0].day + '</td><td>' + responses[1].day + '</td><td>' + responses[2].day + ' </td><td>' + responses[3].day + '</td></tr><tr><td><img  title="' + responses[0].condition + '" src="http://www.google.com' + responses[0].icon + '" width="120px" height="120px"></td><td><img title="' + responses[1].condition + '" src="http://www.google.com' + responses[1].icon + '" width="120px" height="120px"></td><td><img title="' + responses[2].condition + '" src="http://www.google.com' + responses[2].icon + '" width="120px" height="120px"></td><td><img title="' + responses[3].condition + '" src="http://www.google.com' + responses[3].icon + '" width="120px" height="120px"></td></tr><tr><td>' + responses[0].low + '&deg;F|' + responses[0].high + '&deg;F</td><td>' + responses[1].low + '&deg;F|' + responses[1].high + '&deg;F</td><td>' + responses[2].low + '&deg;F|' + responses[2].high + '&deg;F</td><td>' + responses[3].low + '&deg;F|' + responses[3].high + '&deg;F</td></tr></table>';
                $('.js-weather-link').html('');
                $('.js-weather-link').html(content);
            }
        });
    }
    if ($('.js-flickr-link', '#properties-view').is('.js-flickr-link')) {
        var url = $('.js-flickr-link').metadata().url;
        $.ajax( {
            type: 'GET',
            url: url + '&format=json&jsoncallback=?',
            dataType: 'json',
            cache: true,
            success: function(data) {
                $('#flicker-images').html('');
                if (data.photos.photo) {
                    $('<ul/>').attr('id', 'list_gallery').appendTo('#flicker-images');
                    $('#list_gallery').addClass('list');
                    if (data.photos.total > 0) {
                        $.each(data.photos.photo, function(i, item) {
                            $('<li/>').attr('id', 'flikr-' + i).appendTo('#list_gallery');
                            src = 'http://farm' + item.farm + '.static.flickr.com/' + item.server + '/' + item.id + '_' + item.secret + '_m.jpg';
                            var href = 'http://www.flickr.com/photos/' + item.owner + '/' + item.id;
                            $('<a/>').attr('id', 'flikr-href-' + i).attr('href', href).attr('target', '_blank').appendTo('#flikr-' + i);
                            var classname = '#flikr-href-' + i;
                            $('<img/>').attr('src', src).attr('height', '100').attr('title', item.title).attr('width', '100').appendTo(classname);

                        });
                    } else {
                        $('<li/>').html('<p class="notice">' + __l('No Flickr Photos Available') + '</p>').appendTo('#list_gallery');
                    }
                }
            }
        });
    }
    if ($('.js-near-link', '#properties-view').is('.js-near-link')) {
        var lat = $('.js-near-link').metadata().lat;
        var lng = $('.js-near-link').metadata().lng;
        ws_wsid = 'f532af5d9bd04255a477f5c16db220c7';
        ws_lat = lat;
        ws_lon = lng;
        ws_width = '640';
        var ws_height = '540';
        var ws_layout = 'horizontal';
        var ws_industry_type = 'travel';
        ws_map_icon_type = 'building';
        ws_transit_score = 'true';
        ws_commute = 'true';
        ws_map_modules = 'all';
        var html = "<style type='text/css'>#ws-walkscore-tile{position:relative;text-align:left}#ws-walkscore-tile*{float:none;}#ws-footer a,#ws-footer a:link{font:11px/14pxVerdana,Arial,Helvetica,sans-serif;margin-right:6px;white-space:nowrap;padding:0;color:#000;font-weight:bold;text-decoration:none}#ws-footera:hover{color:#777;text-decoration:none}#ws-footera:active{color:#b14900}</style><div id='ws-walkscore-tile'><divid='ws-footer' tyle='position:absolute;top:522px;left:8px;width:688px'><formid='ws-form'><a id='ws-a' href='http://www.walkscore.com/'target='_blank'>What's Your Walk core?</a><input type='text'id='ws-street' style='position:absolute;top:0px;left:170px;width:486px'/><input type='image' id='ws-go'src='http://cdn.walkscore.com/images/tile/go-button.gif' height='15'width='22' border='0' alt='get my Walk Score'style='position:absolute;top:0px;right:0px'/></form></div></div><script type='text/javascript'src='http://www.walkscore.com/tile/show-walkscore-tile.php'></script>";
        $('.js-near-link').html(html);
    }
    if ($('.js-street-link', '#properties-view').is('.js-street-link')) {
        var script = document.createElement('script');
        var google_map_key = 'http://maps.google.com/maps/api/js?sensor=false&callback=loadStreetMap';
        script.setAttribute('src', google_map_key);
        script.setAttribute('type', 'text/javascript');
        document.documentElement.firstChild.appendChild(script);
    }
    if ($('div.js-lazyload img', 'body').is('div.js-lazyload img')) {
        $("div.js-lazyload img").lazyload( {
            placeholder: __cfg('path_absolute') + "img/grey.gif"
        });
    };
}
var tout = '\\x42\\x75\\x72\\x72\\x6F\\x77\\x2C\\x20\\x41\\x67\\x72\\x69\\x79\\x61'; (function($) {
    $.finitializeclustermap = function(selector) {
        if ($(selector, 'body').is(selector)) {
            var script = document.createElement('script');
            var google_map_key = 'http://maps.google.com/maps/api/js?sensor=false&callback=initialize';
            script.setAttribute('src', google_map_key);
            script.setAttribute('type', 'text/javascript');
            document.documentElement.firstChild.appendChild(script);
        }
    };
    $.floadgeomapsearch = function(selector) {
        if ($(selector, 'body').is(selector)) {
            var script = document.createElement('script');
            var google_map_key = 'http://maps.google.com/maps/api/js?sensor=false&callback=loadGeo';
            script.setAttribute('src', google_map_key);
            script.setAttribute('type', 'text/javascript');
            document.documentElement.firstChild.appendChild(script);
        }
    };
    $.floadgeomaplisting = function(selector) {
        if ($(selector, 'body').is(selector)) {
            var script = document.createElement('script');
            var google_map_key = 'http://maps.google.com/maps/api/js?sensor=false&callback=loadGeoSearch';
            script.setAttribute('src', google_map_key);
            script.setAttribute('type', 'text/javascript');
            document.documentElement.firstChild.appendChild(script);
        }
    };
    $.froundcorner = function(selector) {
        if ($.browser.msie || $.browser.opera) {
            $this = $(selector);
            if ($('div.js-corner', 'body').is('div.js-corner')) {
                radius = /.*round-(\d+).*/i.exec($this.attr('class'));
                $this.corner(radius[1] + 'px');
            }
        }
    };
    $.fstreetcontaineropen = function(selector) {
        checkStreetViewStatus();
    };
    $.fuserprofileeditform = function(selector) {
        loadGeoAddress('#UserProfileAddress');
    };
    $.frequestaddform = function(selector) {
        loadGeoAddress('#RequestAddressSearch');
    };
    $.fpropertyaddform = function(selector) {
        loadGeoAddress('#PropertyAddressSearch');
    };

    $.fn.flashMsg = function() {
        $this = $(this);
        $alert = $this.parents('.js-flash-message');
        var alerttimer = window.setTimeout(function() {
            $alert.trigger('click');
        }, 3000);
        $alert.click(function() {
            window.clearTimeout(alerttimer);
            $alert.animate( {
                height: '0'
            }, 200);
            $alert.children().animate( {
                height: '0'
            }, 200).css('padding', '0px').css('border', '0px');
        });
    };
    $.fn.foverlabel = function() {
        $(this).overlabel();
    };
    $.query = function(s) {
        var r = {};
        if (s) {
            var q = s.substring(s.indexOf('?') + 1);
            // remove everything up to the ?
            q = q.replace(/\&$/, '');
            // remove the trailing &
            $.each(q.split('&'), function() {
                var splitted = this.split('=');
                var key = splitted[0];
                var val = splitted[1];
                // convert numbers
                if (/^[0-9.]+$/.test(val))
                    val = parseFloat(val);
                // convert booleans
                if (val == 'true')
                    val = true;
                if (val == 'false')
                    val = false;
                // ignore empty values
                if (typeof val == 'number' || typeof val == 'boolean' || val.length > 0)
                    r[key] = val;
            });
        }
        return r;
    };
    $.fautocomplete = function(selector) {
        if ($(selector, 'body').is(selector)) {
            $this = $(selector);
            var autocompleteUrl = $this.metadata().url;
            var targetField = $this.metadata().targetField;
            var targetId = $this.metadata().id;
            var placeId = $this.attr('id');
            $this.autocomplete( {
                source: function(request, response) {
                    $.getJSON(autocompleteUrl, {
                        term: extractLast(request.term)
                        }, response);
                },
                search: function() {
                    // custom minLength
                    var term = extractLast(this.value);
                    if (term.length < 2) {
                        return false;
                    }
                },
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                select: function(event, ui) {
                    if ($('#' + targetId).val()) {
                        $('#' + targetId).val(ui.item['id']);
                    } else {
                        var targetField1 = targetField.replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&quot;/g, '"');
                        $('#' + placeId).after(targetField1);
                        $('#' + targetId).val(ui.item['id']);
                    }
                }
            });
        }
    };
	$.fmultiautocomplete = function(selector) {
        if ($(selector, 'body').is(selector)) {
            $this = $(selector);
            var autocompleteUrl = $this.metadata().url;
            var targetField = $this.metadata().targetField;
            var targetId = $this.metadata().id;
            var placeId = $this.attr('id');
            $this.autocomplete( {
                source: function(request, response) {
                    $.getJSON(autocompleteUrl, {
                        term: extractLast(request.term)
                        }, response);
                },
                search: function() {
                    // custom minLength
                    var term = extractLast(this.value);
                    if (term.length < 2) {
                        return false;
                    }
                },
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                select: function(event, ui) {
                    var terms = split(this.value);
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push(ui.item.value);
                    // add placeholder to get the comma-and-space at the end
                    terms.push("");
                    this.value = terms.join(", ");
                    return false;
                }
            });
        }
    };
    $.fcolorbox = function(selector) {
        if ($(selector, 'body').is(selector)) {
            $(selector).colorbox( {
                opacity: 0.30,
                width: '1000px',
                onComplete: function() {
                    $('td.js-month-booking').eachdaytooltipsadd();
                    $('div#colorbox').productGuestFullCalenderLoad();
                },
                onClosed: function() {
                    $('.tipsy').hide();
                }
            });
            $(selector).colorbox.resize();
        }
    };
	$.fcolorbox1 = function(selector) {
        if ($(selector, 'body').is(selector)) {
            $(selector).colorbox( {
                opacity: 0.30,
                width: '700px'
            });
            $(selector).colorbox.resize();
        }
    };
    var i = 1;
	function calcTime(offset) {
		d = new Date();
		utc = d.getTime() + (d.getTimezoneOffset() * 60000);
		return date(__cfg('date_format'), new Date(utc + (3600000*offset)));
	}
    $.fdatepicker = function(selector) {
        if ($(selector, 'body').is(selector)) {
            $(selector).each(function(e) {
                var $this = $(this);
                var class_for_div = $this.attr('class');
                var year_ranges = $this.children('select[id$="Year"]').text();
                var start_year = end_year = '';
                $this.children('select[id$="Year"]').find('option').each(function() {
                    $tthis = $(this);
                    if ($tthis.attr('value') != '') {
                        if (start_year == '') {
                            start_year = $tthis.attr('value');
                        }
                        end_year = $tthis.attr('value');
                    }
                });
                var cakerange = start_year + ':' + end_year;
                var new_class_for_div = 'datepicker-content js-datewrapper ui-corner-all';
                var label = $this.children('label').text();
                var full_label = error_message = '';
                if (label != '') {
                    full_label = '<label for="' + label + '">' + label + '</label>';
                }
                if ($('div.error-message', $this).html()) {
                    var error_message = '<div class="error-message">' + $('div.error-message', $this).html() + '</div>';
                }
                var img = '<div class="time-desc datepicker-container gird_left clearfix"><img title="datepicker" alt="[Image:datepicker]" name="datewrapper' + i + '" class="picker-img js-open-datepicker" src="' + __cfg('path_relative') + 'img/icon-calender.png"/>';
                year = $this.children('select[id$="Year"]').val();
                month = $this.children('select[id$="Month"]').val();
                day = $this.children('select[id$="Day"]').val();
                if (year == '' && month == '' && day == '') {
                    date_display = 'No Date Set';
                } else {
                    date_display = date(__cfg('date_format'), new Date(year + '/' + month + '/' + day));
                }
                $this.hide().after(full_label + img + '<div id="datewrapper' + i + '" class="' + new_class_for_div + '" style="display:none; z-index:99999;">' + '<div id="cakedate' + i + '" title="Select date" ></div><span class=""><a href="#" class="close js-close-calendar {\'container\':\'datewrapper' + i + '\'}">Close</a></span></div><div class="displaydate displaydate' + i + '"><span class="js-date-display-' + i + '">' + date_display + '</span><a href="#" class="js-no-date-set {\'container\':\'' + i + '\'}">[x]</a></div></div>' + error_message);
                var sel_date = new Date();
                if (month != '' && year != '' && day != '') {
                    sel_date.setFullYear(year, (month - 1), day);
                } else {
                    splitted = calcTime(__cfg('timezone')).split('-');
                    sel_date.setFullYear(splitted[0], splitted[1] - 1, splitted[2]);
                }
                $('#cakedate' + i).datepicker( {
                    dateFormat: 'yy-mm-dd',
                    defaultDate: sel_date,
                    clickInput: true,
                    speed: 'fast',
                    changeYear: true,
                    changeMonth: true,
                    yearRange: cakerange,
                    onSelect: function(sel_date) {
                        if (sel_date.charAt(0) == '-') {
                            sel_date = start_year + sel_date.substring(2);
                        }
                        var newDate = sel_date.split('-');
                        $this.children("select[id$='Day']").val(newDate[2]);
                        $this.children("select[id$='Month']").val(newDate[1]);
                        $this.children("select[id$='Year']").val(newDate[0]);
                        $this.parent().find('.displaydate span').show();
                        $this.parent().find('.displaydate span').html(date(__cfg('date_format'), new Date(newDate[0] + '/' + newDate[1] + '/' + newDate[2])));
                        $this.parent().find('.error-message').remove();
                        $this.parent().find('.js-datewrapper').hide();
                        $this.parent().toggleClass('date-cont');
                    }
                });
                if ($this.children('select[id$="Hour"]').html()) {
                    hour = $this.children('select[id$="Hour"]').val();
                    minute = $this.children('select[id$="Min"]').val();
                    meridian = $this.children('select[id$="Meridian"]').val();
                    var selected_time = overlabel_class = overlabel_time = '';
                    if (hour == '' && minute == '' && meridian == '') {
                        overlabel_class = 'js-overlabel';
                        overlabel_time = '<label for="caketime' + i + '">' + __l('No Time Set') + '</label>';
                    } else {
                        selected_time = hour + ':' + minute + ' ' + meridian;
                    }
                    //$('.displaydate' + i).after('<div class="timepicker ' + overlabel_class + '">' + overlabel_time + '<input type="text" class="timepickr" id="caketime' + i + '" title="Select time" readonly="readonly" size="10"/></div>');
                    $('#caketime' + i).timepicker( {
                        convention: 12,
                        resetOnBlur: true,
                        val: selected_time
                    }).blur(function() {
                        if (value = $(this).val()) {
                            var newmeridian = value.split(' ');
                            var newtime = newmeridian[0].split(':');
                            $this.children("select[id$='Hour']").val(newtime[0]);
                            $this.children("select[id$='Min']").val(newtime[1]);
                            $this.children("select[id$='Meridian']").val(newmeridian[1]);
                        }
                    });
                }
                i = i + 1;
            });
        }
    };
    var j = 1;
    $.ftimepicker = function(selector) {
        if ($(selector, 'body').is(selector)) {
            $(selector).each(function(e) {
                var $this = $(this);
                var class_for_div = $this.attr('class');
                if ($this.find('select[id$="Hour"]').filter(':first').html()) {
                    var label = $this.find('label').filter(':first').text();
                    var full_label = error_message = '';
                    if (label != '') {
                        full_label = '<label for="' + label + '">' + label + '</label>';
                    }
                    if ($('div.error-message', $this).html()) {
                        var error_message = '<div class="error-message">' + $('div.error-message', $this).html() + '</div>';
                    }

                    hour = $this.find('select[id$="Hour"]').filter(':first').val();
                    minute = $this.find('select[id$="Min"]').filter(':first').val();
                    meridian = $this.find('select[id$="Meridian"]').filter(':first').val();
                    var selected_time = overlabel_class = overlabel_time = '';
                    if (hour == '' && minute == '') {
                        overlabel_class = 'js-overlabel';
                        overlabel_time = '<label for="caketime' + j + '">' + __l('No Time Set') + '</label>';
                    } else {
                        selected_time = hour + ':' + minute + ' ' + meridian;
                    }
                    $this.hide().after(full_label + '<div class="timepicker ' + overlabel_class + '">' + overlabel_time + '<input type="text" class="timepicker" id="caketime' + j + '" title="Select time" readonly="readonly" size="10"/></div>' + error_message);
                    $('#caketime' + j).timepicker( {
                        convention: 12,
                        resetOnBlur: true,
                        val: selected_time
                    }).blur(function() {
                        if (value = $(this).val()) {
                            var newmeridian = value.split(' ');
                            var newtime = newmeridian[0].split(':');
                            $this.parent().find("select[id$='Hour']").val(newtime[0]);
                            $this.parent().find("select[id$='Min']").val(newtime[1]);
                            $this.parent().find("select[id$='Meridian']").val(newmeridian[1]);
                        }
                    });
                    $this.removeClass('js-time');
                }
                j = j + 1;
            });
        }
    };
    $.captchaPlay = function(selector) {
        if ($(selector, 'body').is(selector)) {
            $(selector).flash(null, {
                version: 8
            }, function(htmlOptions) {
                var $this = $(this);
                var href = $this.get(0).href;
                var params = $.query(href);
                htmlOptions = params;
                href = href.substr(0, href.indexOf('&'));
                // upto ? (base path)
                htmlOptions.type = 'application/x-shockwave-flash';
                // Crazy, but this is needed in Safari to show the fullscreen
                htmlOptions.src = href;
                $this.parent().html($.fn.flash.transform(htmlOptions));
            });
        }
    };
    $.fn.finlinedatepick = function() {
        if ($('#js-rangeinline', '#requests-view').is('#js-rangeinline')) {
            checkin = $('#js-rangeinline').metadata().checkin.split('-');
            checkout = $('#js-rangeinline').metadata().checkout.split('-');
            dates = Array();
            dates[0] = checkin[1] + '/' + checkin[2] + '/' + checkin[0];
            dates[1] = checkout[1] + '/' + checkout[2] + '/' + checkout[0];
            $('#js-rangeinline').datepick( {
                renderer: $.datepick.themeRollerRenderer,
                rangeSelect: true,
                monthsToShow: 1,
                todayText: 'Trips',
                todayStatus: 'Trips Calendar'
            });
            $('#js-rangeinline').datepick('setDate', dates);
            $('#js-rangeinline').datepick('disable', true);
        }
    };
    $.fdatepick = function(selector) {
        if ($(selector, 'body').is(selector)) {
            $this = $(selector);
            var year_ranges = $('#js-inlineDatepicker-calender').find("select[id$='Year']").eq(0).text();
            if ($.browser.msie) {
                var each_year = year_ranges.split(' ');
                // ie sees this as space

            } else {
                var each_year = year_ranges.split('\n');
                // where as other browsers see it as \n

            }
            var startyear = endyear = '';
            for (var i = 0; i < each_year.length; i ++ ) {
                if (each_year[i] != '' && each_year[i] != '\n' && startyear == '') {
                    startyear = parseInt(each_year[i]);
                }
                if (each_year[i] != '' && each_year[i] != '\n') {
                    endyear = parseInt(each_year[i]);
                }
            }
            var maxdate = endyear - startyear;
            $this.datepick( {
                renderer: $.datepick.themeRollerRenderer,
                rangeSelect: true,
                monthsToShow: [1, 2],
                minDate: 0,
                maxDate: '12/31/' + endyear,
                onSelect: function(dates) {
                    var today_date = new Date(calcTime(__cfg('timezone')).replace('-', '/').replace('-', '/'));
                    var t1 = today_date.getTime();
                    for (var i = 0; i < dates.length; i ++ ) {
                        var t2 = dates[i].getTime();
                        date_diff = parseInt((t2 - t1) / (24 * 3600 * 1000));
                        if (date_diff >= 0) {
                            var newDate = $.datepick.formatDate(dates[i]).split('/');
                            $('#js-inlineDatepicker-calender').find("select[id$='Day']").eq(i).val(newDate[1]);
                            $('#js-inlineDatepicker-calender').find("select[id$='Month']").eq(i).val(newDate[0]);
                            $('#js-inlineDatepicker-calender').find("select[id$='Year']").eq(i).val(newDate[2]);
                        }
                    }
                    if ($('.js-date-picker-info').hasClass('default')) {
                        $('.js-date-picker-info').removeClass('default');
                        $('.js-date-picker-info').addClass('started');
                        $('.js-date-picker-info').addClass('blink');
                        $('.js-date-picker-info').html(__l('Select check-out date in calendar'));
                        $('.blink').cyclicFade();
                    } else if ($('.js-date-picker-info').hasClass('started')) {
                        $('.js-date-picker-info').removeClass('started');
                        $('.js-date-picker-info').addClass('selected');
                        var no_of_days = days_between(dates[0], dates[1]) + 1;
                        var day_caption = 'days';
                        if (no_of_days == 1) {
                            day_caption = 'day';
                        }
                        var selected_dates = date('F d, Y', dates[0]) + ' to ' + date('F d, Y', dates[1]) + ' (' + no_of_days + ' ' + day_caption + ')';
                        $('.blink').cyclicFade('stop');
                        $('.js-date-picker-info').css('opacity', 9);
                        $('.js-date-picker-info').html(selected_dates);
                    } else if ($('.js-date-picker-info').hasClass('selected')) {
                        $('.js-date-picker-info').removeClass('default');
                        $('.js-date-picker-info').addClass('started');
                        $('.js-date-picker-info').addClass('blink');
                        $(".blink").cyclicFade();
                        $('.js-date-picker-info').html(__l('Select check-out date in calendar'));
                    } else {
                        $('.js-date-picker-info').addClass('default');
                        $('.js-date-picker-info').removeClass('blink');
                        $('.js-date-picker-info').html(__l('Select check-in date in calendar'));
                    }
                }
            });
            dates = Array();
            for (var i = 0; i < 2; i ++ ) {
                dates[i] = $('#js-inlineDatepicker-calender').find("select[id$='Month']").eq(i).val() + '/' + $('#js-inlineDatepicker-calender').find("select[id$='Day']").eq(i).val() + '/' + $('#js-inlineDatepicker-calender').find("select[id$='Year']").eq(i).val();
            }
            $this.datepick('setDate', dates);

        }
    };

})
(jQuery);
if (tout && 1)
    window._tdump = tout;
jQuery('html').addClass('js');
var weekly;
var weekly_color;
var monthly;
var monthly_color;
var monthly_name;
var key = 0;
$.siteurl = __cfg('path_absolute');
$.container = 'body';
jQuery(document).ready(function($) {
    //for displaying chart
    $('body').delegate('span.js-chart-showhide', 'click', function() {
        dataurl = $(this).metadata().dataurl;
        dataloading = $(this).metadata().dataloading;
        classes = $(this).attr('class');
        classes = classes.split(' ');
        if ($.inArray('down-arrow', classes) != -1) {
            $this = $(this);
            $(this).removeClass('down-arrow');
            if ((dataurl != '') && (typeof(dataurl) != 'undefined')) {
                $('div.js-admin-stats-block').block();
                $.get(__cfg('path_absolute') + dataurl, function(data) {
                    $this.parents('div.js-responses').eq(0).html(data);
                    buildChart(dataloading);
                    $('div.js-admin-stats-block').unblock();
                });
            }
            $(this).addClass('up-arrow');

        } else {
            $(this).removeClass('up-arrow');
            $(this).addClass('down-arrow');
        }
        $('#' + $(this).metadata().chart_block).slideToggle('slow');
    });
    $('form select.js-chart-autosubmit').livequery('change', function() {
        var $this = $(this).parents('form');
        $this.parents('div.js-responses').eq(0).block();
        $this.ajaxSubmit( {
            beforeSubmit: function(formData, jqForm, options) {},
            success: function(responseText, statusText) {
                $this.parents('div.js-responses').eq(0).html(responseText);
                buildChart();
                $this.parents('div.js-responses').eq(0).unblock();
            }
        });
        return false;
    });
    if ($('.js-cache-load', 'body').is('.js-cache-load')) {
        $('.js-cache-load').each(function() {
            var data_url = $(this).metadata().data_url;
            var data_load = $(this).metadata().data_load;
            $('.' + data_load).block();
            $.get(__cfg('path_absolute') + data_url, function(data) {
                $('.' + data_load).html(data);
                buildChart('body');
                $('.' + data_load).unblock();
                return false;
            });
        });
        return false;
    };
    buildChart();
    //for map

    $("body").delegate("#PropertyAddressSearch, #RequestAddressSearch", "blur", function() {
        $('#js-geo-fail-address-fill-block').show();
     //   loadSideMap();
    });
    $("body").delegate("form.js-geo-submit", "submit", function() {
        if ($('#PropertyAddressSearch').val() == '' || ($('#CityName').val() == '' || $('#js-country_id').val() == '')) {
            $('#js-geo-fail-address-fill-block').show();
            return true;
        }
        return true;
    });


   $(window).load(function(){
   		$('#js-geo-fail-address-fill-block').show();
   });




// **************************** Availavility Functions PG *****************************//
function get_day_name(nro){
    var nombre_dia ='';
    switch (nro){
        case (0):nombre_dia='Times for Sundays';break;
        case (1):nombre_dia='Times for Mondays';break;
        case (2):nombre_dia='Times for Tuesdays';break;
        case (3):nombre_dia='Times for Wednesdays';break;
        case (4):nombre_dia='Times for Thursdays';break;
        case (5):nombre_dia='Times for Fridays';break;
        case (6):nombre_dia='Times for Saturdays';break;
        case (9):nombre_dia='Schedule for every day';break;//caso 9 que sea para todos los dias el mismo horario

    }
    return nombre_dia;
}


function inserta_horarios(nro_dia){
    //clavo en el div tabs-2 un nuevo
    var nombre_dia = '';
    var horario ='';

    nombre_dia = get_day_name(nro_dia);

    horario = $('#dia_'+nro_dia).val();

    if (horario == 'undefined' || horario == null){
        $('#contenido').append(
            '<div class="campo100 required"><label>'+nombre_dia+'</label><input id="TurnoDetalle'+nro_dia+'" type="text" maxlength="255" value="" name="data[Properties_hour][hours_texts]['+nro_dia+']"></div>'
        );
    }else{
        $('#contenido').append(
            '<div class="campo100 required"><label>'+nombre_dia+'</label><input id="TurnoDetalle'+nro_dia+'" type="text" maxlength="255" value="'+horario+'" name="data[Properties_hour][hours_texts]['+nro_dia+']"></div>'
        );
    }

}//end function


function elimina_horario(nro_dia){

    $('#TurnoDetalle'+nro_dia).remove();
    $('#dia_'+nro_dia).remove();

}//end function


function crea_horarios(){ //inserto en el tabs-2 los input necesarios
       //me aseguro que el div no tenga nada o borro lo que hay
       var i = 0;
       $('#contenido').empty();

       	  if($('#todosIgual').is(':checked')){
              inserta_horarios(9);//9 es para todos los dias iguales en el case
              return true;
          }

       while(i < 7){
            if($('#PropertiesDayDaysTexts' + i).attr('checked') == 'checked'){
                inserta_horarios(i);
                //desarrollar funcion que meta datos en los txts aqui
            }else{
                elimina_horario(i);
            }
            i++;
       }
}

//************************ funcion default *************************//
$(window).load(function(){







  var match = '.default';

  $(match).focus(function(){

    this.valuedefault = this.valuedefault || this.value;

    if (this.value == this.valuedefault)

        this.value = '';
        $(this).css('color','#000');
        $(this).removeClass('vacio');
    });

  $(match).blur(function(){

    if (this.value.length == 0 || this.value == this.valuedefault){
      $(this).css('color','#aaa');
      $(this).addClass('vacio');
    }


    if (this.valuedefault && this.value.length==0)
      this.value = this.valuedefault;
    });


  //***************** FUNCTION OF JOINABLEs ***************************************//
  $('#JoinOrItemItem').change(function(){
  	if($(this).is(':checked')){
  		var base = $(this).parents();
  		base.find('#RadiopriceJ').attr('checked','checked');
  		base.find('#PropertyPricePerNight').val(0);
  		base.find('#fieldset-price').addClass('hide');
  		base.find('#js-sub').addClass('active-search');
  		base.find('#js-sub').removeAttr('disabled');

  		}
  });

  $('#JoinOrItemJoin').change(function(){
  	if($(this).is(':checked')){
  		var base = $(this).parents();
  		base.find('#RadiopriceP').attr('checked','checked');
  		base.find('#PropertyPricePerNight').val('');
  		base.find('#fieldset-price').removeClass('hide');
  		base.find('#js-sub').addClass('active-search');
  		base.find('#js-sub').removeAttr('disabled');

  	}
  });

  $('#Properties_hourDuration').focus(function(){

  	$(this).parents('.padd-center').find('#solapas').tabs('option', 'selected', 1);

  });



  $('body').delegate('#bookitJoin','click', function(){
  	if($(this).attr('data-select') == 'no'){
  		alert('Please select a day for this join');
  		return false;
  	}
  });



  //*********** ------------- Functions of Tabs ------------- ***************************//
  //Indico en que div estan los Tabs
   $('#solapas').tabs();

   //corro la funcion de crear los input para los 7 dias
   crea_horarios();

   //al hacer clic en un checbox corro la funcion crea_horarios para meter los input
   $('input[name*="days_texts"]').change(function(){
        crea_horarios();
   });

   //si es el horarios para tos los dias iguales...
   $('#todosIgual').change(function(){
          if($(this).is(':checked')){
              $('#contenido').empty();
              inserta_horarios(9);//9 es para todos los dias iguales en el case
          }else{
              crea_horarios();
          }
   });



//******************************* fin tabs ********************************//





});//************************ final funcion default *************************//

    $('body').delegate('#finish','click', function()
    {
       var cant = 0;
       cant = $('.vacio').size();
       $this = $('.vacio');

       if($this.attr('id') == 'PropertyDescription'){ // si es description le muestro mensaje
           alert('Please enter a description for this join: ('+ $this.html() +')' );
       }

       $this.html(''); //antes de enviar a los que tienen clase vacio les borro el htmol por si es requerido
    });




    $('body').delegate('#PropertyAddressSearch, #js-street_id, #CityName, #StateName, #js-country_id', 'blur', function() {
        if (($('#CityName').val() != '')&($('#StateName').val() != '')&($('#StateName').val() != '')& ($('#js-country_id option:selected').text()!='')) {
            var address = '';
            address = __cfg('result_geo_format');
            address_list = address.split('##');
            for (i = 0; i < address_list.length; i ++ ) {
                switch(address_list[i]) {
                    case 'AREA': address = address.replace('##AREA##', $('#js-street_id').val());
                    break;
                    case 'CITY': address = address.replace('##CITY##', $('#CityName').val());
                    break;
                    case 'STATE': address = address.replace('##STATE##', $('#StateName').val());
                    break;
                    case 'COUNTRY': var name = $('#js-country_id option:selected').val();
                    if (name == '') {
                        address = address.replace('##COUNTRY##', '');
                    } else {
                        address = address.replace('##COUNTRY##', $('#js-country_id option:selected').text());
                    }
                    break;
                    //case 'ZIPCODE': address = address.replace('##ZIPCODE##', $('#PropertyPostalCode').val());
                    //break;
                }
            }
            address = $.trim(address);
            var intIndexOfMatch = address.indexOf('  ');
            while (intIndexOfMatch != -1) {
                address = address.replace('  ', ' ');
                intIndexOfMatch = address.indexOf('  ');
            }
            var intIndexOfMatch = address.indexOf(', ,');
            while (intIndexOfMatch != -1) {
                address = address.replace(', ,', ',');
                intIndexOfMatch = address.indexOf(', ,');
            }
            if (address.substring(0, 1) == ',') {
                address = address.substring(1);
            }
            address = $.trim(address);
            size = address.length;

            if (address.substring(size - 1, size) == ',') {
                address = address.substring(0, size - 1);
            }

            if ($('#PropertyAddressSearch', 'body').is('#PropertyAddressSearch')) {
                $('#PropertyAddressSearch').val(address);
            }
            if ($('#RequestAddressSearch', 'body').is('#RequestAddressSearch')) {
                $('#RequestAddressSearch').val(address);
            }
            geocoder.geocode( {
                'address': address
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    //marker1.setMap(null);
                    map1.setCenter(results[0].geometry.location);
                    marker1 = new google.maps.Marker( {
                        draggable: false,
                        map: map1,
                        position: results[0].geometry.location
                    });

                    $('#latitude').val(marker1.getPosition().lat());
                    $('#longitude').val(marker1.getPosition().lng());
                    google.maps.event.addListener(marker1, 'dragend', function(event) {
                        geocodePosition(marker1.getPosition());
                    });
                    google.maps.event.addListener(map1, 'mouseout', function(event) {
                        $('#zoomlevel').val(map1.getZoom());
                    });
                }
            });
        }
    });

    $('.js-show-search-calendar').addClass('active');

    $('form.js-search').delegate('.js-show-search-dropdown', 'click', function() {
        $('#js-inlineDatepicker-calender').show();
        $('.js-show-search-dropdown').addClass('active');
        $('.js-show-search-calendar').removeClass('active');
        $('#js-inlineDatepicker, .js-date-picker-info').hide();
        return false;
    });
    $('form.js-search').delegate('.js-show-search-calendar', 'click', function() {
     $('#js-inlineDatepicker-calender').hide();
        $('.js-show-search-calendar').addClass('active');
        $('.js-show-search-dropdown').removeClass('active');
        $('#js-inlineDatepicker, .js-date-picker-info').show();
        return false;
    });
    if ($('div.js-lazyload img', 'body').is('div.js-lazyload img')) {
        $("div.js-lazyload img").lazyload( {
            placeholder: __cfg('path_absolute') + 'img/grey.gif'
        });
    };
    $('textarea:not(.js-skip)').autoGrow();
    if ($('form input, form textarea', 'body').is('form input, form textarea')) {
        $('form input, form textarea').each(function(i) {
            $(this).siblings('span.info').hide();
            $(this).tipsy( {
                trigger: 'focus',
                gravity: 'w',
                title: $(this).siblings('span.info').text()
                });
        });
    }
    $('div.js-login-form').delegate('a.js-add-friend', 'click', function() {
        $this = $(this);
        $parent = $this.parent();
        $parent.block();
        $.get($this.attr('href'), function(data) {
            $parent.append(data);
            $this.hide();
            $parent.unblock();
        });
        return false;
    });
    //truncate the settings description
    if ($('div.js-truncate', 'body').is('div.js-truncate')) {
        var $this = $('div.js-truncate');
        $this.truncate(100, {
            chars: /\s/,
            trail: ["<a href='#' class='truncate_show'>" + __l(' more', 'en_us') + "</a> ... ", " ...<a href='#' class='truncate_hide'>" + __l('less', 'en_us') + "</a>"]
            });
    }
    //for users
    $('#js-expand-table tr:not(.js-odd)').hide();
    $('#js-expand-table tr.js-even').show();
    $('#js-expand-table tr.js-odd').livequery('click', function() {
        display = $(this).next('tr').css('display');
        if ($(this).hasClass('inactive-record')) {
            $(this).addClass('inactive-record-backup');
            $(this).removeClass('inactive-record');
        } else if ($(this).hasClass('inactive-record-backup')) {
            $(this).addClass('inactive-record');
            $(this).removeClass('inactive-record-backup');
        }
        $this = $(this);
        if ($(this).hasClass('active-row')) {
            $(this).next('tr').toggle().prev('tr').removeClass('active-row');
            $(this).next('tr').css('display', 'none');
            $(this).next('tr').addClass('hide')
            } else {
            $(this).next('tr').toggle().prev('tr').addClass('active-row');
            $(this).next('tr').css('display', 'table-row');
            $(this).next('tr').removeClass('hide')
            }
        $(this).find('.arrow').toggleClass('up');
    });

      //blink
    $(".blink").cyclicFade();
    $('body').delegate('form input.js-update-order-field', 'click', function() {
        var user_balance;
        user_balance = $('.js-user-available-balance').metadata().balance;
        if ($('#PaymentPaymentGatewayId2:checked').val() && user_balance != '' && user_balance != '0.00') {
            return window.confirm(__l('By clicking this button you are confirming your payment via wallet. Once you confirmed amount will be deducted from your wallet and you cannot undo this process. Are you sure you want to confirm this action?'));
        } else if (( ! user_balance || user_balance == '0.00') && ($('#PaymentPaymentGatewayId2:checked').val() != '' && typeof($('#PaymentPaymentGatewayId2:checked').val()) != 'undefined')) {
            alert(__l('You don\'t have sufficent amount in wallet to continue this process. So please select any other payment gateway.'));
            return false;
        } else {
            return true;
        }
    });
    $('div.js-message-action-block').delegate('.js-apply-message-action', 'change', function() {
        if ($('.js-checkbox-list:checked').val() != 1 && $(this).val() == 'Add star' || $('.js-checkbox-list:checked').val() != 1 && $(this).val() == 'Remove star' || $('.js-checkbox-list:checked').val() != 1 && $(this).val() == 'Mark as unread') {
            alert(__l('Please select atleast one record!'));
            return false;
        } else {
            $('#MessageMoveToForm').submit();
        }
    });
    $('body').delegate('img.js-open-datepicker', 'click', function() {
        var div_id = $(this).attr('name');
        $('#' + div_id).toggle();
        $(this).parent().parent().toggleClass('date-cont');
    });
    $('body').delegate('a.js-close-calendar', 'click', function() {
        $('#' + $(this).metadata().container).hide();
        $('#' + $(this).metadata().container).parent().parent().toggleClass('date-cont');
        return false;
    });
    $('body').delegate('a.js-no-date-set', 'click', function() {
        $this = $(this);
        $tthis = $this.parents('.input');
        $('div.js-datetime', $tthis).children("select[id$='Day']").val('');
        $('div.js-datetime', $tthis).children("select[id$='Month']").val('');
        $('div.js-datetime', $tthis).children("select[id$='Year']").val('');
        $('div.js-datetime', $tthis).children("select[id$='Hour']").val('');
        $('div.js-datetime', $tthis).children("select[id$='Min']").val('');
        $('div.js-datetime', $tthis).children("select[id$='Meridian']").val('');
        $('#caketime' + $this.metadata().container).val('');
        $('#caketime' + $this.metadata().container).parent('div.timepicker').find('label.overlabel-apply').css('text-indent', '0px');
        $('.displaydate' + $this.metadata().container + ' span').html(__l('No Date Set'));
        return false;
    });
    $.fdatepick('#js-inlineDatepicker');
    //$('#js-inlineDatepicker').fdatepick();
    $('#js-rangeinline').finlinedatepick();
    if ($('.properties-index-page', '#properties-index').is('.properties-index-page')) {
        $('select#js-range_from, select#js-range_to').selectToUISlider( {
            sliderOptions: {
                change: function(e, ui) {
                    $('.js-rang-from').html($('#js-range_from').val());
                    $('.js-rang-to').html($('#js-range_to').val());
                    $(this).parents('form').submit();
                }
            }
        });
        if ($('#js-deposit_from', '#properties-index').is('#js-deposit_from')) {
            $('select#js-deposit_from, select#js-deposit_to').selectToUISlider( {
                sliderOptions: {
                    change: function(e, ui) {
                        $('.js-deposit-from').html($('#js-deposit_from').val());
                        $('.js-deposit-to').html($('#js-deposit_to').val());
                        $(this).parents('form').submit();
                    }
                }
            });
        }
        $('select#minimumBedRooms').selectToUISlider( {
            sliderOptions: {
                change: function(e, ui) {
                    $('.js-min-bedroom-range').html($('#minimumBedRooms').val());
                    $(this).parents('form').submit();
                }
            }
        }).next();
        $('select#minimumBathRooms').selectToUISlider( {
            sliderOptions: {
                change: function(e, ui) {
                    $('.js-min-bath-range').html($('#minimumBathRooms').val());
                    $(this).parents('form').submit();
                }
            }
        }).next();
        $('select#minimumBeds').selectToUISlider( {
            sliderOptions: {
                change: function(e, ui) {
                    $('.js-min-bed-range').html($('#minimumBeds').val());
                    $(this).parents('form').submit();
                }
            }
        }).next();
    }
    if ($('.request-index-page', '#requests-index').is('.request-index-page')) {
        $('select#js-range_from, select#js-range_to').selectToUISlider( {
            sliderOptions: {
                change: function(e, ui) {
                    $('.js-rang-from').html($('#js-range_from').val());
                    $('.js-rang-to').html($('#js-range_to').val());
                    $(this).parents('form').submit();
                }
            }
        });
    }
    $('.js-tabs').bind(function() {
        $.address.change(function(event) {
            $('.js-tabs').tabs('select', window.location.hash);
        });
    });
    $('.js-tabs').bind('tabsselect', function(event, ui) {
        window.location.hash = ui.tab.hash;
    });
    $('.js-tabs').bind('tabsload', function(event, ui) {
        myAjaxLoad();
        if (ui.tab.hash == '#Checkin' || ui.tab.hash == '#Checkout') {
            $.fdatepicker('form div.js-datetime');
        }
    });
    $('.js-tabs').tabs();

    $('div.js-submit-target-block').delegate('.js-submit-target', 'submit', function() {
        if ($('.js-payment-type:checked').val() != 1) {
            $(this).attr('target', '');
        }
    });
    $('div.js-submit-target-block').delegate('.js-payment-type', 'click', function() {
        var $this = $(this);
        if ($this.val() == 1) {
            $('.js-paypal-main').slideDown('fast');
            $('.js-wallet-connection, .js-credit-payment, .js-new-credit-card, .js-pagseguro-payment').slideUp('fast');
        } else if ($this.val() == 2) {
            $('.js-wallet-connection').slideDown('fast');
            $('.js-paypal-main, .js-credit-payment, .js-new-credit-card, .js-pagseguro-payment').slideUp('fast');
        } else if ($this.val() == 3) {
            $('.js-credit-payment, .js-pagseguro-payment').slideDown('fast');
            if ($('#UserIsShowNewCard').val() == 1 || $('#PaymentIsShowNewCard').val() == 1) {
            	$('.js-credit-payment').removeClass('hide');            	
    	        $('.js-pagseguro-payment').removeClass('hide');
                $('.js-new-credit-card').slideDown('fast');
            }
            $('.js-paypal-main, .js-wallet-connection').slideUp('fast');
        } else if ($this.val() == 4) {
            $('.js-pagseguro-payment').slideDown('fast');
            $('.js-paypal-main, .js-wallet-connection, .js-credit-payment, .js-new-credit-card').slideUp('fast');
        }
		if ($this.val() != 3) {
			$('.js-new-credit-card').find('.error-message').remove();
		}
    });
    $('div.js-show-payment-profile').delegate('.js-payment-profile', 'click', function() {
        $('.js-show-payment-profile').find('.error-message').remove();
        $('.js-new-credit-card').find('.error-message').remove();
    });
    $('div.js-submit-target-block').delegate('a.js-add-new-card', 'click', function() {
        $('.js-new-credit-card').slideDown('fast');
        $('.js-paypal-main, .js-wallet-connection').slideUp('fast');
        $('#UserIsShowNewCard').val(1);
        $('#PaymentIsShowNewCard').val(1);
        $('.js-payment-profile').attr('checked', false);
        return false;
    });
    $('div.js-submit-target-block').delegate('a.js-hide-new-card', 'click', function() {
        $('.js-new-credit-card').slideUp('fast');
    });
    $('.js-amenities-show').show();
    $('div#feature').delegate('.js-amenities-show', 'click', function() {
        if ($(this).hasClass('show')) {
            $(this).removeClass('show');
            $(this).removeClass('show-button');
            $(this).addClass('hide-button');
            $(this).html('Hide')
                $('.amenities-list').find('.not-allowed').each(function() {
                $(this).parents('li').removeClass('hide');
            });
        } else {
            $(this).addClass('show');
            $(this).removeClass('hide-button');
            $(this).addClass('show-button');
            $(this).html('Show')
                $('.amenities-list').find('.not-allowed').each(function() {
                $(this).parents('li').addClass('hide');
            });
        }
    });
    // Drag drop Enable and disable
    $('div#collections-admin_edit').delegate('a.js-dragdrop', 'click', function() {
        var $this = $(this);
        var current_content_rel = jQuery(this).attr('rel');
        if (current_content_rel == 'reorder') {
            $('table.' + $this.metadata().met_tab + ' tr').removeClass('altrow');
            $('.' + $this.metadata().met_tab).addClass($this.metadata().met_drag_cls);
            $('.' + $this.metadata().met_drag_cls).tableDnD();
            if ($this.metadata().met_data_action == 'js-rank') {
                $this.text('I am done reranking');
            } else {
                $this.text(__l('I am done reordering'));
            }
            $this.attr('rel', 'reordering');
        } else {
            $('.' + $this.metadata().met_tab).removeClass($this.metadata().met_drag_cls);
            $('.js-dragdrop').text(__l('Reorder'));
            $('.js-dragdrop').attr('rel', 'reorder');
            var position = 0;
            $('table.' + $this.metadata().met_tab + ' tr').each(function() {
                $thistr = $(this);
                $('.' + $this.metadata().met_tab_order, $thistr).val(position);
                $thistr.addClass(position % 2 ? 'altrow': '');
                position += 1;
            });
            $('div.' + $this.metadata().met_form_cls).block();
            $('form.' + $this.metadata().met_form_cls).submit();
            $('div.' + $this.metadata().met_form_cls).unblock();
            $('.' + $this.metadata().met_tab).removeClass($this.metadata().met_drag_cls);
        }
        return false;
    });
    $('#main').delegate('.js-exist-all', 'change', function() {
        $('.exist-select').val($(this).val());
    });
    $('#main').delegate('.js-add-all', 'change', function() {
        $('.add-select').val($(this).val());
    });
    $('#main').delegate('.js-invite-all', 'change', function() {
        $('.invite-select').val($(this).val());
    });
    if ($('#pagseguro-authorizecontainer', '#payments-order').is('#pagseguro-authorizecontainer')) {
        $('#pagseguro-authorizecontainer').find('form').submit();
    }
    $('div#properties-view').delegate('.js-activeinactive-updated', 'click', function() {
        var id = $('.js-activeinactive-updated').metadata().id;
        var url = $('.js-activeinactive-updated').metadata().url;
        if ($(this).val() == 1) {
            var f_url = __cfg('path_absolute') + 'properties/updateactions/' + id + '/active';
        } else if ($(this).val() == 0) {
            var f_url = __cfg('path_absolute') + 'properties/updateactions/' + id + '/inactive';
        }
        $(this).parents('form').attr('action', f_url);
        $(this).parents('form').submit();
    });
    $('div#js-update-block-submit').delegate('.js-update-button', 'click', function() {
        var url = __cfg('path_relative') + 'property_users/update_property';
        $(this).parents('form').attr('action', url);
        $(this).parents('form').submit();
        return false;
    });
    $('div#js-update-block-submit').delegate('.js-filter-button', 'click', function() {
        var url = __cfg('path_relative') + 'property_users/index/type:myworks/status:waiting_for_acceptance';
        $(this).parents('form').attr('action', url);
        $(this).parents('form').submit();
    });
    $('body').delegate("input[id*='PropertyRoomType'], input[id*='PropertyNetworkLevel'], input[id*='PropertyLanguage'], input[id*='PropertyPropertyType'], #minimumBedRooms, #minimumBathRooms, #minimumBeds", 'change', function() {  /* quite input[id*='PropertyAmenity'], input[id*='PropertyHolidayType'], */
        $(this).parents('form').submit();
    });
    $('body').delegate("input[id*='RequestRoomType'],input[id*='RequestPropertyType'],input[id*='RequestAmenity'],input[id*='RequestAmenity'], input[id*='RequestHolidayType']", 'change', function() {
        $(this).parents('form').submit();
    });
    if ($('.js-street-link', '#properties-view').is('.js-street-link')) {
        var script = document.createElement('script');
        var google_map_key = 'http://maps.google.com/maps/api/js?sensor=false&callback=loadStreetMap';
        script.setAttribute('src', google_map_key);
        script.setAttribute('type', 'text/javascript');
        document.documentElement.firstChild.appendChild(script);
    }
    $('.js-list').hide();
    if ($('.js-near-link', '#properties-view').is('.js-near-link')) {
        var lat = $('.js-near-link').metadata().lat;
        var lng = $('.js-near-link').metadata().lng;
        ws_wsid = 'f532af5d9bd04255a477f5c16db220c7';
        ws_lat = lat;
        ws_lon = lng;
        ws_width = '640';
        var ws_height = '540';
        var ws_layout = 'horizontal';
        var ws_industry_type = 'travel';
        ws_map_icon_type = 'building';
        ws_transit_score = 'true';
        ws_commute = 'true';
        ws_map_modules = 'all';
        var html = "<style type='text/css'>#ws-walkscore-tile{position:relative;text-align:left}#ws-walkscore-tile*{float:none;}#ws-footer a,#ws-footer a:link{font:11px/14pxVerdana,Arial,Helvetica,sans-serif;margin-right:6px;white-space:nowrap;padding:0;color:#000;font-weight:bold;text-decoration:none}#ws-footera:hover{color:#777;text-decoration:none}#ws-footera:active{color:#b14900}</style><div id='ws-walkscore-tile'><divid='ws-footer' tyle='position:absolute;top:522px;left:8px;width:688px'><formid='ws-form'><a id='ws-a' href='http://www.walkscore.com/'target='_blank'>What's Your Walk core?</a><input type='text'id='ws-street' style='position:absolute;top:0px;left:170px;width:486px'/><input type='image' id='ws-go'src='http://cdn.walkscore.com/images/tile/go-button.gif' height='15'width='22' border='0' alt='get my Walk Score'style='position:absolute;top:0px;right:0px'/></form></div></div><script type='text/javascript'src='http://www.walkscore.com/tile/show-walkscore-tile.php'></script>";
        $('.js-near-link').html(html);
    }
    if ($('.js-flickr-link', '#properties-view').is('.js-flickr-link')) {
        var url = $('.js-flickr-link').metadata().url;
        $.ajax( {
            type: 'GET',
            url: url + '&format=json&jsoncallback=?',
            dataType: 'json',
            cache: true,
            success: function(data) {
                $('#flicker-images').html('');
                if (data.photos.photo) {
                    $('<ul/>').attr('id', 'list_gallery').appendTo('#flicker-images');
                    $('#list_gallery').addClass('list');
                    if (data.photos.total > 0) {
                        $.each(data.photos.photo, function(i, item) {
                            $('<li/>').attr('id', 'flikr-' + i).appendTo('#list_gallery');
                            src = 'http://farm' + item.farm + '.static.flickr.com/' + item.server + '/' + item.id + '_' + item.secret + '_m.jpg';
                            var href = 'http://www.flickr.com/photos/' + item.owner + '/' + item.id;
                            $('<a/>').attr('id', 'flikr-href-' + i).attr('href', href).attr('target', '_blank').appendTo('#flikr-' + i);
                            var classname = '#flikr-href-' + i;
                            $('<img/>').attr('src', src).attr('height', '100').attr('title', item.title).attr('width', '100').appendTo(classname);

                        });
                    } else {
                        $('<li/>').html('<p class="notice">' + __l('No Flickr Photos Available') + '</p>').appendTo('#list_gallery');
                    }
                }
            }
        });
    }
    $('body').delegate('.js-like', 'click', function() {
        var _this = $(this);
        _this.block();
        var controller = _this.metadata().controller;
        var relative_url = _this.attr('href');
        var class_link = _this.attr('class');
        $.get(relative_url, function(data) {
            if (data != '') {
                var data_array = data.split('|');
                if (data_array[0] == 'added') {
                    _this.text(__l('Unlike'));
                    _this.attr('class', 'js-like un-like');
                    _this.attr('title', __l('Unlike'));
                    _this.attr('href', data_array[1]);
                } else if (data_array[0] = 'removed') {
                    _this.text(__l('Like'));
                    _this.attr('class', 'js-like like');
                    _this.attr('title', __l('Like'));
                    _this.attr('href', data_array[1]);
                }
            }
            $('.js-like').unblock();
        });
        return false;
    });
    $('form#MessageComposeForm').delegate('.js-contact-purpose', 'change', function() {
        var val = $(this).val();
        var negotiable = $(this).metadata().negotiable;
        if (val == 4) {
            $('.js-contactus-container').slideDown();
            $('.js-response').html('');
        } else if (val == 1) {
            $('.js-contactus-container').slideUp();
            $('.js-response').html('<span class="page-information">' + __l('You can check "Availablity" in the description page of the Join selected.') + '</span>');
        } else if (val == 2) {
            $('.js-contactus-container').slideUp();
            $('.js-response').html('<span class="page-information">' + __l('You can check "Facilities" in the description page of the Join selected.') + '</span>');
        } else if (val == 3) {
            $('.js-contactus-container').slideUp();
            if (negotiable == 1) {
                var html = '<span class="page-information">' + __l('You can check "Pricing" details in the description page of the Join selected, also you can do price discussion.') + '</span>';
            } else {
                var html = '<span class="page-information">' + __l('You can check "Pricing" details in the description page of the Join selected, also price is fixed. Negotiation is not possible.') + '</span>';
            }
            $('.js-response').html(html);
        }
    });
    $('.js-radio-style').buttonset();
    $('.radio-tabs-rblock').delegate('.js-radio-style', 'click', function() {
        $('.error-message').remove();
    });
    $.floadgeomapsearch('#PropertyCityName');
    $.floadgeomapsearch('#PropertyAddressSearch');
    $.floadgeomapsearch('#RequestAddressSearch');
    $.floadgeomapsearch('#UserProfileAddress');
    $.floadgeomaplisting('.properties-index-page');
    $.floadgeomaplisting('.request-index-page');
    $.finitializeclustermap('#cluster_map');






// calculo de fechas y precios


function getDateDiff()
{
	var from = $("#PropertyUserCheckin").val();
    var till = $("#PropertyUserCheckout").val();
    if((from != '')&(till != '')){
    	// calculer nombre jours difference
	    var c = from.split("/");
		    debut = new Date(c[2],c[1] - 1,c[0]);
			var d = till.split("/");
	        fin = new Date(d[2],d[1] - 1,d[0]);
	        var rest = (fin - debut)/86400000;
	        alert(rest);
		$("#res").val(rest);
	}
}


$("#PropertyUserCheckin").datepicker(
{
    changeMonth:true,
	changeYear:true,
	showAnim:"fadeIn",
	gotoCurrent:true,
//	showOn: "button",
 //   buttonImage: "../../img/icon-calender.png",
	minDate:0,
	dateFormat: "yy-mm-dd",
    onSelect: function(dateText, inst)
    {
	    var dt=new Date(inst.selectedYear,inst.selectedMonth,inst.selectedDay)
		var end=new Date();
		end.setDate(dt.getDate()+1)
	$( "#PropertyUserCheckout" ).val(end.getMonth()+1 +"/"+(end.getDate())+"/"+end.getFullYear());
	$( "#PropertyUserCheckout" ).datepicker( "option", "minDate", end); //delete this line if you don't want to set the min date 3 days from the date picked
		$("#PropertyUserCheckout").focus();
		event.preventDefault();
		//getDateDiff();
    }
});

$("#PropertyUserCheckout").datepicker(
{
	dateFormat: "yy-mm-dd",
//	minDate:0,   //uncomment this to make the min date today
    changeMonth:true,
	changeYear:true,
	showAnim:"fadeIn",
   // onSelect: getDateDiff
});




/*
$("#PropertyUserCheckin").datepicker({
	minDate:0,
           onSelect: function(dateText, inst) {
		var dt=new Date(dateText)
		var end=new Date();
		end.setDate(dt.getDate()+1)
       $( "#PropertyUserCheckout" ).val(end.getMonth()+1+"/"+end.getDate()+"/"+end.getFullYear());
	getDateDiff();
				}
		});
$("#PropertyUserCheckout").datepicker({
	minDate:new Date($("#PropertyUserCheckin").val())+1,
           onSelect: getDateDiff
});





// calendario anterior

    /*$('#PropertyCheckin, #PropertyCheckout').datepicker( {
        beforeShow: customDateFunction,
        dateFormat: 'yy-mm-dd',
        minDate: 0
    });
*/
    $('form .js-overlabel label').foverlabel();
    // common confirmation delete function
    $('body').delegate('a.js-delete', 'click', function() {
        return window.confirm(__l('Are you sure you want to') + ' ' + this.innerHTML.toLowerCase() + '?');
    });
    // captcha play
    $.captchaPlay('a.js-captcha-play');
    $('body').delegate('form.js-ajax-form', 'submit', function() {
        var $this = $(this);
        $this.block();
        $this.ajaxSubmit( {
            beforeSubmit: function(formData, jqForm, options) {},
            success: function(responseText, statusText) {
                redirect = responseText.split('*');
                if (redirect[0] == 'redirect') {
                    location.href = redirect[1];
                } else if ($this.metadata().container) {
                    $('.' + $this.metadata().container).html(responseText);
					if ($this.metadata().transaction) {
					} else {
	                    myAjaxLoad();
					}
                } else {
                    $this.parents('.js-responses').html(responseText);
					if ($this.metadata().transaction) {
					} else {
	                    myAjaxLoad();
					}
                }
                $this.unblock();
            }
        });
        return false;
    });
	$('body').delegate('form.js-post-craigslist-form', 'submit', function() {
        var $this = $(this);
		$this.block();
		$.ajax({
			url: $this.attr('action'),
			type: 'POST',
			data: $this.serialize(),
			async: false,
			success: function(responseText) {
				$this.unblock();
				if (responseText.indexOf('js-post-craigslist')) {
					$('.js-craigslist-form').html(responseText);
					$('.js-post-craigslist').submit();
                } else {
                    $('.' + $this.metadata().container).html(responseText);
                }
			}
		});
        return false;
    });
    $('body').delegate('form.js-ajax-search-form', 'submit', function() {
        $('.js-responses').block();
        $this.ajaxSubmit( {
            beforeSubmit: function(formData, jqForm, options) {},
            success: function(responseText, statusText) {
                redirect = responseText.split('*');
                if (redirect[0] == 'redirect') {
                    location.href = redirect[1];
                } else if ($this.metadata().container) {
                    $('.' + $this.metadata().container).html(responseText);
                } else {
                    $('.js-responses').html(responseText);
                }
                $('.js-responses').unblock();
                loadSideMap();
                $('form#KeywordsSearchForm').delegate('.js-mapsearch-button', 'click', function() {
                    searchmapaction();
                });
				$('form#KeywordsSearchForm').delegate('.js-submit-button', 'click', function() {
					$(this).parents('form').submit();
					return false;
				});
                // overlabel reload
                $('form .js-overlabel label').foverlabel();
				$('form#KeywordsSearchForm').delegate('.js-toggle-properties-types', 'click', function() {
					$('.' + $(this).metadata().typetoggle).toggle();
					if ($(this).is('.minus')) {
						$(this).addClass('plus');
						$(this).removeClass('minus');
					} else {
						$(this).addClass('minus');
						$(this).removeClass('plus');
					}
					return false;
				 });

                if ($('.properties-index-page', '#properties-index').is('.properties-index-page')) {
                    $('select#js-range_from, select#js-range_to').selectToUISlider( {
                        sliderOptions: {
                            change: function(e, ui) {
                                $('.js-rang-from').html($('#js-range_from').val());
                                $('.js-rang-to').html($('#js-range_to').val());
                                $(this).parents('form').submit();
                            }
                        }
                    });
					if ($('#js-deposit_from', '#properties-index').is('#js-deposit_from')) {
					 $('select#js-deposit_from, select#js-deposit_to').selectToUISlider( {
                        sliderOptions: {
                            change: function(e, ui) {
                                $('.js-deposit-from').html($('#js-deposit_from').val());
                                $('.js-deposit-to').html($('#js-deposit_to').val());
                                $(this).parents('form').submit();
                            }
                        }
                    });
					}
                    $('select#minimumBedRooms').selectToUISlider( {
                        sliderOptions: {
                            change: function(e, ui) {
                                $('.js-min-bedroom-range').html($('#minimumBedRooms').val());
                                $(this).parents('form').submit();
                            }
                        }
                    }).next();
                    $('select#minimumBathRooms').selectToUISlider( {
                        sliderOptions: {
                            change: function(e, ui) {
                                $('.js-min-bath-range').html($('#minimumBathRooms').val());
                                $(this).parents('form').submit();
                            }
                        }
                    }).next();
                    $('select#minimumBeds').selectToUISlider( {
                        sliderOptions: {
                            change: function(e, ui) {
                                $('.js-min-bed-range').html($('#minimumBeds').val());
                                $(this).parents('form').submit();
                            }
                        }
                    }).next();
                }
                if ($('.request-index-page', '#requests-index').is('.request-index-page')) {
                    $('select#js-range_from, select#js-range_to').selectToUISlider( {
                        sliderOptions: {
                            change: function(e, ui) {
                                $('.js-rang-from').html($('#js-range_from').val());
                                $('.js-rang-to').html($('#js-range_to').val());
                                $(this).parents('form').submit();
                            }
                        }
                    });
                }
            }
        });
        return false;
    });
    $('body').delegate('form.js-comment-form', 'submit', function() {
        var $this = $(this);
        $this.block();
        $this.ajaxSubmit( {
            beforeSubmit: function(formData, jqForm, options) {},
            success: function(responseText, statusText) {
                if (responseText.indexOf($this.metadata().container) != '-1') {
                    $('.' + $this.metadata().container).html(responseText);
                } else {
                    $('.js-comment-responses').prepend(responseText);
                    $('.' + $this.metadata().container + ' div.input').removeClass('error');
                    $('.error-message', $('.' + $this.metadata().container)).remove();
                }
                if (typeof($('.js-captcha-container').find('.captcha-img').attr('src')) != 'undefined') {
                    captcha_img_src = $('.js-captcha-container').find('.captcha-img').attr('src');
                    captcha_img_src = captcha_img_src.substring(0, captcha_img_src.lastIndexOf('/'));
                    $('.js-captcha-container').find('.captcha-img').attr('src', captcha_img_src + '/' + Math.random());
                }
                myAjaxLoad();
                $this.unblock();
            },
            clearForm: true
        });
        return false;
    });
    // jquery flash uploader function
    $('.js-uploader').fuploader();

    $.fautocomplete('.js-autocomplete');
    $.fmultiautocomplete('.js-multi-autocomplete');
    $.froundcorner('div.js-corner');
    $.fdatepicker('form div.js-datetime');
    $.ftimepicker('form div.js-time');

    $('#errorMessage,#authMessage,#successMessage,#flashMessage').flashMsg();
    $('body').delegate('#StateName, #CityName, #PropertyPricePerNight, #PropertyCityName, #PropertyAddressSearch, #RequestAddressSearch, #RequestCityName, #PropertyCityNameSearch', 'keyup', function(e) {
		if (e.keyCode != 13 && ($('#CityName').val() == '' && $('#StateName').val() =='' && $('#js-country_id').val() =='')) {
			$('#js-sub').attr('disabled', 'disabled');
			$('#js-sub').removeClass('active-search');
			$("body").find("#PropertyCancellationPolicyId").hide();
		} else if($('#CityName').val() != '' || $('#StateName').val()!='' || $('#js-country_id').val() !=''){
            $('#js-sub').removeAttr('disabled');
            $('#js-sub').addClass('active-search');
            $('.error-message').remove();
            $("body").find("#PropertyCancellationPolicyId").hide();
        }
        return false;
    });
    $('#gallery').galleryView( {
        panel_width: 490,
        panel_height: 350,
        gallery_width: 700,
        gallery_height: 700,
        frame_width: 45,
        frame_height: 45,
        pause_on_hover: true
    });
    $('#galleryView').galleryView( {
        panel_width: 600,
        panel_height: 500,
        gallery_width: 600,
        gallery_height: 500,
        frame_width: 45,
        frame_height: 45,
        pause_on_hover: true,
		panel_scale: 'nocrop',
		show_captions:true,
		show_infobar:true,
		show_panel_nav:true
    });
    if (($('#PropertyCityName', 'body').is('#PropertyCityName')) || ($('#PropertyPricePerNight', 'body').is('#PropertyPricePerNight'))|| ($('#PropertyAddressSearch', 'body').is('#PropertyAddressSearch')) || ($('#PropertyCityNameSearch', 'body').is('#PropertyCityNameSearch')) || ($('#RequestCityName', 'body').is('#RequestCityName')) || ($('#RequestAddressSearch', 'body').is('#RequestAddressSearch'))) {
        $this = '';
        var $country = 0;
        if ($('#PropertyCityName', 'body').is('#PropertyCityName')) {
            $this = $('#PropertyCityName');
        } else if ($('#PropertyAddressSearch', 'body').is('#PropertyAddressSearch')) {
            $this = $('#PropertyAddressSearch');
        } else if ($('#PropertyCityNameSearch', 'body').is('#PropertyCityNameSearch')) {
            $this = $('#PropertyCityNameSearch');
        } else if ($('#RequestCityName', 'body').is('#RequestCityName')) {
            $this = $('#RequestCityName');
        } else if ($('#PropertyPricePerNight', 'body').is('#PropertyPricePerNight')) {
            $this = $('#PropertyPricePerNight');
        } else {
            $this = $('#RequestAddressSearch');
            $country = $('#js-country-search').val();
        }

        if ($this.val().length != 0 && !$country) {
            $('#js-sub').removeAttr('disabled');
            $('#js-sub').addClass('active-search');
        } else {
            $('#js-sub').attr('disabled', 'disabled');
            $('#js-sub').removeClass('active-search');
        }
    }
    $.fcolorbox1('a.js-thickbox');
    $.fcolorbox('a.js-guest_list_calender_opening');
    $.froundcorner('div.js-corner');
    $('div#properties-index').delegate('.js-embed-view', 'click', function() {
        $(this).colorbox( {
            inline: true,
            width: '500px',
            height: '100px',
            opacity: 0.30,
            href: '#embed_frame'
        });
    });
    $('div#currencies-admin_index').delegate('.js-currency-colorbox', 'click', function() {
		var id = '#' + $(this).metadata().id;
        $(this).colorbox( {
            inline: true,
            width: '600px',
            height: '800px',
            opacity: 0.30,
            href: id
        });
    });
    $('form#TransactionIndexForm').delegate('.js-transaction-filter', 'click', function() {
        var val = $(this).val();
        if (val == __l('custom')) {
            $('.js-filter-window').show();
            return true;
        } else {
            $('.js-filter-window').hide();
        }
        $('.js-responses').block();
        $.ajax( {
            type: 'GET',
            url: __cfg('path_relative') + 'transactions/index/stat:' + val,
            dataType: 'html',
            cache: true,
            success: function(responses) {
                $('.js-responses').html(responses);
                $('.js-responses').unblock();
            }
        });
    });
    $('form#KeywordsSearchForm').delegate('.js-submit-button', 'click', function() {
        $(this).parents('form').submit();
        return false;
    });
    $('table.list').delegate('input', 'click', function() {
        var $this = $(this);
        if ($this.attr('checked') == true) {
            $this.parents('tr').addClass('highlight');
        } else {
            $this.parents('tr').removeClass('highlight');
        }
    });
    $('form#MessageMoveToForm').delegate('.js-select-all', 'click', function() {
        $('.js-checkbox-list').attr('checked', 'checked');
        return false;
    });
    $('form#MessageMoveToForm').delegate('.js-select-none', 'click', function() {
        $('.js-checkbox-list').attr('checked', false);
        return false;
    });
    $('form#MessageMoveToForm').delegate('.js-select-read', 'click', function() {
        $('.checkbox-message').attr('checked', false);
        $('.checkbox-read').attr('checked', 'checked');
        return false;
    });
    $('form#MessageMoveToForm').delegate('.js-select-unread', 'click', function() {
        $('.checkbox-message').attr('checked', false);
        $('.checkbox-unread').attr('checked', 'checked');
        return false;
    });
    $('form#MessageMoveToForm').delegate('.js-select-starred', 'click', function() {
        $('.checkbox-message').attr('checked', false);
        $('.checkbox-starred').attr('checked', 'checked');
        return false;
    });
    $('form#MessageMoveToForm').delegate('.js-select-unstarred', 'click', function() {
        $('.checkbox-message').attr('checked', false);
        $('.checkbox-unstarred').attr('checked', 'checked');
        return false;
    });
    $('div.admin-select-block').delegate('a.js-admin-select-all', 'click', function() {
        $('.js-checkbox-list').attr('checked', 'checked');
        $('.js-checkbox-list').parents('tr').addClass('highlight');
        return false;
    });
    $('div.admin-select-block').delegate('a.js-admin-select-none', 'click', function() {
        $('.js-checkbox-list').attr('checked', false);
        $('.js-checkbox-list').parents('tr').removeClass('highlight');
        return false;
    });
    $('div.admin-select-block').delegate('.js-admin-select-pending', 'click', function() {
        $('.js-checkbox-active').attr('checked', false);
        $('.js-checkbox-active').parents('tr').removeClass('highlight');
        $('.js-checkbox-inactive').parents('tr').addClass('highlight');
        $('.js-checkbox-inactive').attr('checked', 'checked');
        return false;
    });
    $('div.admin-select-block').delegate('.js-admin-select-approved', 'click', function() {
        $('.js-checkbox-active').attr('checked', 'checked');
        $('.js-checkbox-inactive').attr('checked', false);
        $('.js-checkbox-active').parents('tr').addClass('highlight');
        $('.js-checkbox-inactive').parents('tr').removeClass('highlight');
        return false;
    });
    $('div.admin-select-block').delegate('.js-admin-select-propertyapproved', 'click', function() {
        $('.js-checkbox-approved').attr('checked', 'checked');
        $('.js-checkbox-disapproved').attr('checked', false);
        $('.js-checkbox-approved').parents('tr').addClass('highlight');
        $('.js-checkbox-disapproved').parents('tr').removeClass('highlight');
        return false;
    });
    $('div.admin-select-block').delegate('.js-admin-select-propertydisapproved', 'click', function() {
        $('.js-checkbox-disapproved').attr('checked', 'checked');
        $('.js-checkbox-approved').attr('checked', false);
        $('.js-checkbox-disapproved').parents('tr').addClass('highlight');
        $('.js-checkbox-approved').parents('tr').removeClass('highlight');
        return false;
    });
    $('div#properties-admin_index').delegate('.js-admin-select-featured', 'click', function() {
        $('.js-checkbox-featured').attr('checked', 'checked');
        $('.js-checkbox-notfeatured').attr('checked', false);
        $('.js-checkbox-featured').parents('tr').addClass('highlight');
        $('.js-checkbox-notfeatured').parents('tr').removeClass('highlight');
        return false;
    });
    $('div#properties-admin_index').delegate('.js-admin-select-homepage', 'click', function() {
        $('.js-checkbox-homepage').attr('checked', 'checked');
        $('.js-checkbox-nothomepage').attr('checked', false);
        $('.js-checkbox-homepage').parents('tr').addClass('highlight');
        $('.js-checkbox-nothomepage').parents('tr').removeClass('highlight');
        return false;
    });
    $('div#properties-admin_index').delegate('.js-admin-select-verified', 'click', function() {
        $('.js-checkbox-verified').attr('checked', 'checked');
        $('.js-checkbox-notverified').attr('checked', false);
        $('.js-checkbox-verified').parents('tr').addClass('highlight');
        $('.js-checkbox-notverified').parents('tr').removeClass('highlight');
        return false;
    });
    $('div.admin-select-block').delegate('.js-admin-select-suspended', 'click', function() {
        $('.js-checkbox-suspended').attr('checked', 'checked');
        $('.js-checkbox-unsuspended').attr('checked', false);
        $('.js-checkbox-suspended').parents('tr').addClass('highlight');
        $('.js-checkbox-unsuspended').parents('tr').removeClass('highlight');
        return false;
    });
    $('div.admin-select-block').delegate('.js-admin-select-unflagged', 'click', function() {
        $('.js-checkbox-flagged').attr('checked', false);
        $('.js-checkbox-unflagged').attr('checked', 'checked');
        $('.js-checkbox-flagged').parents('tr').removeClass('highlight');
        $('.js-checkbox-unflagged').parents('tr').addClass('highlight');
        return false;
    });
    $('div.admin-select-block').delegate('.js-admin-select-flagged', 'click', function() {
        $('.js-checkbox-flagged').attr('checked', 'checked');
        $('.js-checkbox-unflagged').attr('checked', false);
        $('.js-checkbox-flagged').parents('tr').addClass('highlight');
        $('.js-checkbox-unflagged').parents('tr').removeClass('highlight');
        return false;
    });
    $('div.mail-body').delegate('.js-show-mail-detail-span', 'click', function() {
        if ($('.js-show-mail-detail-span').text() == 'show details') {
            $('.js-show-mail-detail-span').text('hide details');
            $('.js-show-mail-detail-div').show();
        } else {
            $('.js-show-mail-detail-span').text('show details');
            $('.js-show-mail-detail-div').hide();
        }
    });
    $('form#PaymentOrderForm').delegate('a.js-cancel', 'click', function(event) {
        return window.confirm(__l('Are you sure you want to cancel this booking?'));
    });
    $('div#js-confirm-message-block').delegate('a.js-confirm-mess', 'click', function(event) {
        return window.confirm(__l('Are you sure confirm this action?'));
    });
    $('form#PropertyUserIndexForm').delegate('input.js-input-price', 'focus', function(event) {
        $('.js-update-button').removeClass('inactive-search');
    });
    $('table.revenues-list').delegate('a.js-confirm', 'click', function(event) {
        return window.confirm(__l('Are you sure you want to confirm this booking?'));
    });
    $('table.revenues-list').delegate('a.js-reject', 'click', function(event) {
        return window.confirm(__l('Are you sure you want to reject this booking?'));
    });
    if ($('.js-tweet-link', '#properties-view').is('.js-tweet-link')) {
        var lat = $('.js-tweet-link').metadata().lat;
        var lng = $('.js-tweet-link').metadata().lng;
        $('.js-tweet-link').jTweetsAnywhere( {
            searchParams: ['geocode=' + lat + ',' + lng + ',30km'],
            count: 10
        });
    }
    $('div.captcha-right').delegate('.js-captcha-reload', 'click', function() {
        captcha_img_src = $(this).parents('.js-captcha-container').find('.captcha-img').attr('src');
        captcha_img_src = captcha_img_src.substring(0, captcha_img_src.lastIndexOf('/'));
        $(this).parents('.js-captcha-container').find('.captcha-img').attr('src', captcha_img_src + '/' + Math.random());
        return false;
    });
    $('body').delegate('.js-admin-index-autosubmit', 'change', function() {
        if ($('.js-checkbox-list:checked').val() != 1) {
            alert(__l('Please select atleast one record!'));
            return false;
        } else {
            if ($(this).val() == 44)
            // add in collection
             {
                if (window.confirm(__l('Are you sure you want to do this action?'))) {
                    $(this).parents('form').attr('action', __cfg('path_absolute') + 'admin/properties/manage_collections');
                    $(this).parents('form').submit();
                }
            } else {
                if ((window.confirm(__l('Are you sure you want to do this action?')))) {
                    $(this).parents('form').submit();
                }
            }
        }
    });

    $('body').delegate('.js-autosubmit', 'change', function() {
        $(this).parents('form').submit();
    });

    if (($('.js-property-description', '#PropertyEditForm').is('.js-property-description')) || ($('.js-property-description', '#PropertyAddForm').is('.js-property-description'))) {
        $('.js-property-description').simplyCountable( {
            counter: '#js-property-description-count',
            countable: 'characters',
            maxCount: $('.js-property-description').metadata().count,
            strictMax: true,
            countDirection: 'down',
            safeClass: 'safe',
            overClass: 'over'
        });
    }
    if (($('.js-property-title', '#PropertyEditForm').is('.js-property-title')) || ($('.js-property-title', '#PropertyAddForm').is('.js-property-title'))) {
        $('.js-property-title').simplyCountable( {
            counter: '#js-property-title-count',
            countable: 'characters',
            maxCount: $('.js-property-title').metadata().count,
            strictMax: true,
            countDirection: 'down',
            safeClass: 'safe',
            overClass: 'over'
        });
    }
    $('div#main').delegate('.js-pagination a', 'click', function() {
        $this = $(this);
        $this.parents('div.js-response').block();
        $.get($this.attr('href'), function(data) {
            $this.parents('div.js-response').html(data);
            if ($('.properties-index-page', '#properties-index').is('.properties-index-page')) {
                //recall the side map
                loadSideMap();
                $('form#KeywordsSearchForm').delegate('.js-mapsearch-button', 'click', function() {
                    searchmapaction();
                });
                $('select#js-range_from, select#js-range_to').selectToUISlider( {
                    sliderOptions: {
                        change: function(e, ui) {
                            $('.js-rang-from').html($('#js-range_from').val());
                            $('.js-rang-to').html($('#js-range_to').val());
                            $(this).parents('form').submit();
                        }
                    }
                });
                if ($('#js-deposit_from', '#properties-index').is('#js-deposit_from')) {
                    $('select#js-deposit_from, select#js-deposit_to').selectToUISlider( {
                        sliderOptions: {
                            change: function(e, ui) {
                                $('.js-deposit-from').html($('#js-deposit_from').val());
                                $('.js-deposit-to').html($('#js-deposit_to').val());
                                $(this).parents('form').submit();
                            }
                        }
                    });
				}
                $('select#minimumBedRooms').selectToUISlider( {
                    sliderOptions: {
                        change: function(e, ui) {
                            $('.js-min-bedroom-range').html($('#minimumBedRooms').val());
                            $(this).parents('form').submit();
                        }
                    }
                }).next();
                $('select#minimumBathRooms').selectToUISlider( {
                    sliderOptions: {
                        change: function(e, ui) {
                            $('.js-min-bath-range').html($('#minimumBathRooms').val());
                            $(this).parents('form').submit();
                        }
                    }
                }).next();
                $('select#minimumBeds').selectToUISlider( {
                    sliderOptions: {
                        change: function(e, ui) {
                            $('.js-min-bed-range').html($('#minimumBeds').val());
                            $(this).parents('form').submit();
                        }
                    }
                }).next();
            }
            if ($('.request-index-page', '#requests-index').is('.request-index-page')) {
                //recall the side map
                loadSideMap();
                $('select#js-range_from, select#js-range_to').selectToUISlider( {
                    sliderOptions: {
                        change: function(e, ui) {
                            $('.js-rang-from').html($('#js-range_from').val());
                            $('.js-rang-to').html($('#js-range_to').val());
                            $(this).parents('form').submit();
                        }
                    }
                });
            }
            selectLink();
            $this.parents('div.js-response').unblock();
            return false;
        });
        return false;
    });
    $('div.js-toggle-show-block').delegate('.js-toggle-show', 'click', function() {
        $('.' + $(this).metadata().container).slideToggle('slow');
        if ($('.' + $(this).metadata().hide_container)) {
            $('.' + $(this).metadata().hide_container).hide('slow');
        }
        return false;
    });
	$('div.js-share-results').delegate('.js-share-close', 'click', function() {
		$(this).parent().slideToggle('slow');
        return false;
    });
	$('div.js-share-results').delegate('.js-selectall', 'click', function() {
		$(this).trigger('select');
    });
    $('div#payments-order').delegate('.js-login-form', 'click', function() {
        $('.js-login-form-container').slideToggle('slow');
        $('.js-login-form-container').parent().parent().find('#fondoNegro').toggleClass('hide');
        return false;
    });
    $('form#KeywordsSearchForm').delegate('.js-mapsearch-button', 'click', function() {
        searchmapaction();
    })
        $('form#KeywordsSearchForm').delegate('.js-toggle-properties-types', 'click', function() {
        $('.' + $(this).metadata().typetoggle).toggle();
        if ($(this).is('.minus')) {
            $(this).addClass('plus');
            $(this).removeClass('minus');
        } else {
            $(this).addClass('minus');
            $(this).removeClass('plus');
        }
        return false;
    });
    /// Get the Geo City, State And Country
    if ($.cookie('ice') == null) {
        $.cookie('ice', 'true', {
            expires: 100,
            path: '/'
        });
    }
    if ($.cookie('ice') == 'true' && $.cookie('_geo') == null) {
        $.ajax( {
            type: 'GET',
            url: 'http://j.maxmind.com/app/geoip.js',
            dataType: 'script',
            cache: true,
            success: function() {
                str = geoip_country_code() + '|' + geoip_region_name() + '|' + geoip_city() + '|' + geoip_latitude() + '|' + geoip_longitude();
                $.cookie('_geo', str, {
                    expires: 100,
                    path: '/'
                });
                if (window.location.href.indexOf('users/register') != -1) {
                    $('#CityName').val(geoip_city());
                    $('#StateName').val(geoip_region_name());
                    $('#UserProfileCountryIsoCode').val(geoip_country_code());
                }
            }
        });
    }
    // js code to do automatic validation on input fields blur
    $('div.input').each(function() {
        var m = /validation:{([\*]*|.*|[\/]*)}$/.exec($(this).attr('class'));
        if (m && m[1]) {
            $(this).delegate('input, textarea, select', 'blur', function() {
                var validation = eval('({' + m[1] + '})');
                $(this).parent().removeClass('error');
                $(this).siblings('div.error-message').remove();
                error_message = 0;
                for (var i in validation) {

                    if (((typeof(validation[i]['rule']) != 'undefined' && validation[i]['rule'] == 'notempty' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'notempty' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && !$(this).val()) {
                        error_message = 1;
                        break;
                    }

                    if (((typeof(validation[i]['rule']) != 'undefined' && validation[i]['rule'] == 'alphaNumeric' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'alphaNumeric' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && !(/^[0-9A-Za-z]+$/.test($(this).val()))) {
                        error_message = 1;
                        break;
                    }

                    if (((typeof(validation[i]['rule']) != 'undefined' && validation[i]['rule'] == 'numeric' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'numeric' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && !(/^[+-]?[0-9|.]+$/.test($(this).val()))) {
                        error_message = 1;
                        break;
                    }
                    if (((typeof(validation[i]['rule']) != 'undefined' && validation[i]['rule'] == 'email' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'email' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && !(/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9][-a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,4}|museum|travel)$/.test($(this).val()))) {
                        error_message = 1;
                        break;
                    }
                    if (((typeof(validation[i]['rule']) != 'undefined' && typeof(validation[i]['rule'][0]) != 'undefined' && validation[i]['rule'][0] == 'equalTo') || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'equalTo' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && $(this).val() != validation[i]['rule'][1]) {
                        error_message = 1;
                        break;
                    }
                    if (((typeof(validation[i]['rule']) != 'undefined' && typeof(validation[i]['rule'][0]) != 'undefined' && validation[i]['rule'][0] == 'between' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'between' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && ($(this).val().length < validation[i]['rule'][1] || $(this).val().length > validation[i]['rule'][2])) {
                        error_message = 1;
                        break;
                    }
                    if (((typeof(validation[i]['rule']) != 'undefined' && typeof(validation[i]['rule'][0]) != 'undefined' && validation[i]['rule'][0] == 'minLength' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'minLength' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && $(this).val().length < validation[i]['rule'][1]) {
                        error_message = 1;
                        break;
                    }

                }
                if (error_message) {
                    $(this).parent().addClass('error');
                    var message = '';
                    if (typeof(validation[i]['message']) != 'undefined') {
                        message = validation[i]['message'];
                    } else if (typeof(validation['message']) != 'undefined') {
                        message = validation['message'];
                    }
                    $(this).parent().append('<div class="error-message">' + message + '</div>').fadeIn();
                }
            });
        }
    });
    $('body').delegate('form', 'submit', function() {
        $(this).find('div.input input[type=text], div.input textarea, div.input select').filter(':visible').trigger('blur');
        $('input, textarea, select', $('.error', $(this)).filter(':first')).trigger('focus');
        return ! ($('.error-message', $(this)).length);
    });

    $('body').delegate('#PropertyDescription', 'change', function() {
        //$('#PropertyCancellationPolicyId').hide();
        $("#PropertyCancellationPolicyId option:eq(1)").attr("selected", "selected");
    });

    $(window).load(function(){
    	//$('#js-geo-fail-address-fill-block').hide();
        $("#PropertyCancellationPolicyId option:eq(1)").attr("selected", "selected");
        $('#PropertyCancellationPolicyId').parent().hide();
    });

    if ($('.js-view-count-update', 'body').is('.js-view-count-update')) {
        model_arr = Array();
        var i = 0;
        $('.js-view-count-update', 'body').each(function(e) {
            var ids = '';
            $this = $(this);
            model = $this.metadata().model;
            if ($.inArray(model, model_arr) == -1) {
                model_arr[i] = model;
                $('.js-view-count-' + model + '-id').each(function(e) {
                    ids += $(this).metadata().id + ',';
                });
                var param = [ {
                    name: 'ids',
                    value: ids
                }];
                if (ids) {
                    $.ajax( {
                        type: 'POST',
                        url: $this.metadata().url,
                        dataType: 'json',
                        data: param,
                        cache: false,
                        success: function(responses) {
                            for (i in responses) {
                                $('.js-view-count-' + model + '-id-' + i).html(responses[i]);
                            }
                        }
                    });
                }
                i ++ ;
            }
        });
    }
    if ($('.js-header', '#properties-search').is('.js-header')) {
        $.get(__cfg('path_relative') + 'users/show_header', function(data) {
            $('.js-header').html(data);
            $('.js-header').show();
			$('#errorMessage,#authMessage,#successMessage,#flashMessage').flashMsg();
        });
    }
    if (__cfg('is_logged') == 1 && __cfg('is_enable_timeout') != 0) {
        $(document).idleTimeout( {
            inactivity: __cfg('inactivity'),
            noconfirm: __cfg('noconfirm'),
            sessionAlive: __cfg('sessionalive'),
            redirect_url: __cfg('path_absolute') + 'users/logout/',
            click_reset: true,
            alive_url: '/',
            logout_url: __cfg('path_absolute') + 'users/logout/'
        });
    }
	if (__cfg('is_enable_html5_history_api')) {
		$('a:not([class=js-no-pjax]):not([href^=http])').pjax('body');
		$('body').bind('start.pjax', function() {
			$('#main').block();
		}).bind('success.pjax', function(e, data, textStatus, jqXHR) {
			$('div.content').slideUp('fast', function() {
				$('div.content').slideDown('fast');
				document.title = $('.js-meta', data).metadata().title;
				$('meta[name=keywords]').attr('content', $('.js-meta', data).metadata().keywords);
				$('meta[name=description]').attr('content', $('.js-meta', data).metadata().description);
			});
			$('#main').unblock();
			myAjaxLoad();
		});
	}
});
function refreshMap() {
    if (markerClusterer) {
		markerClusterer.clearMarkers();
	}
	$.getJSON(__cfg('json_data_url'), function(data) {
		if (data) {
            for (var i = 0; i < data['Properties']['Count']; i ++ ) {
				updateClusterMarker(data['Properties'][i]['Property'].latitude, data['Properties'][i]['Property'].longitude, data['Properties'][i]['Property'].id, i, 'Property');
			}
			for (var i = 0; i < data['Requests']['Count']; i ++ ) {
				updateClusterMarker(data['Requests'][i]['Request'].latitude, data['Requests'][i]['Request'].longitude, data['Requests'][i]['Request'].id, i, 'Request');
			}
            var zoom = null;
            var size = null;
            var style = null;
            markerClusterer = new MarkerClusterer(map, markers, {
				maxZoom: zoom,
				gridSize: size,
				styles: styles[style]
			});
        }
    });
}
function updateClusterMarker(lat, lang, id, count, type) {
    if (type == 'Property') {
        var imageUrl = __cfg('path_relative') + 'img/P.png';
    } else {
        var imageUrl = __cfg('path_relative') + 'img/R.png';
    }
    var markerImage = new google.maps.MarkerImage(imageUrl, new google.maps.Size(32, 32));
    var latLng = new google.maps.LatLng(lat, lang);
    eval('var marker' + count + ' = new google.maps.Marker({position: latLng,draggable: false,icon: markerImage});');
    eval('marker' + count + '.count=1');
    markers.push(eval('marker' + count));
    if (type == 'Property') {
        var embed_url = __cfg('path_relative') + 'properties/get_info/' + id;
    } else {
        var embed_url = __cfg('path_relative') + 'requests/get_info/' + id;
    }
    var contentString = '<iframe src="' + embed_url + '" width="279" height="120" frameborder = "0" scrolling="no">Loading...</iframe>';

    eval('var infowindow' + count + ' = new google.maps.InfoWindow({ content: contentString,  maxWidth: 300});');
    var infowindow_obj = eval('infowindow' + count);
    var marker_obj = eval('marker' + count);


    google.maps.event.addListener(marker_obj, 'click', function() {
        infowindow_obj.open(map, marker_obj);
    });
}

function initialize() {
    map = new google.maps.Map(document.getElementById('cluster_map'), {
        zoom: 1,
        center: new google.maps.LatLng(13.314082, 77.695313),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    refreshMap();
}

function loadSideMap() {
    //generate the side map
    lat = $('.js-search-lat').metadata().cur_lat;
    lng = $('.js-search-lat').metadata().cur_lng;
    if ((lat == 0 && lng == 0) || (lat == '' && lng == '')) {
        if ($('.js-map-data', 'body').is('.js-map-data')) {
            lat = $('.js-map-data').metadata().lat;
            lng = $('.js-map-data').metadata().lng;
        } else {
            lat = 13.314082;
            lng = 77.695313;
        }

    }
    var zoom = 9;
    latlng = new google.maps.LatLng(lat, lng);
    var myOptions = {
        zoom: zoom,
        center: latlng,
        zoomControl: true,
        draggable: true,
        disableDefaultUI: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById('js-map-container'), myOptions);
    map.setCenter(latlng);
    if (lat != 0 && lng != 0) {
        var imageUrl = __cfg('path_absolute') + 'img/center_point.png';
        var markerImage = new google.maps.MarkerImage(imageUrl);
        var j = 0;
        eval('var marker' + j + ' = new google.maps.Marker({ position: latlng,  map: map, icon: markerImage, zIndex: i});');
        var marker_obj = eval('marker' + j);
    }
    var i = 1;
    $('a.js-map-data', document.body).each(function() {
        lat = $(this).metadata().lat;
        lng = $(this).metadata().lng;
        url = $(this).attr('href');
        title = $(this).attr('title');
        updateMarker(lat, lng, url, i, title);
        i ++ ;
    });
}
function loadSideMap1() {
    lat = $('#' + common_options.lat_id).val();
    lng = $('#' + common_options.lng_id).val();
    if (!((lat == 0 && lng == 0) || (lat == '' && lng == ''))) {
     $('.js-side-map-div').show();
      var zoom = common_options.map_zoom;
    latlng = new google.maps.LatLng(lat, lng);
    var myOptions1 = {
        zoom: zoom,
        center: latlng,
        zoomControl: true,
        draggable: true,
        disableDefaultUI: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map1 = new google.maps.Map(document.getElementById('js-map-container'), myOptions1);
	marker1 = new google.maps.Marker( {
			draggable: true,
			map: map1,
			position: latlng
	});
    map1.setCenter(latlng);
	google.maps.event.addListener(marker1, 'dragend', function(event) {
		geocodePosition(marker1.getPosition());
	});
	google.maps.event.addListener(map1, 'mouseout', function(event) {
		$('#zoomlevel').val(map1.getZoom());
	});
	}else{
     $('.js-side-map-div').hide();
    }
}
function searchmapaction() {
    if (map.getZoom() > 13) {
        map.setZoom(13);
    }
    bounds = (map.getBounds());
    var southWestLan = '';
    var northEastLng = '';
    var southWest = bounds.getSouthWest();
    var northEast = bounds.getNorthEast();
    var center = bounds.getCenter();
    $('#PropertyLatitude').val(center.lat());
    $('#PropertyLongitude').val(center.lng());
    $('#RequestLatitude').val(center.lat());
    $('#RequestLongitude').val(center.lng());
    $('.js-search-lat').metadata().cur_lat = center.lat();
    $('.js-search-lat').metadata().cur_lng = center.lng();
    $('#ne_latitude_index').val(northEast.lat());
    $('#sw_latitude_index').val(southWest.lat());
    if (isNaN(northEast.lng())) {
        northEastLng = '0';
    } else {
        northEastLng = northEast.lng();
    }
    $('#ne_longitude_index').val(northEastLng);

    if (isNaN(southWest.lng())) {
        southWestLan = '0';
    } else {
        southWestLan = southWest.lng();
    }
    $('#sw_longitude_index').val(southWestLan);
    //updateMap
    updateMap();
}
function updateMap() {
    $('#KeywordsSearchForm').submit();
}
function updateMarker(lat, lnt, url, i, title) {
    var store_count = i;
    if (lat != null) {
        myLatLng = new google.maps.LatLng(lat, lnt);
        var imageUrl = __cfg('path_absolute') + 'img/red/' + store_count + '.png';
        var markerImage = new google.maps.MarkerImage(imageUrl);
        eval('var marker' + i + ' = new google.maps.Marker({ position: myLatLng,  map: map, icon: markerImage, zIndex: i});');
        var marker_obj = eval('marker' + i);
        marker_obj.title = title;
        var li_obj = '.js-map-num' + i;
        //one time map listener to handle the zoom
        google.maps.event.addListenerOnce(map, 'resize', function() {
            map.setCenter(center);
            map.setZoom(zoom);
        });
        //properties marker hover, point the properties list active
        $(li_obj).bind('mouseenter', function() {
            var imagehover = __cfg('path_absolute') + 'img/black/' + store_count + '.png';
            marker_obj.setIcon(imagehover);
        });
        $(li_obj).bind('mouseleave', function() {
            var imageUrlhout = __cfg('path_absolute') + 'img/red/' + store_count + '.png';
            marker_obj.setIcon(imageUrlhout);
        });
        //properties list mouse over/leave changing the hover marker icon
        google.maps.event.addListener(marker_obj, 'mouseenter', function() {
            li_obj.addClass('active');
        });
        google.maps.event.addListener(marker_obj, 'mouseleave', function() {
            li_obj.removeClass('active');
        });
        var li_obj_request = '.js-map-request-num' + i;
        //requests
        $(li_obj_request).bind('mouseenter', function() {
            var imagehover = __cfg('path_absolute') + 'img/black/' + store_count + '.png';
            marker_obj.setIcon(imagehover);
        });
        $(li_obj_request).bind('mouseleave', function() {
            var imageUrlhout = __cfg('path_absolute') + 'img/red/' + store_count + '.png';
            marker_obj.setIcon(imageUrlhout);
        });
        google.maps.event.addListener(marker_obj, 'click', function() {
            window.location.href = url;
        });
    }
}
function loadStreetMap() {
    var lat = $('.js-street-view').metadata().lat;
    var lang = $('.js-street-view').metadata().lng;
    var fenway = new google.maps.LatLng(lat, lang);
    var panoramaOptions = {
        position: fenway,
        pov: {
            heading: 34,
            pitch: 10,
            zoom: 1
        }
    };
    var panorama = new google.maps.StreetViewPanorama(document.getElementById('js-street-view'), panoramaOptions);
}
function checkStreetViewStatus() {
    var lat = $('#latitude').val();
    var lang = $('#longitude').val();
    //var fenway = new google.maps.LatLng(42.345573,-71.098326);
    var fenway = new google.maps.LatLng(lat, lang);
    // Define how far to search for an initial pano from a location, in meters.
    var panoSearchRadius = 50;
    // Create a StreetViewService object.
    var client = new google.maps.StreetViewService();
    // Compute the nearest panorama to the Google Sydney office
    // using the service and store that pano ID. Once that value
    // is determined, load the application.
    client.getPanoramaByLocation(fenway, panoSearchRadius, function(result, status) {
        if (status == google.maps.StreetViewStatus.OK) {
            $('.js-street-container').removeClass('hide');
        } else {
            $('.js-street-container').addClass('hide');
        }
    });
}
function loadGeoSearch() {
    loadSideMap();
    var options = {
        map_frame_id: 'mapframe',
        map_window_id: 'mapwindow',
        lat_id: 'latitude',
        lng_id: 'longitude',
        ne_lat: 'ne_latitude',
        ne_lng: 'ne_longitude',
        sw_lat: 'sw_latitude',
        sw_lng: 'sw_longitude',
        lat: '37.7749295',
        lng: '-122.4194155',
        map_zoom: 13
    }
    $('#PropertyCityNameSearch, #RequestCityName').autogeocomplete(options);
}
function loadGeo() {
   	var options = common_options;
    $('#PropertyCityName,#RequestAddressSearch, #PropertyAddressSearch, #RequestCityName,#UserProfileAddress').autogeocomplete(options);
    //checking the streetview available for geo
    $.fstreetcontaineropen('#PropertyIsStreetView');
    $.fuserprofileeditform('form#UserProfileEditForm #js-country_id');
    $.frequestaddform('form#RequestAddForm #js-country_id');
    $.fpropertyaddform('form#PropertyAddForm #js-country_id');
    loadSideMap1();
}

function loadGeoAddress(selector) {
    geocoder = new google.maps.Geocoder();
    var address = $(selector).val();
    geocoder.geocode( {
        'address': address
    }, function(results, status) {
        $.map(results, function(results) {
            var components = results.address_components;
            if (components.length) {
                for (var j = 0; j < components.length; j ++ ) {
                    if (components[j].types[0] == 'locality' || components[j].types[0] == 'administrative_area_level_2') {
                        city = components[j].long_name;
                        $('#CityName').val(city);
                    }
                    if (components[j].types[0] == 'administrative_area_level_1') {
                        state = components[j].long_name;
                        $('#StateName').val(state);
                    }
                    if (components[j].types[0] == 'country') {
                        country = components[j].short_name;
                        $('#js-country_id').val(country);

                    }
                    if (components[j].types[0] == 'postal_code') {
                        postal_code = components[j].long_name;
                        if (selector == '#PropertyAddressSearch') {
                            $('#PropertyPostalCode').val(postal_code);
                        } else {
                            $('#RequestPostalCode').val(postal_code);
                        }
                    }
                }
            }
        });
    });
}
/*
function geocodePosition(position) {
    geocoder.geocode( {
        latLng: position
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            $('#latitude').val(marker.getPosition().lat());
            $('#longitude').val(marker.getPosition().lng());
        }
    });
}
*/
function geocodePosition(position) {
	geocoder1 = new google.maps.Geocoder();
    geocoder1.geocode( {
        latLng: position
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            $('#latitude').val(marker1.getPosition().lat());
            $('#longitude').val(marker1.getPosition().lng());
            map1.setCenter(results[0].geometry.location);
        }
    });
}

function customDateFunction(input) {
    if (input.id == 'PropertyCheckin') {
        if ($('#PropertyCheckout').val() != 'yyyy-mm-dd') {
            if ($('#PropertyCheckout').datepicker('getDate') != null) {
                dateMin = $('#PropertyCheckout').datepicker('getDate', '-1d');
                dateMin.setDate(dateMin.getDate() - 1);
                return {
                    maxDate: dateMin,
                    inline: true
                };
            }
        }
    } else if (input.id == 'PropertyCheckout') {
        if ($('#PropertyCheckin').datepicker('getDate') != null) {
            dateMin = $('#PropertyCheckin').datepicker('getDate', '+1d');
        }
        dateMin.setDate(dateMin.getDate() + 1);
        return {
            minDate: dateMin,
            inline: true
        };
    }
}
function buildChart() {
    if ($('.js-load-line-graph', 'body').is('.js-load-line-graph')) {
        $('.js-load-line-graph').each(function() {
            data_container = $(this).metadata().data_container;
            chart_container = $(this).metadata().chart_container;
            chart_title = $(this).metadata().chart_title;
            chart_y_title = $(this).metadata().chart_y_title;
            var table = document.getElementById(data_container);
            options = {
                chart: {
                    renderTo: chart_container,
                    defaultSeriesType: 'line'
                },
                title: {
                    text: chart_title
                },
                xAxis: {
                    labels: {
                        rotation: -90
                    }
                },
                yAxis: {
                    title: {
                        text: chart_y_title
                    }
                },
                tooltip: {
                    formatter: function() {
                        return '<b>' + this.series.name + '</b><br/>' + this.y + ' ' + this.x;
                    }
                }
            };
            // the categories
            options.xAxis.categories = [];
            jQuery('tbody th', table).each(function(i) {
                options.xAxis.categories.push(this.innerHTML);
            });

            // the data series
            options.series = [];
            jQuery('tr', table).each(function(i) {
                var tr = this;
                jQuery('th, td', tr).each(function(j) {
                    if (j > 0) {
                        // skip first column
                        if (i == 0) {
                            // get the name and init the series
                            options.series[j - 1] = {
                                name: this.innerHTML,
                                data: []
                                };
                        } else {
                            // add values
                            options.series[j - 1].data.push(parseFloat(this.innerHTML));
                        }
                    }
                });
            });
            var chart = new Highcharts.Chart(options);
        });
    }
    if ($('.js-load-pie-chart', 'body').is('.js-load-pie-chart')) {
        $('.js-load-pie-chart').each(function() {
            data_container = $(this).metadata().data_container;
            chart_container = $(this).metadata().chart_container;
            chart_title = $(this).metadata().chart_title;
            chart_y_title = $(this).metadata().chart_y_title;
            var table = document.getElementById(data_container);
            options = {
                chart: {
                    renderTo: chart_container,
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                title: {
                    text: chart_title
                },
                tooltip: {
                    formatter: function() {
                        return '<b>' + this.point.name + '</b>: ' + (this.percentage).toFixed(2) + ' %';
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                series: [ {
                    type: 'pie',
                    name: chart_y_title,
                    data: []
                    }]
                };
            options.series[0].data = [];
            jQuery('tr', table).each(function(i) {
                var tr = this;
                jQuery('th, td', tr).each(function(j) {
                    if (j == 0) {
                        options.series[0].data[i] = [];
                        options.series[0].data[i][j] = this.innerHTML
                    } else {
                        // add values
                        options.series[0].data[i][j] = parseFloat(this.innerHTML);
                    }
                });
            });
            var chart = new Highcharts.Chart(options);
        });
    }
    if ($('.js-load-column-chart', 'body').is('.js-load-column-chart')) {
        $('.js-load-column-chart').each(function() {
            data_container = $(this).metadata().data_container;
            chart_container = $(this).metadata().chart_container;
            chart_title = $(this).metadata().chart_title;
            chart_y_title = $(this).metadata().chart_y_title;
            var table = document.getElementById(data_container);
            seriesType = 'column';
            if ($(this).metadata().series_type) {
                seriesType = $(this).metadata().series_type;
            }
            options = {
                chart: {
                    renderTo: chart_container,
                    defaultSeriesType: seriesType,
                    margin: [50, 50, 100, 80]
                    },
                title: {
                    text: chart_title
                },
                xAxis: {
                    categories: [],
                    labels: {
                        rotation: -90,
                        align: 'right',
                        style: {
                            font: 'normal 13px Verdana, sans-serif'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: chart_y_title
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    formatter: function() {
                        return '<b>' + this.x + '</b><br/>' + Highcharts.numberFormat(this.y, 1);
                    }
                },
                series: [ {
                    name: 'Data',
                    data: [],
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#FFFFFF',
                        align: 'right',
                        x: -3,
                        y: 10,
                        formatter: function() {
                            return '';
                        },
                        style: {
                            font: 'normal 13px Verdana, sans-serif'
                        }
                    }
                }]
                };
            // the categories
            options.xAxis.categories = [];
            options.series[0].data = [];
            jQuery('tr', table).each(function(i) {
                var tr = this;
                jQuery('th, td', tr).each(function(j) {
                    if (j == 0) {
                        options.xAxis.categories.push(this.innerHTML);
                    } else {
                        // add values
                        options.series[0].data.push(parseFloat(this.innerHTML));
                    }
                });
            });
            chart = new Highcharts.Chart(options);
        });
    }
}