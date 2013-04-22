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
var $full_start = false;
var $first_select = '';
var $full_start_date = '';
var $full_start_month = '';
var $full_start_year = '';
var $full_end_date = '';
var $full_end_month = '';
var $full_end_year = '';
var $full_start_week = '';
var $full_current_week = '';
var unicor = '\u2588\u2584 \u2588\u2584\u2588 \u2588\u2580 \u2588\u2580 O \u2580\u2584\u2580\u2584\u2580     \u2588\u2580\u2588 G \u2588\u2580 \u2588 \u2580\u2584\u2580 \u2588\u2580\u2588 \n';
function reinitize($start, $end, $class, $element){
	$str = '';
	$start = parseInt($start);
	$end = parseInt($end);
	if ($start >= $end) {
		for (i = $start; i >= $end; i-- ) {
			if (guest_calender[i][3] == 'available') {
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
			if (guest_calender[i][3] == 'available') {
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
		$('.js-guest-day-mouseover').removeClass('js-guest-day-mouseover');
		$('.' +$class).removeClass($class);
		$($str).addClass($class);
	}
}

function selectDateGuestCalaender($start, $end, $class){
	$str = '';
	if (guest_calender[$start][3] == 'available') {
		$full_start_date = parseInt(guest_calender[$start][0]);
		$full_start_month = parseInt(guest_calender[$start][1]);
		$full_start_year = parseInt(guest_calender[$start][2]);
	}
	if ($start >= $end) {
		for (i = $start; i >= $end; i -- ) {
			if (guest_calender[i][3] == 'available') {
				if($str == ''){
					$str = '#guest-cell-' + i ;
				}
				else{
					$str = $str + ', #guest-cell-' + i ;
				}
				$full_end_date = parseInt(guest_calender[i][0]);
				$full_end_month = parseInt(guest_calender[i][1]);
				$full_end_year = parseInt(guest_calender[i][2]);
			}
			else{
				break;
			}
		}
	}
	else if ($start < $end) {
		for (i = $start; i <= $end; i++ ) {
			if (guest_calender[i][3] == 'available') {
				if($str == ''){
					$str = '#guest-cell-' + i ;
				}
				else{
					$str = $str + ', #guest-cell-' + i ;
				}
				$full_end_date = parseInt(guest_calender[i][0]);
				$full_end_month = parseInt(guest_calender[i][1]);
				$full_end_year = parseInt(guest_calender[i][2]);
			}
			else{
				break;
			}
		}
	}
	if($str != ''){
		$('.' +$class).removeClass($class);
		$($str).addClass($class);
	}
	$full_start_month = ($full_start_month < 10) ? ('0' + $full_start_month): $full_start_month;
	$full_end_month = ($full_end_month < 10) ? ('0' + $full_end_month): $full_end_month;
	$full_end_date = ($full_end_date < 10) ? ('0' + $full_end_date): $full_end_date;
	$full_start_date = ($full_start_date < 10) ? ('0' + $full_start_date): $full_start_date;
	if ($start < $end) {
		$('#PropertyUserCheckinMonth').val($full_start_month);
		$('#PropertyUserCheckinDay').val($full_start_date);
		$('#PropertyUserCheckinYear').val($full_start_year);
		$('#PropertyUserCheckoutDay').val($full_end_date);
		$('#PropertyUserCheckoutMonth').val($full_end_month);
		$('#PropertyUserCheckoutYear').val($full_end_year);
	}
	else{
		$('#PropertyUserCheckinMonth').val($full_end_month);
		$('#PropertyUserCheckoutMonth').val($full_start_month);
		$('#PropertyUserCheckoutDay').val($full_start_date);
		$('#PropertyUserCheckinDay').val($full_end_date);
		$('#PropertyUserCheckoutYear').val($full_start_year);
		$('#PropertyUserCheckinYear').val($full_end_year);
	}
	$(".js-guest-start-date").removeClass('js-guest-start-date');
	viewCalenderReselect();
	$first_select = $full_start_date = $full_start_month = $full_start_year = $full_end_date = $full_end_month = $full_end_year = '';
	$full_start = false;
}

function viewCalenderReselect(){
		if ($('#PropertyUserBookingOptionPricePerNight').is(':checked')) {
			checkin_date = $('#PropertyUserCheckinYear').val() + '/' + parseInt($('#PropertyUserCheckinMonth').val(), 10) + '/' + parseInt($('#PropertyUserCheckinDay').val(), 10);
			checkout_date = $('#PropertyUserCheckoutYear').val() + '/' + parseInt($('#PropertyUserCheckoutMonth').val(), 10) + '/' + parseInt($('#PropertyUserCheckoutDay').val(), 10);
			checkin = new Date(checkin_date);
			checkout = new Date(checkout_date);
			var checkin_ms = checkin.getTime();
			var checkout_ms = checkout.getTime();
			var start_date_cal_date =  view_calender[1][2] + '/' + parseInt(view_calender[1][1], 10) + '/' + parseInt(view_calender[1][0], 10);
			var start_date_cal =  new Date(start_date_cal_date);
			length_arr = view_calender.length - 1;
			var end_date_cal_date = view_calender[length_arr][2] + '/' + parseInt(view_calender[length_arr][1], 10) + '/' + parseInt(view_calender[length_arr][0], 10);
			var end_date_cal =  new Date(end_date_cal_date);
			var start_date_cal_ms = start_date_cal.getTime();
			var end_date_cal_ms = end_date_cal.getTime();
			$starting_point = $end_point = 0;
			if( (start_date_cal_ms <= checkin_ms) && (checkout_ms <= end_date_cal_ms)){
				$starting_point = view_calender_date[checkin_date];
				$end_point = view_calender_date[checkout_date];
			}
			else if( (checkin_ms  <= start_date_cal_ms) && (checkout_ms <= end_date_cal_ms)){
				$starting_point = view_calender_date[start_date_cal_date];
				$end_point = view_calender_date[checkout_date];
			}
			else if( (checkin_ms  <= start_date_cal_ms) && (end_date_cal_ms <= checkout_ms)){
				$starting_point = view_calender_date[start_date_cal_date];
				$end_point = view_calender_date[end_date_cal_date];
			}
			else if( (start_date_cal_ms <= checkin_ms) && (end_date_cal_ms <= checkout_ms) && (checkin_ms <= end_date_cal_ms)){
				$starting_point = view_calender_date[checkin_date];
				$end_point = view_calender_date[end_date_cal_date];
			}
			if( ($starting_point != 0) || ($end_point != 0)){
				reinitizeView($starting_point, $end_point, 'js-current-select-date', '#cell-');
			}
			else{
				$('.js-day-mouse-over').removeClass('js-day-mouse-over');
				$('.js-current-select-date').removeClass('js-current-select-date');
			}
		}
		if ($('#PropertyUserBookingOptionPricePerWeek').is(':checked')) {

			temp_date = $('#PropertyUserCheckinYear').val() + '/' + parseInt($('#PropertyUserCheckinMonth').val(), 10) + '/' + parseInt($('#PropertyUserCheckinDay').val(), 10);
			temp_date1 = $('#PropertyUserCheckoutYear').val() + '/' + parseInt($('#PropertyUserCheckoutMonth').val(), 10) + '/' + parseInt($('#PropertyUserCheckoutDay').val(), 10);
			checkin = $('#PropertyUserCheckinYear').val() + '-' + $('#PropertyUserCheckinMonth').val() + '-' + $('#PropertyUserCheckinDay').val();
			checkout = $('#PropertyUserCheckoutYear').val() + '-' + $('#PropertyUserCheckoutMonth').val() + '-' + $('#PropertyUserCheckoutDay').val();
			$starting_point = $end_point = -1;
			if(view_calender_date[temp_date] || view_calender_date[temp_date1]){
				for(i=1 ; i <= view_calender_week.length; i++){
					if(view_calender_week[i]){
						if(view_calender_week[i][0] == checkin && $starting_point == -1){
							$starting_point = view_calender_week[i][4];
							$end_point = view_calender_week[i][4];
						}
						if(view_calender_week[i][1] == checkout || $starting_point != -1){
							$end_point = view_calender_week[i][4];
						}
					}
				}
				if(($starting_point != -1) || ($end_point != -1) )
					reinitizeweekView($starting_point, $end_point, 'js-current-select-week', '#week-');
				else{
					$('.js-week-mouseover').removeClass('js-week-mouseover');
					$('.js-current-select-week').removeClass('js-current-select-week');
				}
			}
			else{
				$('.js-week-mouseover').removeClass('js-week-mouseover');
				$('.js-current-select-week').removeClass('js-current-select-week');
			}
		}

}

function reinitizeweek($start, $end, $class, $element){
	$str = '';
	$start = parseInt($start);
	$end = parseInt($end);
	if ($start >= $end) {
		for (i = $start; i >= $end; i -- ) {
			if (guest_calender_week[i][3] == 'available') {

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
	else if ($start < $end) {
		for (i = $start; i <= $end; i++ ) {
			if (guest_calender_week[i][3] == 'available') {
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
		$('.js-guest-week-mouseover').removeClass('js-guest-week-mouseover');
		$('.' +$class).removeClass($class);
		$($str).addClass($class);
	}
}




jQuery(document).ready(function($) {
	$('div#colorbox').delegate('.js-guest-day-booking', 'click', function() {
        $this = $(this);
        if ($('#PropertyUserBookingOptionPricePerNight').is(':checked')) {
			if($(".js-guest-start-date", "div#colorbox").is(".js-guest-start-date")){
				$thist = $(".js-guest-start-date", "div#colorbox");
				$full_start = true;
				$first_select = parseInt($thist.metadata().cell);
				$full_start_month = parseInt($thist.metadata().month);
				$full_start_date = parseInt($thist.metadata().date);
				$full_start_year = parseInt($thist.metadata().year);
			}
            if ($full_start == false) {
                if ($this.metadata().status == 'available') {
                    $this.addClass('js-guest-start-date');
					$full_start = true;
				    $(".js-guest-current-select-date").removeClass('js-guest-current-select-date');
                    $this.addClass('js-guest-current-select-date');
					$first_select = parseInt($this.metadata().cell);
                    $full_start_month = parseInt($this.metadata().month);
                    $full_start_date = parseInt($this.metadata().date);
                    $full_start_year = parseInt($this.metadata().year);

                    if ($full_end_date != '') {
                        $('#PropertyUserCheckinMonth').val($full_start_month);
                        $('#PropertyUserCheckoutMonth').val($full_start_month);
                        $('#PropertyUserCheckoutDay').val($full_start_date);
                        $('#PropertyUserCheckinDay').val($full_start_date);
                        $('#PropertyUserCheckoutYear').val($full_start_year);
                        $('#PropertyUserCheckinYear').val($full_start_year);
                        $('.js-price-for-product').productCalculation();
                    }
                }
            } else {
                current_date = parseInt($this.metadata().cell);
				selectDateGuestCalaender($first_select, current_date, 'js-guest-current-select-date');
				//viewCalenderReselect();
				$('.js-price-for-product').productCalculation();
				$.colorbox.close();
				$('.tipsy').hide();
				return false;
            }
        } else {
            alert('Please select per night option');
        }
        return false;
    });
	$('div#colorbox').delegate('.js-guest-day-booking', 'mouseenter', function() {
		$this = $(this);
		//$.doTimeout( 'hover', 100, function(elem){
			if ($('#PropertyUserBookingOptionPricePerNight').is(':checked')) {
				if ($full_start == true) {
					current_date = parseInt($this.metadata().cell);
					$(".js-guest-day-mouseover").removeClass('js-guest-day-mouseover');
					reinitize($first_select, current_date, 'js-guest-day-mouseover', '#guest-cell-');
					return false;
				}
				else{
					if ($this.metadata().status == 'available') {
						cell = parseInt($this.metadata().cell);
						$('#guest-cell-' + cell ).addClass('js-guest-day-mouseover');
					}
				}
			}

	   // }, this);
        return false;
    }).delegate('td.js-guest-day-booking', 'mouseleave', function() {
		//$.doTimeout( 'hover' );
		if ($('#PropertyUserBookingOptionPricePerNight').is(':checked')) {
			$this = $(this);
			if ($this.metadata().status == 'available' && $full_start == false && !($this.is('.js-guest-current-select-date'))) {
				first_date['date'] = parseInt($this.metadata().cell);
				$('#guest-cell-' + first_date['date']).removeClass('js-guest-day-mouseover');
			}
		}
  });
	$('div#colorbox').delegate('.js-guest-calender-prev, .js-guest-calender-next', 'click', function() {
        var $this = $(this);
        var url = $this.metadata().url;
        $('.js-guest-calendar-response').block();
        $.get(url, function(data) {
            $('.js-guest-calendar-response').html(data);
            if (data.indexOf('js-disable_monthly') != -1) {
                if ($('#PropertyUserBookingOptionPricePerMonth').is(':checked')) {
                    $('#PropertyUserBookingOptionPricePerNight').attr('checked', 'checked');
                }
                $('#PropertyUserBookingOptionPricePerMonth').attr('disabled', 'disabled');
            } else {
                $('#PropertyUserBookingOptionPricePerMonth').removeAttr("disabled");
            }
			$('td.js-month-booking').eachdaytooltipsadd();
			$('div#colorbox').productGuestFullCalenderLoad();
            $('.js-guest-calendar-response').unblock();
            return false;
        });
        return false;
    });
   $('div#colorbox').delegate('td.js-guest-week-booking', 'mouseenter', function() {
		$this = $(this);
		//$.doTimeout( 'hover', 100, function(elem){
			if ($('#PropertyUserBookingOptionPricePerWeek').is(':checked')) {
				if ($full_start == true) {
					$full_current_week = parseInt($this.metadata().week);
					$(".js-guest-week-mouseover").removeClass('js-guest-week-mouseover');
					reinitizeweek($full_start_week, $full_current_week, 'js-guest-week-mouseover', '#guest-week-');
					return false;
				}
				else{
					if ($this.metadata().status == 'available') {
						week = parseInt($this.metadata().week);
						$('#guest-week-' + week).addClass('js-guest-week-mouseover');
					}
				}
			}
		//}, this);
        return false;
    }).delegate('td.js-guest-week-booking', 'mouseleave', function() {
		$this = $(this);
        if ($('#PropertyUserBookingOptionPricePerWeek').is(':checked')) {
            if ($this.metadata().status == 'available' && $full_start == false && !($this.is('.js-guest-current-select-week'))) {
                first_date['date'] = parseInt($this.metadata().week);
				$('#guest-week-' + first_date['date']).removeClass('js-guest-week-mouseover');
            }
        }
		//$.doTimeout( 'hover' );
        return false;
    });
	$('div#colorbox').delegate('td.js-guest-week-booking', 'click', function() {
        $this = $(this);
        if ($('#PropertyUserBookingOptionPricePerWeek').is(':checked')) {
            if ($full_start == false) {
                if ($this.metadata().status == 'available') {
                    $this.addClass('js-guest-start-week');
					$full_start = true;
					$(".js-guest-current-select-week").removeClass('js-guest-current-select-week');
                    $full_start_week = $(this).metadata().week;
                    $this.addClass('js-guest-current-select-week');
                    first_date = ($(this).metadata().start_date).split('-');

                    $full_start_month = parseInt(first_date[1]);
                    $full_start_date = parseInt(first_date[2]);
                    $full_start_year = parseInt(first_date[0]);
                    temp_dates = ($this.metadata().end_date).split('-');
                    $temp_month = parseInt(temp_dates[1]);
                    $temp_date = parseInt(temp_dates[2]);
                    $temp_year = parseInt(temp_dates[0]);

                    $full_start_month = ($full_start_month < 10) ? ('0' + $full_start_month): $full_start_month;
                    $full_start_date = ($full_start_date < 10) ? ('0' + $full_start_date): $full_start_date;
                    $temp_month = ($temp_month < 10) ? ('0' + $temp_month): $temp_month;
                    $temp_date = ($temp_date < 10) ? ('0' + $temp_date): $temp_date;

					$(".js-guest-current-select-date").removeClass('js-guest-current-select-date');
					$('.js-guest-start-date').removeClass('js-guest-start-date');

                    $('#PropertyUserCheckinDay').val($full_start_date);
                    $('#PropertyUserCheckinMonth').val($full_start_month);
                    $('#PropertyUserCheckinYear').val($full_start_year);
                    $('#PropertyUserCheckoutDay').val($temp_date);
                    $('#PropertyUserCheckoutMonth').val($temp_month);
                    $('#PropertyUserCheckoutYear').val($temp_year);
                    $('.js-price-for-product').productCalculation();
					viewCalenderReselect();
                }
            } else {
                $full_current_week = parseInt($this.metadata().week);
				if ($full_start_week >= $full_current_week) {
                    for (i = $full_start_week; i >= $full_current_week; i -- ) {
                        if ($('.guest-week-' + i).metadata().status != 'available') {
							$full_current_week = i+1;
						}
					}
				}
				else if ($full_start_week < $full_current_week) {
                    for (i = $full_start_week; i <= $full_current_week; i ++ ) {
                        if ($('.guest-week-' + i).metadata().status != 'available') {
							$full_current_week = i-1;
						}
					}
				}
                if ($full_start_week >= $full_current_week) {
                    for (i = $full_start_week; i >= $full_current_week; i -- ) {
                        if ($('.guest-week-' + i).metadata().status == 'available') {
                            $('#guest-week-' + i).addClass('js-guest-current-select-week');
                            first_date = ($this.metadata().end_date).split('-');
                            $full_end_month = parseInt(first_date[1]);
                            $full_end_date = parseInt(first_date[2]);
                            $full_end_year = parseInt(first_date[0]);
                        } else {
                            if ($full_start_week != '' && $full_current_week != '') {

								$(".js-guest-start-week").removeClass('js-guest-start-week');

                                if ($full_start_week < $full_current_week) {
                                    first_date = ($('.guest-week-' + $full_start_week).metadata().start_date).split('-');
                                    $full_start_month = parseInt(first_date[1], 10);
                                    $full_start_date = parseInt(first_date[2], 10);
                                    $full_start_year = parseInt(first_date[0]);
                                    second_date = ($('.guest-week-' + $full_current_week).metadata().end_date).split('-');
                                    $full_end_month = parseInt(second_date[1], 10);
                                    $full_end_date = parseInt(second_date[2], 10);
                                    $full_end_year = parseInt(second_date[0]);
                                } else {
                                    second_date = ($('.guest-week-' + $full_current_week).metadata().start_date).split('-');
                                    first_date = ($('.guest-week-' + $full_start_week).metadata().end_date).split('-');
                                    $full_start_month = parseInt(first_date[1], 10);
                                    $full_start_date = parseInt(first_date[2], 10);
                                    $full_start_year = parseInt(first_date[0]);
                                    $full_end_month = parseInt(second_date[1], 10);
                                    $full_end_date = parseInt(second_date[2], 10);
                                    $full_end_year = parseInt(second_date[0]);
                                }
                                $full_start_month = ($full_start_month < 10) ? ('0' + $full_start_month): $full_start_month;
                                $full_end_month = ($full_end_month < 10) ? ('0' + $full_end_month): $full_end_month;
                                $full_end_date = ($full_end_date < 10) ? ('0' + $full_end_date): $full_end_date;
                                $full_start_date = ($full_start_date < 10) ? ('0' + $full_start_date): $full_start_date;

                                if ($full_start_week <= $full_current_week) {
                                    $('#PropertyUserCheckinDay').val($full_start_date);
                                    $('#PropertyUserCheckinMonth').val($full_start_month);
                                    $('#PropertyUserCheckinYear').val($full_start_year);
                                    $('#PropertyUserCheckoutDay').val($full_end_date);
                                    $('#PropertyUserCheckoutMonth').val($full_end_month);
                                    $('#PropertyUserCheckoutYear').val($full_end_year);
                                } else {
                                    $('#PropertyUserCheckoutDay').val($full_start_date);
                                    $('#PropertyUserCheckoutMonth').val($full_start_month);
                                    $('#PropertyUserCheckoutYear').val($full_start_year);
                                    $('#PropertyUserCheckinDay').val($full_end_date);
                                    $('#PropertyUserCheckinMonth').val($full_end_month);
                                    $('#PropertyUserCheckinYear').val($full_end_year);
                                }
								viewCalenderReselect();
                                $('.js-price-for-product').productCalculation();
                                $full_start_date = $full_start_month = $full_start_year = $full_end_date = $full_end_month = $full_end_year = $full_start_week = $full_current_week = '';
                                $full_start = false;
								$.colorbox.close();
                            }
                            return false;
                        }
                    }
                } else if ($full_start_week < $full_current_week) {
                    for (i = $full_start_week; i <= $full_current_week; i ++ ) {
                        if ($('.guest-week-' + i).metadata().status == 'available') {
                            $('#guest-week-' + i).addClass('js-guest-current-select-week');
                            first_date = ($('.guest-week-' + i).metadata().end_date).split('-');
                            $full_end_month = parseInt(first_date[1]);
                            $full_end_date = parseInt(first_date[2]);
                            $full_end_year = parseInt(first_date[0]);
                        } else {
                            if ($full_start_week != '' && $full_current_week != '') {
								$(".js-guest-start-week").removeClass('js-guest-start-week');
                                if ($full_start_week <= $full_current_week) {
                                    first_date = ($('.guest-week-' + $full_start_week).metadata().start_date).split('-');
                                    $full_start_month = parseInt(first_date[1], 10);
                                    $full_start_date = parseInt(first_date[2], 10);
                                    $full_start_year = parseInt(first_date[0]);
                                    second_date = ($('.guest-week-' + $full_current_week).metadata().end_date).split('-');
                                    $full_end_month = parseInt(second_date[1], 10);
                                    $full_end_date = parseInt(second_date[2], 10);
                                    $full_end_year = parseInt(second_date[0]);
                                } else {
                                    second_date = ($('.guest-week-' + $full_current_week).metadata().start_date).split('-');
                                    first_date = ($('.guest-week-' + $full_start_week).metadata().end_date).split('-');
                                    $full_start_month = parseInt(first_date[1], 10);
                                    $full_start_date = parseInt(first_date[2], 10);
                                    $full_start_year = parseInt(first_date[0]);
                                    $full_end_month = parseInt(second_date[1], 10);
                                    $full_end_date = parseInt(second_date[2], 10);
                                    $full_end_year = parseInt(second_date[0]);
                                }
                                $full_start_month = ($full_start_month < 10) ? ('0' + $full_start_month): $full_start_month;
                                $full_end_month = ($full_end_month < 10) ? ('0' + $full_end_month): $full_end_month;
                                $full_end_date = ($full_end_date < 10) ? ('0' + $full_end_date): $full_end_date;
                                $full_start_date = ($full_start_date < 10) ? ('0' + $full_start_date): $full_start_date;
                                if ($full_start_week <= $full_current_week) {
                                    $('#PropertyUserCheckinDay').val($full_start_date);
                                    $('#PropertyUserCheckinMonth').val($full_start_month);
                                    $('#PropertyUserCheckinYear').val($full_start_year);
                                    $('#PropertyUserCheckoutDay').val($full_end_date);
                                    $('#PropertyUserCheckoutMonth').val($full_end_month);
                                    $('#PropertyUserCheckoutYear').val($full_end_year);
                                } else {
                                    $('#PropertyUserCheckoutDay').val($full_start_date);
                                    $('#PropertyUserCheckoutMonth').val($full_start_month);
                                    $('#PropertyUserCheckoutYear').val($full_start_year);
                                    $('#PropertyUserCheckinDay').val($full_end_date);
                                    $('#PropertyUserCheckinMonth').val($full_end_month);
                                    $('#PropertyUserCheckinYear').val($full_end_year);
                                }
								viewCalenderReselect();
                                $('.js-price-for-product').productCalculation();
                                $full_start_date = $full_start_month = $full_start_year = $full_end_date = $full_end_month = $full_end_year = $full_start_week = $full_current_week = '';
                                $full_start = false;
								$.colorbox.close();
                            }
                            return false;
                        }
                    }
                }
                if ($full_start_week != '' && $full_current_week != '') {
					$(".js-guest-start-week").removeClass('js-guest-start-week');
                    if ($full_start_week <= $full_current_week) {
                        first_date = ($('.guest-week-' + $full_start_week).metadata().start_date).split('-');
                        $full_start_month = parseInt(first_date[1], 10);
                        $full_start_date = parseInt(first_date[2], 10);
                        $full_start_year = parseInt(first_date[0]);
                        second_date = ($('.guest-week-' + $full_current_week).metadata().end_date).split('-');
                        $full_end_month = parseInt(second_date[1], 10);
                        $full_end_date = parseInt(second_date[2], 10);
                        $full_end_year = parseInt(second_date[0]);
                    } else {
                        second_date = ($('.guest-week-' + $full_current_week).metadata().start_date).split('-');
                        first_date = ($('.guest-week-' + $full_start_week).metadata().end_date).split('-');
                        $full_start_month = parseInt(first_date[1], 10);
                        $full_start_date = parseInt(first_date[2], 10);
                        $full_start_year = parseInt(first_date[0]);
                        $full_end_month = parseInt(second_date[1], 10);
                        $full_end_date = parseInt(second_date[2], 10);
                        $full_end_year = parseInt(second_date[0]);
                    }
                    $full_start_month = ($full_start_month < 10) ? ('0' + $full_start_month): $full_start_month;
                    $full_end_month = ($full_end_month < 10) ? ('0' + $full_end_month): $full_end_month;
                    $full_end_date = ($full_end_date < 10) ? ('0' + $full_end_date): $full_end_date;
                    $full_start_date = ($full_start_date < 10) ? ('0' + $full_start_date): $full_start_date;
                    if ($full_start_week <= $full_current_week) {
                        $('#PropertyUserCheckinDay').val($full_start_date);
                        $('#PropertyUserCheckinMonth').val($full_start_month);
                        $('#PropertyUserCheckinYear').val($full_start_year);
                        $('#PropertyUserCheckoutDay').val($full_end_date);
                        $('#PropertyUserCheckoutMonth').val($full_end_month);
                        $('#PropertyUserCheckoutYear').val($full_end_year);
                    } else {
                        $('#PropertyUserCheckoutDay').val($full_start_date);
                        $('#PropertyUserCheckoutMonth').val($full_start_month);
                        $('#PropertyUserCheckoutYear').val($full_start_year);
                        $('#PropertyUserCheckinDay').val($full_end_date);
                        $('#PropertyUserCheckinMonth').val($full_end_month);
                        $('#PropertyUserCheckinYear').val($full_end_year);
                    }
					viewCalenderReselect();
                    $('.js-price-for-product').productCalculation();
                    $full_start_date = $full_start_month = $full_start_year = $full_end_date = $full_end_month = $full_end_year = $full_start_week = $full_current_week = '';
                    $full_start = false;
					$.colorbox.close();
                }
            }
        } else {
            alert('Please select per week option');
        }
        return false;
    });

});