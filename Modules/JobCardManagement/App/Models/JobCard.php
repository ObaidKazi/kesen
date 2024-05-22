<?php

namespace Modules\JobCardManagement\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\JobCardManagement\Database\factories\JobCardFactory;

class JobCard extends Model
{
    use HasFactory,HasUuids;

    protected $guarded = [
        'id'
    ];

    public function handle_by(){
        return $this->belongsTo(User::class,'handled_by');
    }

}
