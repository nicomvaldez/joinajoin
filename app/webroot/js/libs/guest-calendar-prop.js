function days_between(date1, date2) {

    // The number of milliseconds in one day

    var ONE_DAY = 1000 * 60 * 60 * 24;

    // Convert both dates to milliseconds

    var date1_ms = date1.getTime();

	var date2_ms = date2.getTime();

    // Calculate the difference in milliseconds

    var difference_ms = Math.abs(date1_ms - date2_ms);

    // Convert back to days and return

    return Math.round(difference_ms / ONE_DAY);

}

var $start = false;

var $week_start = false;

var $start_date = '';

var $start_month = '';

var $start_year = '';

var $end_date = false;

var $end_month = '';

var $end_year = '';

var $start_week = '';

var current_week = '';

var guest_calender = Array();

var guest_calender_date = Array();

var guest_calender_week = Array();

var view_calender = Array();

var view_calender_date = Array();

var view_calender_week = Array();

var unicor = '\u2588\u2584 \u2588\u2584\u2588 \u2588\u2580 \u2588\u2580 O \u2580\u2584\u2580\u2584\u2580     \u2588\u2580\u2588 G \u2588\u2580 \u2588 \u2580\u2584\u2580 \u2588\u2580\u2588 \n';

function reinitizeView($start, $end, $class, $element){

	$str = '';

	$start = parseInt($start);

	$end = parseInt($end);

	if ($start >= $end) {

		for (i = $start; i >= $end; i-- ) {

			if (view_calender[i][3] == 'available') {

				if($str == ''){

					$str = $element + i ;

				}

				else{

					$str = $str + ', '+ $element + i ;

				}

			}

			else{

				break;

			}

		}

	}

	else if ($start < $end) {

		for (i = $start; i <= $end; i++ ) {

			if (view_calender[i][3] == 'available') {

				if($str == ''){

					$str = $element + i ;

				}

				else{

					$str = $str + ', '+ $element + i ;

				}

			}

			else{

				break;

			}

		}

	}

	if($str != ''){

		$('.js-day-mouse-over').removeClass('js-day-mouse-over');

		$('.' + $class).removeClass($class);

		$($str).addClass($class);

	}

}



function reinitizeweekView($start, $end, $class, $element){

	$str = '';

	$start = parseInt($start);

	$end = parseInt($end);

	if ($start >= $end) {

		for (i = $start; i >= $end; i -- ) {

			if (view_calender_week[i][3] != 'undefined' && view_calender_week[i][3] != ''){

				if (view_calender_week[i][3] == 'available') {



					if($str == ''){

						$str = $element + i ;

					}

					else{

						$str = $str + ', '+$element + i ;

					}

				}

				else{

					break;

				}

			}

		}

	}

	else if ($start < $end) {

		for (i = $start; i <= $end; i++ ) {

			if (view_calender_week[i][3] != 'undefined' && view_calender_week[i][3] != ''){

				if (view_calender_week[i][3] == 'available') {

					if($str == ''){

						$str = $element + i ;

					}

					else{

						$str = $str + ', '+ $element + i ;

					}

				}

				else{

					break;

				}

			}

		}

	}

	if($str != ''){

		$('.js-week-mouseover').removeClass('js-week-mouseover');

		$('.' + $class).removeClass($class);

		$($str).addClass($class);

	}

}



function updatePrice($checkin, $checkout, $property_id, $guest, $type, no_of_days, guest, per_guest_amount, commisssion_amount) {

	$('.js-price-details-response').block();

    var price = '';
    var priceType = '';
    var precio = '';

    priceType = $('#PropertyJoinType').val();

    precio = Number($('#PropertyUserPricePeriod option:selected').val());

    cantidad = Number($('#PropertyUserGuests option:selected').val());

	var param = [ { name: "checkin", value: $checkin },

                { name: "checkout", value: $checkout },

				 { name: "property_id", value: $property_id },

                { name: "guest", value: $guest },

                { name: "price_type", value: priceType },

                { name: "precio", value: precio },

                { name: "cantidad", value: cantidad },

                { name: "type", value: $type }

                ];

    $.ajax( {

        type: 'POST',

        url: __cfg('path_relative') + 'properties/update_price',

        data: param,

        cache: false,

        success: function(responses) {

			total_guest_amount = parseFloat((guest * per_guest_amount) * no_of_days);

			price = parseFloat(responses );

			var security_deposit=0;

			if ($('.js-property-desposit-amount', '#properties-view').is('.js-property-desposit-amount')) {

				security_deposit=parseFloat($('.js-property-desposit-amount').html());

			}

            subtotal = parseFloat(price * $guest);

            servicetax = 0;

            if (subtotal != 0 && commisssion_amount != 0) {

                servicetax = parseFloat(subtotal * (commisssion_amount / 100));

            }

            total_amount = parseFloat(servicetax + subtotal + security_deposit);

            $('.js-property-no_day-night').html(no_of_days);

            $('.js-property-per-night-amount').html(price.toFixed(2));

            $('.js-property-guest-amount').html(total_guest_amount.toFixed(2));

            $('.js-property-subtotal-amount').html(subtotal.toFixed(2));

            $('.js-property-servicetax-amount').html(servicetax.toFixed(2));

            $('.js-property-total-amount').html(total_amount.toFixed(2));

			$('.js-price-details-response').unblock();

        }

    });

	return false;

}

function modFecha(fechaVieja){
	var fe = fechaVieja.split("-");
	var fechaNueva = fe[0]+"/"+fe[1]+"/"+fe[2];
	return fechaNueva;
}

(function($) {

	$.fn.productCalculation = function() {

		if ($('.js-price-for-product', '#properties-view').is('.js-price-for-product')) {

			$this = $('.js-price-for-product');

			price = '';

            date1 = new Date(modFecha($('#PropertyUserCheckin').val()));//new Date($('#PropertyUserCheckinYear').val() + '/' + $('#PropertyUserCheckinMonth').val() + '/' + $('#PropertyUserCheckinDay').val());

            date2 = new Date(modFecha($('#PropertyUserCheckout').val()));//new Date($('#PropertyUserCheckoutYear').val() + '/' + $('#PropertyUserCheckoutMonth').val() + '/' + $('#PropertyUserCheckoutDay').val());

            $checkin = $('#PropertyUserCheckin').val();

            $checkout = $('#PropertyUserCheckout').val();

			$property_id = $('#PropertyUserPropertyId').val();
			
			var d = new Date();

			var curr_date = d.getDate();

			var curr_month = d.getMonth()+1;

			var curr_year = d.getFullYear();

			if (curr_date < 10) {

				curr_date='0'+curr_date;

			}

			if (curr_month < 10) {

				curr_month='0'+curr_month;

			}

			var curent_date=curr_year+'-'+curr_month+'-'+curr_date;

			if (date1<=date2 &&  $checkin >= curent_date) {

				no_of_days = days_between(date1, date2);

			} else {

				no_of_days = 0;

			}

            no_of_guest_user = parseInt($('#PropertyUserGuests').val());

		//ORIGINAL	commisssion_amount = (isNaN(parseFloat($this.metadata().property_commission_amount))) ? 0: parseFloat($this.metadata().property_commission_amount);

//si no tiene nada en la base dejo la del sitio sino reemplazo
			//commisssion_amount = $('#pro_fee_client').val();//(isNaN(parseFloat($this.metadata().property_commission_amount))) ? 0: parseFloat($this.metadata().property_commission_amount);
			//si no tiene un valor seteado la propiedad o join, uso el valor por defecto del sitio
			if($('#pro_fee_client').val() == ''){
				commisssion_amount = parseFloat($this.metadata().property_commission_amount);
			}else{
				commisssion_amount = $('#pro_fee_client').val();
			}
          
          
          
            property_guest_user = (isNaN(parseInt($this.metadata().additional_guest))) ? 0 : parseInt($this.metadata().additional_guest);

            per_guest_amount = (isNaN(parseInt($this.metadata().additional_guest_price))) ? 0 : parseInt($this.metadata().additional_guest_price);

            guest = total_guest_amount = 0;

            guest = (no_of_guest_user == 0) ? property_guest_user: (no_of_guest_user - property_guest_user);

            guest = (guest < 0) ? 0: guest;

            if ($('#PropertyUserBookingOptionPricePerNight').is(':checked')) {

				price = updatePrice($checkin, $checkout, $property_id, no_of_guest_user, 'night', no_of_days, guest, per_guest_amount, commisssion_amount);

            }

            if ($('#PropertyUserBookingOptionPricePerWeek').is(':checked')) {

               price = parseFloat(updatePrice($checkin, $checkout, $property_id, no_of_guest_user, 'week', no_of_days, guest, per_guest_amount, commisssion_amount));

                week = Math.round(no_of_days / 7);

            }

            if ($('#PropertyUserBookingOptionPricePerMonth').is(':checked')) {

				price = parseFloat(updatePrice($checkin, $checkout, $property_id, no_of_guest_user, 'month', no_of_days, guest, per_guest_amount, commisssion_amount));

            }


			var d = new Date();

			var curr_date = d.getDate();

			var curr_month = d.getMonth()+1;

			var curr_year = d.getFullYear();

			if (curr_date < 10) {

				curr_date='0'+curr_date;

			}

			if (curr_month < 10) {

				curr_month='0'+curr_month;

			}

			var curent_date=curr_year+'-'+curr_month+'-'+curr_date;

			if ($checkin <= $checkout && $checkin >= curent_date) {

				//$('#js-checkinout-date').html(date('F d, Y', new Date($('#PropertyUserCheckinYear').val() + '/' + $('#PropertyUserCheckinMonth').val() + '/' + $('#PropertyUserCheckinDay').val())) + ' to ' + date('F d, Y', new Date($('#PropertyUserCheckoutYear').val() + '/' + $('#PropertyUserCheckoutMonth').val() + '/' + $('#PropertyUserCheckoutDay').val())));
                $('#js-checkinout-date').html(date('F d, Y', new Date($('#PropertyUserCheckin').val())));
			} else {

				$('#js-checkinout-date').html('Invalid date selection');

			}

			return false;

        }

		return false;

    };

	$.fn.productGuestFullCalenderLoad = function() {

		if($('td.js-guest-day-booking', 'div#colorbox').is('td.js-guest-day-booking')){

				//if ($('#PropertyUserBookingOptionPricePerNight').is(':checked')) {

					$("td.js-guest-day-booking").each(function(i) {

						guest_calender[$(this).metadata().cell] = new Array( $(this).metadata().date, $(this).metadata().month, $(this).metadata().year,  $(this).metadata().status, $(this).metadata().cell );

						temp_date = $(this).metadata().year + '/' +$(this).metadata().month + '/' + $(this).metadata().date;

						guest_calender_date[temp_date] = $(this).metadata().cell;

					});

				//}

        }

		if($('td.js-guest-week-booking', 'div#colorbox').is('td.js-guest-week-booking ')){

			//	if ($('#PropertyUserBookingOptionPricePerWeek').is(':checked')) {

					$("td.js-guest-week-booking").each(function(i) {

						guest_calender_week[$(this).metadata().week] = new Array( $(this).metadata().start_date, $(this).metadata().end_date, $(this).metadata().price,  $(this).metadata().status, $(this).metadata().week );

					});

			//	}

        }

		if ($('#PropertyUserBookingOptionPricePerNight').is(':checked')) {

			checkin_date = $('#PropertyUserCheckinYear').val() + '/' + parseInt($('#PropertyUserCheckinMonth').val(), 10) + '/' + parseInt($('#PropertyUserCheckinDay').val(), 10);

			checkout_date = $('#PropertyUserCheckoutYear').val() + '/' + parseInt($('#PropertyUserCheckoutMonth').val(), 10) + '/' + parseInt($('#PropertyUserCheckoutDay').val(), 10);

			checkin = new Date(checkin_date);

			checkout = new Date(checkout_date);

			var checkin_ms = checkin.getTime();

			var checkout_ms = checkout.getTime();

			var start_date_cal_date =  guest_calender[0][2] + '/' + parseInt(guest_calender[0][1], 10) + '/' + parseInt(guest_calender[0][0], 10);

			var start_date_cal =  new Date(start_date_cal_date);

			length_arr = (guest_calender.length) - 1;

			var end_date_cal_date = guest_calender[length_arr][2] + '/' + parseInt(guest_calender[length_arr][1], 10) + '/' + parseInt(guest_calender[length_arr][0], 10);

			var end_date_cal =  new Date(end_date_cal_date);

			var start_date_cal_ms = start_date_cal.getTime();

			var end_date_cal_ms = end_date_cal.getTime();

			$starting_point = $end_point = 0;

			if( (start_date_cal_ms <= checkin_ms) && (checkout_ms <= end_date_cal_ms)){

				$starting_point = guest_calender_date[checkin_date];

				$end_point = guest_calender_date[checkout_date];

			}

			else if( (start_date_cal_ms <= checkin_ms) && (end_date_cal_ms <= checkout_ms)){

				$starting_point = guest_calender_date[checkin_date];

				$end_point = guest_calender_date[checkout_date];

			}

			if( ($starting_point != 0) || ($end_point != 0))

			{

				reinitize($starting_point, $end_point, 'js-guest-current-select-date', '#guest-cell-');

			}

		}

		if ($('#PropertyUserBookingOptionPricePerWeek').is(':checked')) {

			temp_date = $('#PropertyUserCheckinYear').val() + '/' + parseInt($('#PropertyUserCheckinMonth').val(), 10) + '/' + parseInt($('#PropertyUserCheckinDay').val(), 10);

			temp_date1 = $('#PropertyUserCheckoutYear').val() + '/' + parseInt($('#PropertyUserCheckoutMonth').val(), 10) + '/' + parseInt($('#PropertyUserCheckoutDay').val(), 10);

			checkin = $('#PropertyUserCheckinYear').val() + '-' + $('#PropertyUserCheckinMonth').val() + '-' + $('#PropertyUserCheckinDay').val();

			checkout = $('#PropertyUserCheckoutYear').val() + '-' + $('#PropertyUserCheckoutMonth').val() + '-' + $('#PropertyUserCheckoutDay').val();

			$starting_point = $end_point = -1;

			if(guest_calender_date[temp_date] || guest_calender_date[temp_date1]){



				for(i=0 ; i < guest_calender_week.length; i++){

					if(guest_calender_week[i][0] == checkin && $starting_point == -1){

						$starting_point = guest_calender_week[i][4];

					}

					if(guest_calender_week[i][1] == checkout){

						$end_point = guest_calender_week[i][4];

					}

				}

				if( ($starting_point != -1) && ($end_point != -1))

					reinitizeweek($starting_point, $end_point, 'js-guest-current-select-week', '#guest-week-');

			}

		}



		return false;

    };



	$.fn.productCalenderLoad = function() {

		if($('td.js-day-booking', '#properties-view').is('td.js-day-booking')){

			$("td.js-day-booking").each(function(i) {

				view_calender[$(this).metadata().cell] = new Array( $(this).metadata().date, $(this).metadata().month, $(this).metadata().year,  $(this).metadata().status, $(this).metadata().cell );

				temp_date = $(this).metadata().year + '/' +$(this).metadata().month + '/' + $(this).metadata().date;

				view_calender_date[temp_date] = $(this).metadata().cell;

			});

        }

		if($('td.js-week-booking', '#properties-view').is('td.js-week-booking')){

			$("td.js-week-booking").each(function(i) {

				view_calender_week[$(this).metadata().week] = new Array( $(this).metadata().start_date, $(this).metadata().end_date, $(this).metadata().price,  $(this).metadata().status, $(this).metadata().week );

			});

        }

		if($('div.js-guestcalender-load-block', '#properties-view').is('div.js-guestcalender-load-block')){

			if ($('#PropertyUserBookingOptionPricePerNight').is(':checked')) {

				$start_date = $start_month = $start_year = $end_date = $end_month = $end_year = $start_week = current_week = '';

				$start = false;

				if($('.available:first').is('.js-day-booking')){

					$current = $('.available:first').not('.js-week-booking');

					if($current.metadata().date < 10){

						day = '0'+$current.metadata().date;

					} else {

						day = $current.metadata().date;

					}

					$current.addClass('js-current-select-date');

					$('#PropertyUserCheckinDay').val(($current.metadata().date < 10) ? '0'+ $current.metadata().date : $current.metadata().date);

					$('#PropertyUserCheckinMonth').val(($current.metadata().month < 10) ? '0'+ $current.metadata().month : $current.metadata().month);

					$('#PropertyUserCheckinYear').val($current.metadata().year);

					$('#PropertyUserCheckoutDay').val(($current.metadata().date < 10) ? '0'+ $current.metadata().date : $current.metadata().date);

					$('#PropertyUserCheckoutMonth').val(($current.metadata().month < 10) ? '0'+ $current.metadata().month : $current.metadata().month);

					$('#PropertyUserCheckoutYear').val($current.metadata().year);

				} else {

					var d = new Date();

					var curr_date = d.getDate();

					var curr_month = parseInt(d.getMonth()) + 1;

					var curr_year = d.getFullYear();

					$('#PropertyUserCheckinDay').val((curr_date < 10) ? '0'+ curr_date : curr_date);

					$('#PropertyUserCheckinMonth').val((curr_month < 10) ? '0'+ curr_month : curr_month);

					$('#PropertyUserCheckinYear').val(curr_year);

					$('#PropertyUserCheckoutDay').val((curr_date < 10) ? '0'+ curr_date : curr_date);

					$('#PropertyUserCheckoutMonth').val((curr_month < 10) ? '0'+ curr_month : curr_month);

					$('#PropertyUserCheckoutYear').val(curr_year);

				}

			}

			if($('.js-disable_monthly', '#properties-view').is('.js-disable_monthly')){

				$('#PropertyUserBookingOptionPricePerMonth').attr('disabled', 'disabled');

			}

        }

		return false;

    };

	$.fn.eachdaytooltipsadd = function() {

		if($('td.js-month-booking', 'body').is('td.js-month-booking')){

			$("td.js-month-booking").each(function (i) {

				$this = $(this);

				if ($this.metadata().status != undefined) {

					$this.tipsy( {

						trigger: 'hover',

						gravity: 's',

						title: $this.metadata().status

					});

				}

			  });

		}

		return false;

    };

})

(jQuery);

jQuery(document).ready(function($) {

	$('div.js-guestcalender-load-block').productCalenderLoad();

	$('.js-price-for-product').productCalculation();

	$('td.js-month-booking').eachdaytooltipsadd();

    $('form#PropertyUserAddForm').delegate('#PropertyUserGuests, #PropertyUserCheckin, #PropertyUserCheckout', 'change', function() {
        $('.js-price-for-product').productCalculation();
        return false;
    });

    $('form#PropertyUserAddForm').delegate('#PropertyUserPricePeriod', 'change', function() {

        $('.js-price-for-product').productCalculation();

        return false;

    });

	$('form#PropertyUserAddForm').delegate('#PropertyUserCheckoutDay, #PropertyUserCheckoutMonth, #PropertyUserCheckoutYear, #PropertyUserCheckinDay, #PropertyUserCheckinMonth, #PropertyUserCheckinYear', 'change', function() {

        $('#PropertyUserBookingOptionPricePerNight').attr('checked', 'checked');

        $('.js-price-for-product').productCalculation();

    });

	$('form#PropertyUserAddForm').delegate('.js-price-list', 'change', function() {

		if ($('#PropertyUserBookingOptionPricePerNight').is(':checked')) {

			$start_date = $start_month = $start_year = $end_date = $end_month = $end_year = $start_week = current_week = '';

            $start = false;

			$('.js-current-select-week').removeClass('js-current-select-week');

			$('.js-start-week').removeClass('js-start-week');

			$('.js-week-mouseover').removeClass('js-week-mouseover');

			return false;

		}

		else if ($('#PropertyUserBookingOptionPricePerWeek').is(':checked')) {

			$start_date = $start_month = $start_year = $end_date = $end_month = $end_year = $start_week = current_week = '';

            $start = false;

			$('.js-current-select-date').removeClass('js-current-select-date');

			$('.js-start-date').removeClass('js-start-date');

			$('.js-day-mouse-over').removeClass('js-day-mouse-over');

			return false;

		}

        else if ($('#PropertyUserBookingOptionPricePerMonth').is(':checked')) {

            start_date = $('.js-monthstart-date').html();

            end_date = $('.js-monthend-date').html();

            start_date = start_date.split('-');

            end_date = end_date.split('-');

            $('#PropertyUserCheckinDay').val(start_date[2]);

            $('#PropertyUserCheckinMonth').val(start_date[1]);

            $('#PropertyUserCheckinYear').val(start_date[0]);

            $('#PropertyUserCheckoutDay').val(end_date[2]);

            $('#PropertyUserCheckoutMonth').val(end_date[1]);

            $('#PropertyUserCheckoutYear').val(end_date[0]);

            $('.js-price-for-product').productCalculation();

			return false;

        }

    });

	$('.js-show-calendar').addClass('active');

    $('div.js-book-blok').delegate('.js-show-dropdown', 'click', function() {

        $this = $(this);

        $('.js-calender-formfield').show();

		$('.js-show-dropdown').addClass('active');

		$('.js-show-calendar').removeClass('active');

        $('.js-calender-form-calender').hide();

        return false;

    });

    $('div.js-book-blok').delegate('.js-show-calendar', 'click', function() {

        $this = $(this);

        $('.js-calender-formfield').hide();

		$('.js-show-calendar').addClass('active');

		$('.js-show-dropdown').removeClass('active');

        $('.js-calender-form-calender').show();

		viewCalenderReselect();

        return false;

    });

	$('div.js-calendar-response').delegate('.js-calender-prev, .js-calender-next', 'click', function() {

        var $this = $(this);

        var url = $this.metadata().url;

        $('.js-calendar-response').block();

        $.get(url, function(data) {

            $('.js-calendar-response').html(data);

            if (data.indexOf('js-disable_monthly') != -1) {

                if ($('#PropertyUserBookingOptionPricePerMonth').is(':checked')) {

                    $('#PropertyUserBookingOptionPricePerNight').attr('checked', 'checked');

                }

                $('#PropertyUserBookingOptionPricePerMonth').attr('disabled', 'disabled');

            } else {

                $('#PropertyUserBookingOptionPricePerMonth').removeAttr("disabled");

            }

			$('div.js-guestcalender-load-block').productCalenderLoad();

			$('.js-price-for-product').productCalculation();

			$('td.js-month-booking').eachdaytooltipsadd();

            $('.js-calendar-response').unblock();

            return false;

        });

        return false;

    });

	$('div#properties-view').delegate('td.js-week-booking', 'click', function() {

        $this = $(this);

        if ($('#PropertyUserBookingOptionPricePerWeek').is(':checked')) {

            if ($start == false) {

                if ($this.metadata().status == 'available') {

                    $this.addClass('js-start-week');

					$start = true;

				   $(".js-current-select-week").removeClass('js-current-select-week');

                    $start_week = $(this).metadata().week;

                    $this.addClass('js-current-select-week');

                    first_date = ($(this).metadata().start_date).split('-');

                    $start_month = parseInt(first_date[1],10);

                    $start_date = parseInt(first_date[2],10);

                    $start_year = parseInt(first_date[0]);

                    temp_dates = ($this.metadata().end_date).split('-');

                    $temp_month = parseInt(temp_dates[1],10);

                    $temp_date = parseInt(temp_dates[2],10);

                    $temp_year = parseInt(temp_dates[0]);



                    $start_month = ($start_month < 10) ? ('0' + $start_month): $start_month;

                    $start_date = ($start_date < 10) ? ('0' + $start_date): $start_date;

                    $temp_month = ($temp_month < 10) ? ('0' + $temp_month): $temp_month;

                    $temp_date = ($temp_date < 10) ? ('0' + $temp_date): $temp_date;

					$(".js-current-select-week").removeClass('js-current-select-week');

					$('.js-start-date').removeClass('js-start-date');

                    $('#PropertyUserCheckinDay').val($start_date);

                    $('#PropertyUserCheckinMonth').val($start_month);

                    $('#PropertyUserCheckinYear').val($start_year);

                    $('#PropertyUserCheckoutDay').val($temp_date);

                    $('#PropertyUserCheckoutMonth').val($temp_month);

                    $('#PropertyUserCheckoutYear').val($temp_year);

                    $('.js-price-for-product').productCalculation();

                }

            } else {

                current_week = parseInt($this.metadata().week);

				if ($start_week >= current_week) {

                    for (i = $start_week; i >= current_week; i -- ) {

                        if ($('.week-' + i).metadata().status != 'available') {

							current_week = i+1;

						}

					}

				}

				else if ($start_week < current_week) {

                    for (i = $start_week; i <= current_week; i ++ ) {

                        if ($('.week-' + i).metadata().status != 'available') {

							current_week = i-1;

						}

					}

				}

                if ($start_week >= current_week) {

                    for (i = $start_week; i >= current_week; i -- ) {

                        if ($('.week-' + i).metadata().status == 'available') {

                            $('#week-' + i).addClass('js-current-select-week');

                            first_date = ($this.metadata().end_date).split('-');

                            $end_month = parseInt(first_date[1]);

                            $end_date = parseInt(first_date[2]);

                            $end_year = parseInt(first_date[0]);

                        } else {

                            if ($start_week != '' && current_week != '') {

                                $(".js-week-booking").each(function(i) {

                                    if ($(this).is(".js-start-week")) {

                                        $(this).removeClass('js-start-week');

                                    }

                                });

                                if ($start_week < current_week) {

                                    first_date = ($('.week-' + $start_week).metadata().start_date).split('-');

                                    $start_month = parseInt(first_date[1], 10);

                                    $start_date = parseInt(first_date[2], 10);

                                    $start_year = parseInt(first_date[0]);

                                    second_date = ($('.week-' + current_week).metadata().end_date).split('-');

                                    $end_month = parseInt(second_date[1], 10);

                                    $end_date = parseInt(second_date[2], 10);

                                    $end_year = parseInt(second_date[0]);

                                } else {

                                    second_date = ($('.week-' + current_week).metadata().start_date).split('-');

                                    first_date = ($('.week-' + $start_week).metadata().end_date).split('-');

                                    $start_month = parseInt(first_date[1], 10);

                                    $start_date = parseInt(first_date[2], 10);

                                    $start_year = parseInt(first_date[0]);

                                    $end_month = parseInt(second_date[1], 10);

                                    $end_date = parseInt(second_date[2], 10);

                                    $end_year = parseInt(second_date[0]);

                                }

                                $start_month = ($start_month < 10) ? ('0' + $start_month): $start_month;

                                $end_month = ($end_month < 10) ? ('0' + $end_month): $end_month;

                                $end_date = ($end_date < 10) ? ('0' + $end_date): $end_date;

                                $start_date = ($start_date < 10) ? ('0' + $start_date): $start_date;



                                if ($start_week <= current_week) {

                                    $('#PropertyUserCheckinDay').val($start_date);

                                    $('#PropertyUserCheckinMonth').val($start_month);

                                    $('#PropertyUserCheckinYear').val($start_year);

                                    $('#PropertyUserCheckoutDay').val($end_date);

                                    $('#PropertyUserCheckoutMonth').val($end_month);

                                    $('#PropertyUserCheckoutYear').val($end_year);

                                } else {

                                    $('#PropertyUserCheckoutDay').val($start_date);

                                    $('#PropertyUserCheckoutMonth').val($start_month);

                                    $('#PropertyUserCheckoutYear').val($start_year);

                                    $('#PropertyUserCheckinDay').val($end_date);

                                    $('#PropertyUserCheckinMonth').val($end_month);

                                    $('#PropertyUserCheckinYear').val($end_year);

                                }

                                $('.js-price-for-product').productCalculation();

                                $start_date = $start_month = $start_year = $end_date = $end_month = $end_year = $start_week = current_week = '';

                                $start = false;

                            }

                            return false;

                        }

                    }

                } else if ($start_week < current_week) {

                    for (i = $start_week; i <= current_week; i ++ ) {

                        if ($('.week-' + i).metadata().status == 'available') {

                            $('#week-' + i).addClass('js-current-select-week');

                            first_date = ($('.week-' + i).metadata().end_date).split('-');

                            $end_month = parseInt(first_date[1]);

                            $end_date = parseInt(first_date[2]);

                            $end_year = parseInt(first_date[0]);

                        } else {

                            if ($start_week != '' && current_week != '') {

                                $(".js-start-week").removeClass('js-start-week');

                                if ($start_week <= current_week) {

                                    first_date = ($('.week-' + $start_week).metadata().start_date).split('-');

                                    $start_month = parseInt(first_date[1], 10);

                                    $start_date = parseInt(first_date[2], 10);

                                    $start_year = parseInt(first_date[0]);

                                    second_date = ($('.week-' + current_week).metadata().end_date).split('-');

                                    $end_month = parseInt(second_date[1], 10);

                                    $end_date = parseInt(second_date[2], 10);

                                    $end_year = parseInt(second_date[0]);

                                } else {

                                    second_date = ($('.week-' + current_week).metadata().start_date).split('-');

                                    first_date = ($('.week-' + $start_week).metadata().end_date).split('-');

                                    $start_month = parseInt(first_date[1], 10);

                                    $start_date = parseInt(first_date[2], 10);

                                    $start_year = parseInt(first_date[0]);

                                    $end_month = parseInt(second_date[1], 10);

                                    $end_date = parseInt(second_date[2], 10);

                                    $end_year = parseInt(second_date[0]);

                                }

                                $start_month = ($start_month < 10) ? ('0' + $start_month): $start_month;

                                $end_month = ($end_month < 10) ? ('0' + $end_month): $end_month;

                                $end_date = ($end_date < 10) ? ('0' + $end_date): $end_date;

                                $start_date = ($start_date < 10) ? ('0' + $start_date): $start_date;

                                if ($start_week <= current_week) {

                                    $('#PropertyUserCheckinDay').val($start_date);

                                    $('#PropertyUserCheckinMonth').val($start_month);

                                    $('#PropertyUserCheckinYear').val($start_year);

                                    $('#PropertyUserCheckoutDay').val($end_date);

                                    $('#PropertyUserCheckoutMonth').val($end_month);

                                    $('#PropertyUserCheckoutYear').val($end_year);

                                } else {

                                    $('#PropertyUserCheckoutDay').val($start_date);

                                    $('#PropertyUserCheckoutMonth').val($start_month);

                                    $('#PropertyUserCheckoutYear').val($start_year);

                                    $('#PropertyUserCheckinDay').val($end_date);

                                    $('#PropertyUserCheckinMonth').val($end_month);

                                    $('#PropertyUserCheckinYear').val($end_year);

                                }

                                $('.js-price-for-product').productCalculation();

                                $start_date = $start_month = $start_year = $end_date = $end_month = $end_year = $start_week = current_week = '';

                                $start = false;

                            }

                            return false;

                        }

                    }

                }

                if ($start_week != '' && current_week != '') {

                    $(".js-start-week").removeClass('js-start-week');

                    if ($start_week <= current_week) {

                        first_date = ($('.week-' + $start_week).metadata().start_date).split('-');

                        $start_month = parseInt(first_date[1], 10);

                        $start_date = parseInt(first_date[2], 10);

                        $start_year = parseInt(first_date[0]);

                        second_date = ($('.week-' + current_week).metadata().end_date).split('-');

                        $end_month = parseInt(second_date[1], 10);

                        $end_date = parseInt(second_date[2], 10);

                        $end_year = parseInt(second_date[0]);

                    } else {

                        second_date = ($('.week-' + current_week).metadata().start_date).split('-');

                        first_date = ($('.week-' + $start_week).metadata().end_date).split('-');

                        $start_month = parseInt(first_date[1], 10);

                        $start_date = parseInt(first_date[2], 10);

                        $start_year = parseInt(first_date[0]);

                        $end_month = parseInt(second_date[1], 10);

                        $end_date = parseInt(second_date[2], 10);

                        $end_year = parseInt(second_date[0]);

                    }

                    $start_month = ($start_month < 10) ? ('0' + $start_month): $start_month;

                    $end_month = ($end_month < 10) ? ('0' + $end_month): $end_month;

                    $end_date = ($end_date < 10) ? ('0' + $end_date): $end_date;

                    $start_date = ($start_date < 10) ? ('0' + $start_date): $start_date;

                    if ($start_week <= current_week) {

                        $('#PropertyUserCheckinDay').val($start_date);

                        $('#PropertyUserCheckinMonth').val($start_month);

                        $('#PropertyUserCheckinYear').val($start_year);

                        $('#PropertyUserCheckoutDay').val($end_date);

                        $('#PropertyUserCheckoutMonth').val($end_month);

                        $('#PropertyUserCheckoutYear').val($end_year);

                    } else {

                        $('#PropertyUserCheckoutDay').val($start_date);

                        $('#PropertyUserCheckoutMonth').val($start_month);

                        $('#PropertyUserCheckoutYear').val($start_year);

                        $('#PropertyUserCheckinDay').val($end_date);

                        $('#PropertyUserCheckinMonth').val($end_month);

                        $('#PropertyUserCheckinYear').val($end_year);

                    }

                    $('.js-price-for-product').productCalculation();

                    $start_date = $start_month = $start_year = $end_date = $end_month = $end_year = $start_week = current_week = '';

                    $start = false;

                }

            }

        } else {

            alert('Please select per week option');

        }

        return false;

    });

   $('div#properties-view').delegate('td.js-week-booking', 'mouseenter', function() {

		$this = $(this);

		//$.doTimeout( 'hover', 100, function(elem){

			if ($('#PropertyUserBookingOptionPricePerWeek').is(':checked')) {

				if ($start == true) {

					current_week = parseInt($this.metadata().week);

					$(".js-week-mouseover").removeClass('js-week-mouseover');

					if ($start_week > current_week) {

						for (i = $start_week; i >= current_week; i -- ) {

							if ($('.week-' + i).metadata().status == 'available') {

								$('#week-' + i).addClass('js-week-mouseover');

							} else {

								return false;

							}

						}

					} else if ($start_week < current_week) {

						for (i = $start_week; i <= current_week; i ++ ) {

							if ($('.week-' + i).metadata().status == 'available') {

								$('#week-' + i).addClass('js-week-mouseover');

							} else {

								return false;

							}

						}

					}

				}

				else{

					if ($this.metadata().status == 'available') {

						week = parseInt($this.metadata().week);

						$('#week-' + week).addClass('js-week-mouseover');

					}

				}

			}

		//}, this);

        return false;

    }).delegate('td.js-week-booking', 'mouseleave', function() {

        if ($('#PropertyUserBookingOptionPricePerWeek').is(':checked')) {

            $this = $(this);

            if ($this.metadata().status == 'available' && $start == false && !($this.is('.js-current-select-week'))) {

                first_date['date'] = parseInt($this.metadata().week);

				$('#week-' + first_date['date']).removeClass('js-week-mouseover');

            }

        }

        return false;

    });

	$('div#properties-view').delegate('td.js-day-booking', 'click', function() {

        $this = $(this);

        $this.parents('#PropertyUserAddForm').find('#bookitJoin').attr('data-select','si');

        if (($('#PropertyUserBookingOptionPricePerNight').is(':checked'))) {

            if ($start == false) {
				$(".js-day-mouse-over").removeClass('js-day-mouse-over');
                if ($this.metadata().status == 'available') {

					//$('.js-cal-status').addClass('blink');

					//$('.js-cal-status').addClass('js-date-picker-info');

					//$('.js-cal-status').html('Select check-out date in calendar');

					//$('.blink').cyclicFade();

                    //$this.addClass('js-start-date');

					$start = true;

					$(".js-current-select-date").removeClass('js-current-select-date');

                    $(this).addClass('js-current-select-date');

                    $start_month = parseInt($this.metadata().month);

                    $start_date = parseInt($this.metadata().date);

                    $start_year = parseInt($this.metadata().year);



					$(".js-current-select-week").removeClass('js-current-select-week');

					$('.js-start-week').removeClass('js-start-week');

					if ($end_date != '') {

                        $('#PropertyUserCheckinMonth').val($start_month);

                        $('#PropertyUserCheckoutMonth').val($start_month);

                        $('#PropertyUserCheckoutDay').val($start_date);

                        $('#PropertyUserCheckinDay').val($start_date);

                        $('#PropertyUserCheckoutYear').val($start_year);

                        $('#PropertyUserCheckinYear').val($start_year);

                        $('.js-price-for-product').productCalculation();

                    }

                }
				$this.click();
            } else {

				//$('.js-cal-status').html('');

				//$('.js-cal-status').removeClass('js-date-picker-info');

				//$('.blink').cyclicFade('stop');

                current_date = parseInt($this.metadata().date);

                if ($start_date >= current_date) {

                    for (i = $start_date; i >= current_date; i -- ) {

                        if ($('.cell-' + i).metadata().status == 'available') {

                            $('#cell-' + i).addClass('js-current-select-date');

                            $end_month = parseInt($('.cell-' + i).metadata().month);

                            $end_date = parseInt($('.cell-' + i).metadata().date);

                            $end_year = parseInt($('.cell-' + i).metadata().year);

                        } else {

                            if ($start_date != '' || $end_date != '') {

                                if ($end_date == '') {

                                    $end_date = $start_date;

                                    $end_date = $start_month;

                                    $end_date = $start_year;

                                }

								$('.js-start-date').removeClass('js-start-date');

                                $start_month = ($start_month < 10) ? ('0' + $start_month): $start_month;

                                $end_month = ($end_month < 10) ? ('0' + $end_month): $end_month;

                                $end_date = ($end_date < 10) ? ('0' + $end_date): $end_date;

                                $start_date = ($start_date < 10) ? ('0' + $start_date): $start_date;

                                $('#PropertyUserCheckinMonth').val($end_month);

                                $('#PropertyUserCheckoutMonth').val($start_month);

                                $('#PropertyUserCheckoutDay').val($start_date);

                                $('#PropertyUserCheckinDay').val($end_date);

                                $('#PropertyUserCheckoutYear').val($start_year);

                                $('#PropertyUserCheckinYear').val($end_year);

                                $('.js-price-for-product').productCalculation();

                                $start_date = $start_month = $start_year = $end_date = $end_month = $end_year = '';

                                $start = false;

                            }

                            return false;

                        }

                    }

                } else if ($start_date < current_date) {

                    for (i = $start_date; i <= current_date; i ++ ) {

                        if ($('.cell-' + i).metadata().status == 'available') {

                            $('#cell-' + i).addClass('js-current-select-date');

                            $end_month = parseInt($('.cell-' + i).metadata().month);

                            $end_date = parseInt($('.cell-' + i).metadata().date);

                            $end_year = parseInt($('.cell-' + i).metadata().year);

                        } else {

                            if ($start_date != '' || $end_date != '') {

                                if ($end_date == '') {

                                    $end_date = $start_date;

                                    $end_date = $start_month;

                                    $end_date = $start_year;

                                }

								$('.js-start-date').removeClass('js-start-date');

                                $start_month = ($start_month < 10) ? ('0' + $start_month): $start_month;

                                $end_month = ($end_month < 10) ? ('0' + $end_month): $end_month;

                                $end_date = ($end_date < 10) ? ('0' + $end_date): $end_date;

                                $start_date = ($start_date < 10) ? ('0' + $start_date): $start_date;

                                $('#PropertyUserCheckoutMonth').val($end_month);

                                $('#PropertyUserCheckinMonth').val($start_month);

                                $('#PropertyUserCheckinDay').val($start_date);

                                $('#PropertyUserCheckinYear').val($start_year);

                                $('#PropertyUserCheckoutDay').val($end_date);

                                $('#PropertyUserCheckoutYear').val($end_year);

                                $('.js-price-for-product').productCalculation();

                                $start_date = $start_month = $start_year = $end_date = $end_month = $end_year = '';

                                $start = false;

                            }

                            return false;

                        }

                    }

                }

                if ($start_date != '' || $end_date != '') {

                    if ($end_date == '') {

                        $end_date = $start_date;

                        $end_date = $start_month;

                        $end_date = $start_year;

                    }

				   $('.js-start-date').removeClass('js-start-date');

                    $start_month = ($start_month < 10) ? ('0' + $start_month): $start_month;

                    $end_month = ($end_month < 10) ? ('0' + $end_month): $end_month;

                    $end_date = ($end_date < 10) ? ('0' + $end_date): $end_date;

                    $start_date = ($start_date < 10) ? ('0' + $start_date): $start_date;

                    $('#PropertyUserCheckoutMonth').val($end_month);

                    $('#PropertyUserCheckinMonth').val($start_month);

                    $('#PropertyUserCheckinYear').val($start_year);

                    $('#PropertyUserCheckoutYear').val($end_year);

                    if ($start_date < $end_date) {

                        $('#PropertyUserCheckinDay').val($start_date);

                        $('#PropertyUserCheckoutDay').val($end_date);

                    } else {

                        $('#PropertyUserCheckoutDay').val($start_date);

                        $('#PropertyUserCheckinDay').val($end_date);

                    }

                    $('.js-price-for-product').productCalculation();

                    $start_date = $start_month = $start_year = $end_date = $end_month = $end_year = '';

                    $start = false;

                }

            }

        } else {

            alert('Please select price option');

        }

        return false;

    });

	$('div#properties-view').delegate('td.js-day-booking', 'mouseenter', function() {

		$this = $(this);

		//$.doTimeout( 'hover', 100, function(elem){

			if ($('#PropertyUserBookingOptionPricePerNight').is(':checked')) {

				if ($start == true) {

					current_date = parseInt($this.metadata().date);

					 $(".js-day-mouse-over").removeClass('js-day-mouse-over');

					if ($start_date > current_date) {

						for (i = $start_date; i >= current_date; i -- ) {

							if ($('.cell-' + i).metadata().status == 'available') {

								$('#cell-' + i).addClass('js-day-mouse-over');

							} else {

								return false;

							}

						}

					} else if ($start_date < current_date) {

						for (i = $start_date; i <= current_date; i ++ ) {

							if ($('.cell-' + i).metadata().status == 'available') {

								$('#cell-' + i).addClass('js-day-mouse-over');

							} else {

								return false;

							}

						}

					}

				}

				else{

					if ($this.metadata().status == 'available') {

						first_date['date'] = parseInt($this.metadata().date);

						$('#cell-' + first_date['date']).addClass('js-day-mouse-over');

					}

				}

			}

		//}, this);

        return false;

    }).delegate('td.js-day-booking', 'mouseleave', function() {

        if ($('#PropertyUserBookingOptionPricePerNight').is(':checked')) {

            $this = $(this);

            if ($this.metadata().status == 'available' && $start == false && !($this.is('.js-current-select-date'))) {

                first_date['date'] = parseInt($this.metadata().date);

				$('#cell-' + first_date['date']).removeClass('js-day-mouse-over');

            }

        }

		//$.doTimeout( 'hover' );

        return false;

    });

});

