<?php
namespace App\Models\V1\Data;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationsController;

class Data extends Model{
	
	public $timestamps = false;
	
	protected $fillable = ['fio', 'born', 'die', 'pol', 'bio', 'teip', 'user_id', 'is_approved', 'add_user_id', 'moderator_id', 'avatar'];

    protected $table = 'data';

}