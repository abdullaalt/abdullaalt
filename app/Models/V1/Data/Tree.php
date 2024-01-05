<?php
namespace App\Models\V1\Data;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationsController;

class Tree extends Model{
	
	public $timestamps = false;
	
	protected $fillable = ['title', 'parent_id', 'photo', 'cover'];

}