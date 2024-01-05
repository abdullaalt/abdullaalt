<?php

	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Facades\Auth;
	use App\Http\Controllers\UserController;
	use App\Http\Controllers\MessagesController;
	use App\Http\Controllers\BehaviorController;
	use App\Http\Controllers\TreeController;
	use App\Http\Controllers\LangController;
	use App\Http\Controllers\PermissionsController;
	
	function getLangText($key){
		$lang = new LangController();
		return $lang->getLangText($key);
	}

	function clearString($str){

		$patterns = array();
		$patterns[] = '/\s?<script[^>]*?>.*?<\/script>\s?/si';
		$patterns[] = '/\s?script.*?\/script\s?/si';
		$patterns[] = '/expression\(document.write/si'; 
		$patterns[] = '/document.write/si';
		$patterns[] = '/document.cookie.escape/si';
		$patterns[] = '/document.cookie/si';

		$str = preg_replace($patterns, '', $str); 

		return $str;
	}
	
	function printUserProfileURL($user){
		
		$user_id = isset($user->user_id) ? $user->user_id : $user->id;
		
		return !empty($user->username) ? '/'.$user->username : '/wall/user/'.$user_id;
		
	}
	
	function print_image($arr, $size, $alt='', $default = '/storage/app/upload/default/avatar_{#}.png'){
		
		if (!empty(trim($arr))){//dd($arr);
			$images = json_decode($arr);
			
			if (is_object($images)){
				$images = (array)json_decode($arr);
			}
			if (isset($images[$size])){
				return '<img src="/storage/app/'.clearString($images[$size]).'" alt="'.$alt.'" />';
			}else{
				return '<img src="/storage/app/'.clearString($arr).'" alt="'.$alt.'" />';
			}
		}else{ 
			return '<img src="'.clearString(str_replace('{#}', $size, $default)).'" alt="'.$alt.'" />';
		}
		
	}
	
	function print_image_src($arr, $size, $alt='', $default = 'upload/default/avatar_{#}.svg', $path = '/storage/app/'){

		if (!$arr){
			return null;
		}

		$images = is_string($arr) ? json_decode($arr) : $arr;

		return $path.clearString($images->{$size});
		
	}

	function print_images_src($arr, $alt='', $default = 'upload/default/avatar_{#}.svg', $path = '/storage/app/'){

		if (!$arr){
			return false;
		}

		$images = json_decode($arr);

		$result = [];

		foreach ($images as $key => $image) {
			$result[$key] = $path.$image;
		}

		return $result;
		
	}
	
	function fileMimeType($arr, $size){
		
		if (!empty($arr)){
			if (!is_object($arr)){
				$files = (array)json_decode($arr);
			}else{
				$files = $arr;
			}
			
			if (is_object($files)){
				$files = (array)($files);
				$file = $files[$size];
				
				$way = storage_path('app/'.$file); 
				
				$mime = @mime_content_type($way);
				$type = explode('/', $mime);
				return $type;
			}else{
				$way = '/storage/app/'.$arr; 
				$mime = mime_content_type($_SERVER['DOCUMENT_ROOT'].$way);
				$type = explode('/', $mime);
				return $type;
			}
		}else{
			return [0=>'image'];
		}
		
	}
	
	function getUserNewMessagesCount(){
		$mc = new MessagesController();
		return $mc->getNewMessagesCount();
	}
	
	function getUserMenu($user_id){
		
		$items = [
			'admins' => ['wall', 'events', 'chats', 'noifications', 'teips', 'gargalo', 'map', 'dictionary', 'confirmation-requests', 'regqueries'],
			'newbies' => ['wall', 'events', 'chats', 'noifications', 'teips', 'gargalo', 'map', 'dictionary', 'confirmation-requests', 'regqueries']
		];
		
		$exclude = [
			'community' => ['teips', 'gargalo', 'events']
		];
		
	}
	
	function haveItemInUserMenu($user_id, $action){
		$exclude = [
			'community' => ['teips', 'gargalo', 'events'],
			'guests' => ['profile', 'gargalo', 'events']
		];
		
		$user_controller = new UserController();
		
		$group = $user_controller->getUserGroup($user_id);
		
		if (!isset($exclude[$group->name])) return true;
		
		return in_array($action, $exclude[$group->name]) ? false : true;
		
	}
	
	function getParentFio($parent){
		if ($parent>0){
			return DB::table('data')->where('id', $parent)->value('fio');
		}else{
			return '';
		}
	}
	
	function getTrendItems(){
		
		$behavior = new BehaviorController();
		$items = $behavior->getTrendItems();
		
		return $items;
		
	}
	
	function getHashtags($string) {  
		$hashtags= FALSE;  
		preg_match_all("/(#\w+)/u", $string, $matches);  
		if ($matches) {
			$hashtagsArray = array_count_values($matches[0]);
			$hashtags = array_keys($hashtagsArray);
		}
		return $hashtags;
	}
	
	function replaceHashtags($text, $hashtags){
		if ($hashtags){
			foreach ($hashtags as $hashtag){
				$text = str_replace($hashtag, '<a href="/wall/tag/'.str_replace('#', '', $hashtag).'">'.$hashtag.'</a>', $text);
			}
		}
		
		return $text;
		
	}
	
	function registerBehavior($action, $item){
		
		$behavior = new BehaviorController();
		
		$behavior->registerBehavior($action, $item);
		
	}
	
	function orderBy(array &$array, $sortOrder){
		usort($array, function ($a, $b) use ($sortOrder) {
			$result = '';

			$sortOrderArray = explode(',', $sortOrder);
			foreach ($sortOrderArray AS $item) {
				$itemArray = explode(' ', trim($item));
				$field = $itemArray[0];
				$sort = !empty($itemArray[1]) ? $itemArray[1] : '';

				$mix = [$a, $b];
				if (!isset($mix[0][$field]) || !isset($mix[1][$field])) {
					continue;
				}

				if (strtolower($sort) === 'desc') {
					$mix = array_reverse($mix);
				}

				if (is_numeric($mix[0][$field]) && is_numeric($mix[1][$field])) {
					$result .= ceil($mix[0][$field] - $mix[1][$field]);
				} else {
					$result .= strcasecmp($mix[0][$field], $mix[1][$field]);
				} 
			}

			return $result;
		});

		return $array;
	}
	
	function dt($date){
		return date('d.m.Y', strtotime($date));
	}
	
	function dtt($date){
		return date('d.m.Y H:i', strtotime($date));
	}

    function userPermissionForAction($user_id, $component){
        $permissions_controller = new PermissionsController();
        return $permissions_controller->userPermissionForAction($user_id, $component);
    }
	
	function getUserProfileButtons($profile){
		
		$user = Auth::user();
		
		$user_controller = new UserController();
		$group = $user_controller->getUserGroup($profile->id);
		$buttons = [];
		
		//$buttons[] = 'posts';
		
		/*if (Auth::check() && $group->name != 'newbies'){
			switch ($group->name){
				case 'moderators': $buttons[] = 'node_info'; break;				
				case 'admins': $buttons[] = 'node_info'; break;				
				case 'members': $buttons[] = 'node_info'; break;				
				case 'limited': $buttons[] = 'node_info'; break;				
				case 'community': $buttons[] = 'community_info'; break;				
				case 'org': $buttons[] = 'org_info'; break;			
			}
		}*/
		
		if (Auth::check() && $profile->tree_number > 0 && Auth::id() != $profile->id){
			$buttons[] = 'gargalo';
		}
		
		if ($user->is_real && $group->name !='limited'){
			if ($user->id != $profile->id){
				$buttons[] = 'chat';
			}
		}
		
		if ($user->is_real && $group->name !='limited'){
			if ($user->id != $profile->id){
				$buttons[] = 'follow';
			}
		}
		
		if (Auth::id() == $profile->id || (Auth::id() != $profile->id && ($user->is_admin || $user->is_moder))){
			$buttons[] = 'settings';
		}
		
		//dd($group);
		return $buttons;
		
	}
	
	function getNodeFamily($node_id){
		$tree = new TreeController();
		$family = $tree->getFamily($tree->getSourceItem($node_id, false), false);
		return $family;
	}
	
	function logArray($arr, $title){
		echo $title;
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}
	
	function isApp(){
		$headers = getallheaders();
		return isset($headers['User-Token']) || isset($headers['user-token']) || isset($headers['USER-TOKEN']);
	}
	
	/*function printGargaloBTN(){
		ob_start();
			include('buttons.gargalo');
		return ob_get_clean();
		
	}*/
	//АБВГДЕЖЗИКЛМНОПРСТУФХЦЧШЩ
	function NUMtoSTRING($NUMBER, $ALPHA = '0123456789aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ'){
		$ALPHA_LEN = mb_strlen($ALPHA, 'UTF-8');
		$STRNG = '';
		while($NUMBER > $ALPHA_LEN){
			$STRNG = mb_substr($ALPHA, $NUMBER % $ALPHA_LEN, 1, 'UTF-8') . $STRNG;
			$NUMBER = floor($NUMBER / $ALPHA_LEN);
		}
		$STRNG = mb_substr($ALPHA, $NUMBER, 1, 'UTF-8') . $STRNG;
		return $STRNG;
	}
	
	function STRINGtoNUM($STRNG, $ALPHA = '0123456789aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ'){
		$ALPHA_LEN = mb_strlen($ALPHA, 'UTF-8');
		$STRNG_LEN = mb_strlen($STRNG, 'UTF-8');
		$NUMBER = 0;
		for($S_i = 0; $S_i < $STRNG_LEN; $S_i++)
			$NUMBER += mb_strpos($ALPHA, mb_substr($STRNG, $S_i, 1, 'UTF-8'), 0, 'UTF-8') * pow($ALPHA_LEN, $STRNG_LEN - $S_i - 1);
		return $NUMBER;
	}
