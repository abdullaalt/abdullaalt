<?php
namespace App\Models\V1\Data;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationsController;

class Link extends Model{
	
	public $timestamps = true;
	
	protected $fillable = ['target_id', 'f_id', 'm_id', 'tree_id', 'level', 'teip', 'is_approved', 'gargalo'];

    protected $primaryKey = 'target_id';

    //protected $table = 'data';

    public static function getNode($node_id){
        return self::find($node_id);
    }

    public static function getNodeFather($node_id){
        return self::find($node_id);
    }

    public static function getChilds($node_id){
        return self::where('links.f_id', $node_id)
                ->orWhere('links.m_id', $node_id)
                ->leftJoin('data as d', 'd.id', '=', 'links.target_id')
                ->select('d.*', 'links.*')
                ->get();
    }

    public static function getSiblings($f_id, $m_id){

        if (!$f_id && !$m_id){
            return [];
        }

        $descriptor = self::leftJoin('data as d', 'd.id', '=', 'links.target_id')
                            ->select('d.*', 'links.*');
        
        if ($f_id){
            $descriptor->where(function($q) use($f_id){
                $q->where('f_id', $f_id)
                  ->whereNotNull('f_id');
            });
        }

        if ($m_id){
            $descriptor->orWhere(function($q) use($m_id){
                $q->where('m_id', $m_id)
                  ->whereNotNull('m_id');
            });
        }
        
        return $descriptor->get();
    }

}