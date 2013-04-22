<?php
/**
 * Setting Model
 *
 * Site settings.
 *
 */
class Setting extends AppModel
{
    var $validate = array();
    public $belongsTo = array(
        'SettingCategory' => array(
            'className' => 'SettingCategory',
            'foreignKey' => 'setting_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    /**
     * Find all settings of given type and transform them to key => value array
     *
     * @param string $type
     * @return array
     *
     * @TODO cache settings
     */
    function getKeyValuePairs() 
    {
        $settings = $this->find('list', array(
			'fields' => array(
				'Setting.name',
				'Setting.value',
			)
		));
        return $settings;
    }
}
