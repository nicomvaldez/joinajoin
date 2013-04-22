<?php

	function cantDeDias($chkin, $chkout){
		$segundos = strtotime($chkout) - strtotime($chkin);
		$diferencia_dias = intval($segundos/60/60/24);
		return $diferencia_dias;		
	}
	
	
		echo cantDeDias('2013-03-12', '2013-03-15');



?>