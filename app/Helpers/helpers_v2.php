<?php

	function print_image_src_v2($arr, $size, $alt='', $default = 'upload/default/avatar_{#}.svg'){
		
		if (is_string($arr) && strpos($arr, 'storage/app')){
			return $arr;
		}
		
		if ($arr && !is_string($arr)) $arr = json_encode($arr);
	
		if (!empty(trim($arr))){//dd($arr);
			$images = json_decode($arr);
			
			if (is_object($images)){
				$images = (array)json_decode($arr);
			}
			if (isset($images[$size])){
				return '/storage/app/'.clearString($images[$size]);
			}else{
				return '/storage/app/'.clearString($arr);
			}
		}else{ 
			return '/storage/app/'.clearString(str_replace('{#}', $size, $default));
		}
		
	}

?>