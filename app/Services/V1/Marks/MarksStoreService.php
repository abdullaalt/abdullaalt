<?php
namespace App\Services\V1\Marks;

use Response;
use Errors;
use Notifications;

use App\Models\V1\Wall\WallMark;

class MarksStoreService extends MarksService{

    private $options;

    public function __construct($options){
        $this->options = $options;
    }

    public function addOption($property, $value){
        $this->options[$property] = $value;
    }

    public function addMarkedUsers($marks, $post_id, $send_notification = true){

        if (!$post_id){
            return false;
        }

        $item = [];
        $item['post_id'] = $post_id;
        $result = [];

        foreach ($marks as $key => $mark) {
            $mark = json_decode($mark);
            if ($mark && $mark !== null){
                foreach ($mark as $k => $m) {
                    $item['node_id'] = $m->node_id;
                    $item['user_id'] = $m->user_id;
                    $item['media_index'] = $key;
                    $item['left_pos'] = $m->left;
                    $item['top_pos'] = $m->top;
                    WallMark::addMark($item);
                    if ($send_notification){
                        if ($m->user_id){
                            $result[] = [
                                'user_id' => $m->user_id,
                                'title' => $this->options['title'],
                                'body' => $this->options['body'],
                                'action' => 'mark',
                                'source' => $this->options['source']
                            ];
                        }
                        
                    }
                }
            }
        }

        if ($send_notification){
            (new Notifications($result))->send();
        }

    }

    public function deleteMarksByIds($ids){
        foreach ($ids as $key => $value) {
            WallMark::deleteMark($value);
        }
    }

}