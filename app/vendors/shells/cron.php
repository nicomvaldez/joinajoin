<?php
/**
 *
 * @version $Id: cron.php 1227 2011-04-25 13:34:32Z boopathi_026ac09 $
 * @copyright 2009
 */
class CronShell extends Shell
{
    function main()
    {
		// site settings are set in config
        App::import('Model', 'Setting');
        $setting_model_obj = new Setting();
        $settings = $setting_model_obj->getKeyValuePairs();
        Configure::write($settings);

		//currency settings
		// write currency in cache
		$_currencies = Cache::read('site_currencies');
        if(empty($_currencies)) {
            App::import('Model', 'Currency');
            $this->Currency = new Currency();
			$_currencies = $this->Currency->cacheCurrency();                        
            Cache::write('site_currencies', $_currencies);
        }
		$GLOBALS['currencies'] = Cache::read('site.currencies');
		$currency_code = Configure::read('site.currency_id');
		Configure::write('site.currency', $GLOBALS['currencies'][$currency_code]['Currency']['symbol']);

		// include cron component
        App::import('Core', 'ComponentCollection');
		$collection = new ComponentCollection();
		App::import('Component', 'Cron');
		$this->Cron = new CronComponent($collection);
        $option = !empty($this->args[0]) ? $this->args[0] : '';
        $this->log('Cron started without any issue');
        if (!empty($option) && $option == 'main') {
            $this->Cron->main();
        } elseif (!empty($option) && $option == 'clear_permanent_cache') {
            $this->Cron->clear_permanent_cache();
        } elseif (!empty($option) && $option == 'currency_conversion') {
			$this->Cron->currency_conversion(Configure::read('site.is_auto_currency_updation'));
		}
    }
}
?>