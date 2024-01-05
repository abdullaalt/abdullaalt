<?php
namespace App\Services\V1\Wall;

use Response;
use Errors;

use App\Services\V1\Users\UserService;
use App\Services\V1\Data\FamilyService;
use App\Services\V1\Poll\PollsService;
use App\Services\V1\Files\DownloadService;
use App\Services\V1\Files\DeleteService;
//use App\Services\V1\Media\MediaService;
use App\Services\V1\Marks\MarksStoreService;

use App\Models\V1\Wall\Wall;
use App\Models\V1\Wall\Link;
use App\Models\V1\Wall\WallVar;
use App\Models\V1\Wall\WallMark;
use App\Models\V1\Wall\WallLike;

use App\Http\Resources\V1\Users\UserSimpleResource;

class WallStoreService extends WallPostService{

    private $loader;
    protected $poll;
    protected $marks_store;
    private $request;

    public function __construct(){
        $this->loader = new DownloadService();
        $this->poll = new PollsService();
        $this->marks_store = new MarksStoreService([
            'title' => Response::getLangValue('PICTURE_MARK_TITLE'),
            'body' => auth()->user()->nickname.Response::getLangValue('PICTURE_MARK_BODY')
        ]);
    }

    public function setRequest($request){
        $this->request = $request;
        return $this;
    }

    public function store(){
        $this->checkDataConditions(Wall::addPost($this->array()), 'POST_NOT_FOUND');
        return $this;
    }

    /*
        подготавливает основные данные для сохранения
        @return this
    */
    public function preparingData(){

        $this->addProperty('user_id', auth()->id());
        $this->addProperty('text', clearString($this->request->content));
        $this->addProperty('proportions', json_encode($this->request->proportions));
        $this->addProperty('permission',  $this->getPermissionString($this->request->permissions));

        return $this;
    }

    /*
        добавляет пост в БД попутно загружает медиа файлы
        также сохраняет голосование и отметки
        @return this
    */
    public function addPost(){ 
        
        $this->marks_store->addOption('source', auth()->id().':'.$this->get('id'));
        
        if ($this->request->file('medias')){
            $this->addProperty('media', json_encode($this->loader->store($this->request->file('medias'), '/wall/users/'.auth()->id())));
        }

        $this->store();

        if ($this->request->votes){
            $this->poll->addPoll($this->request->votes, $this->get('id'));
        }

        if ($this->request->marked_users){
            $this->marks_store->addMarkedUsers($this->request->marked_users, $this->get('id'));
        }

        $this->getPost($this->get('id'));
       
        return $this;
        
    }

    public function deletePostMedia(){

        if (!$this->request->has('media_deleted_indexes'))
            return $this;

        if ($this->response()->isFail())
            return $this;
        
            
        $medias = json_decode($this->get('media'));

        foreach ($this->request->media_deleted_indexes as $index){
            (new DeleteService())->delete($medias[$index]);
            unset($medias[$index]);
        }

        $this->addProperty('media', json_encode($medias));

        return $this;

    }

    public function editPost(){

        if ($this->request->has('media_deleted_indexes')){
            $this->deletePostMedia();
        }

        if ($this->request->file('medias')){
            $medias = array_merge(json_decode($this->get('media')), $this->loader->store($this->request->file('medias'), '/wall/users/'.auth()->id()));
            $this->addProperty('media', json_encode($medias));
        }

        if ($this->request->has('var_deleted_ids')){
            $this->poll->deleteVarsByIds($this->request->var_deleted_ids);
        }

        if ($this->request->has('marks_deleted_ids')){
            $this->marks_store->deleteMarksByIds($this->request->marks_deleted_ids);
        }

        if ($this->request->votes){
            $this->poll->addPoll($this->request->votes, $this->get('id'));
        }

        $this->marks_store->addOption('source', auth()->id().':'.$this->get('id'));
        
        if ($this->request->marked_users){
            $this->marks_store->addMarkedUsers($this->request->marked_users, $this->get('id'));
        }

        $this->saveData();

    }

}