public function events(Request $request, EventsService $es){
				
		$events = $es->getEventsList($request);
		
		return $events;
		
		// if ($app_id){
							
			// if ($events){
				// $events = json_decode(json_encode($events), true);
				// foreach ($events as $key=>$event){//dd($event);
				
					// $person = $tree->getSourceItem($event['person_id']);
					// $person = json_decode(json_encode($person), true);
								
					// if (!$person){
						// continue;
					// }
								// $person = $person[$event['person_id']];
								// print_r($person);
					// $person_text = $tree->getActionText($event['action'], $person['pol']);
								
					// if ($event['action'] == 1 && $event['target_id']){
						// $target = $tree->getSourceItem($event['target_id']);
						// if (!$target){
							// continue;	
						// }
						// $target = json_decode(json_encode($target), true);
						// $target_text = $tree->getActionTargetText($target['pol']);
					// }
								
								// $teip = $tree->getTeip($person['teip']);
								// $teip = json_decode(json_encode($teip), true);
								// $events[$key]['teip_title'] = isset($teip['title']) ? $teip['title'] : '';
								// $events[$key]['teip_id'] = isset($teip['id']) ? (int)$teip['id'] : '';
								// $events[$key]['can_see_comments'] = $events[$key]['teip_id'] == $user->teip;

								// $events[$key]['id'] = (int)$events[$key]['id'];
								// $events[$key]['reminders_count'] = (int)$events[$key]['reminders_count'];
								// $events[$key]['views'] = (int)$events[$key]['views'];
								
								// $events[$key]['avatar'] = '';
								
								// /*$events[$key]['text_tokens'] = array(
								
									// array(
										// 'text'=>date('d.m.Y', strtotime($event['date'])).' '.$tree->getActionText($event['action'], $person['pol']),
										// 'node_id'=>null
									// ),
									// array(
										// 'text'=>$person['fio'],
										// 'node_id'=>(int)$person['id']
									// )
								
								// );
								
								// if ($event['action'] == 1 && $event['target_id']){
									// $events[$key]['text_tokens'] = array_merge($events[$key]['text_tokens'], array(
										// array(
											// 'text'=>$tree->getActionTargetText($target['pol']),
											// 'node_id'=>null
										// ),
										// array(
											// 'text'=>$target['fio'],
											// 'node_id'=>(int)$target['id']
										// )
									// ));
								// }*/
								
				
					// if ($events[$key]['action'] == 1){
						// $events[$key]['action'] = 'wedding';
					// }else if ($events[$key]['action'] == 2){
						// $events[$key]['action'] = 'funeral';
					// }else {
						// $events[$key]['action'] = 'birth';
					// }
					// unset($events[$key]['html']);
					// unset($events[$key]['person_id']);
					// unset($events[$key]['target_id']);
					// unset($events[$key]['genom']);
					// unset($events[$key]['adress']);
					// unset($events[$key]['comment']);
				
				// }
			// }else{
				// http_response_code(410);
				// $events = array('errors'=>array('Событий не найдено'));
			// }
			
			// return response()->json($events);
		// }
		
		// return $this->returnView('profile', [
			// 'user'=>$user,
			// 'profile'=>$user,
			// 'is_moderator'=>$user->is_admin || $user->is_moder,
			// 'action' => 'events',
			// 'items' => $events,
			// 'data' => false,
			// 'banners' => array(),
			// 'ov_title' => 'События',
			// 'overview'      => true,
			// 'content' => $tree,
			// 'mc' => DB::table('users_messages')->where('to_id', '=', Auth::id())->whereNull('is_deleted')->where('is_new', '=', 1)->count(),
            // 'backurl'      => '/wall'
			
		// ]);
		
	}