<?php
namespace App\Models\V1\Wall;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\NotificationsController;

class WallVar extends Model{
	
	public $timestamps = false;
	
	protected $fillable = ['post_id', 'title', 'votes'];

    public static function getPoll($source_id, $source='wall'){
        return self::where('post_id', $source_id)->where('source', $source)->get();
    }

    public static function addVar($item){
        self::create($item);
    }

    public static function deleteVar($id){
        if (self::where('id', $id)->exists())
        self::find($id)->delete();
    }

}