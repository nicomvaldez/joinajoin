<?php
/**
 * FindInSet - add set to show filter count in list
 *
 */
class FindInSetBehavior extends ModelBehavior
{
	function setup($model, $settings = array())
    {
		$default = array(
            'setModel' => array(),
            'setKey' => Inflector::tableize($model->alias) . '_set',
			'setField' => array()
        );
        if (!isset($this->__settings[$model->alias])) {
            $this->__settings[$model->alias] = $default;
        }
        $this->__settings[$model->alias] = array_merge($this->__settings[$model->alias], (is_array($settings) ? $settings : array()));
    }
    function afterSave($model, $created)
    {
		if ($created && !empty($this->__settings[$model->alias]['setModel'])) {
			$this->_updateSet($model);
		} elseif (!empty($this->__settings[$model->alias]['setField'])) {
			$this->_updateField($model);
		}
		return true;
    }
	function afterDelete($model)
    {
		if (!empty($this->__settings[$model->alias]['setModel'])) {
			$this->_updateSet($model);
		}
		return true;
    }
	function _updateSet($model)
	{
		$sets = $model->find('list');
		$set = '\'' . implode('\', \'', array_keys($sets)) . '\'';
		foreach($this->__settings[$model->alias]['setModel'] as $set_model) {
			$model->query('ALTER TABLE ' . Inflector::tableize($set_model) . ' CHANGE ' . $this->__settings[$model->alias]['setKey'] . ' ' . $this->__settings[$model->alias]['setKey'] . ' SET(' . $set . ') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL');
		}
	}
	function _updateField($model)
	{
		foreach($this->__settings[$model->alias]['setField'] as $set_field) {
			if (!empty($model->data[$set_field][$set_field])) {
				$model->updateAll(array(
					$model->alias . '.' . Inflector::tableize($set_field) . '_set' => "'" . implode(',', $model->data[$set_field][$set_field]) . "'"
				) , array(
					$model->alias . '.id' => !empty($model->data[$model->alias]['id']) ? $model->data[$model->alias]['id'] : $model->id
				));
			}
		}
	}
	function getFilterCount($model, $conditions)
	{
		if (!empty($this->__settings[$model->alias]['setField'])) {
			$set_fields_arr = array();
			foreach($this->__settings[$model->alias]['setField'] as $set_field) {
				$lists = $model->{$set_field}->find('list');
				$list_table = Inflector::tableize($set_field);
				foreach($lists as $list_id => $list) {
					$set_fields_arr[] = 'SUM(SIGN(FIND_IN_SET(' . $list_id . ', ' . $list_table . '_set))) as ' . $list_table . '_' . $list_id;
				}
			}
			if (!empty($set_fields_arr)) {
				$sets = $model->find('all', array(
					'conditions' => $conditions,
					'fields' => $set_fields_arr,
					'recursive' => -1
				));
			}
			return $sets[0][0];
		}
	}
}
?>