<?php
    echo $this->requestAction( array('controller' => 'properties', 'action' => 'my_properties', 'property_id' => !empty($property_id) ? $property_id : ''), array('return'));
?>