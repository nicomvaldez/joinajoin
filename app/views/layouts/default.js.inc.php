<?php
$js_inline = 'var cfg = ' . $this->Javascript->object($this->js_vars).';';
$js_files = array(
	'libs/jquery.js',
	'libs/jquery.lazyload.mini.js',
	'libs/jquery.form.js',
	'libs/jquery.blockUI.js',
	'libs/jquery.livequery.js',
	'libs/jquery.metadata.js',
	'libs/jquery.cookie.js',
	'libs/jquery.uploader.js',
	'libs/AC_RunActiveContent.js',
	'libs/jquery.fuploader.js',
	'libs/jquery-ui-1.8.12.custom.min.js',
	'libs/jquery.autogeocomplete.js',
	'libs/jquery.simplyCountable.js',
	'libs/jquery.corner.js',
	'libs/jquery.truncate-2.3.js',
	'libs/jquery.flash.js',
	'libs/jquery.colorbox.js',
	'libs/jquery.overlabel.js',
	'libs/jquery.easing.1.3.js',
	'libs/jquery.timers-1.2.js',
	'libs/jquery.galleryview-3.0.js',
	'libs/jquery.jtweet.js',
	'libs/jquery.ui.widget.js',
	'libs/wdCalendar_lang_US.js',
	'libs/datepicker_lang_US.js',
	'libs/jquery.calendar.js',
	'libs/selectToUISlider.jQuery.js',
	'libs/date.format.js',
	'libs/jquery.timepickr.js',
	'libs/jquery.datepick.js',
	'libs/jquery.cyclic-fade.js',
	'libs/jquery.datepick.ext.js',
	'libs/jquery.autogrowtextarea.js',
	'libs/jquery.tipsy.js',
	'libs/jquery-idleTimeout.js',
	//'libs/guest-calendar.js',
	'libs/guest-list-calendar.js',
	'libs/markerclusterer.js',
	'libs/jquery.tablednd_0_5.js',
	'libs/highcharts.js',
);
if ($this->request->params['controller'] == 'property_users' && $this->request->params['action'] == 'index' && $this->request->params['named']['type'] == 'myworks' && !empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'waiting_for_acceptance') {
	array_push($js_files, 'libs/jquery.datepicker');
}


if (IS_ENABLE_HTML5_HISTORY_API):
	array_push($js_files, 'libs/jquery.pjax.js');
endif;
?>