<?php

namespace Modules\JobRegisterManagement\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ClientManagement\App\Models\Client;
use Modules\EstimateManagement\App\Models\Estimates;
use Modules\JobRegisterManagement\Database\factories\JobRegisterFactory;

class JobRegister extends Model
{
    use HasFactory,HasUuids;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];

    protected $table='job_register';

    public function estimate(){
        return $this->belongsTo(Estimates::class,'estimate_id');
    }

    public function client(){
        return $this->belongsTo(Client::class,'client_id');
    }

    public function handle_by(){
        return $this->belongsTo(User::class,'handled_by_id');
    }

    public function setLanguageIdAttribute($value){
        $this->attributes['language_id'] = json_encode($value);
    }
    
    // Accessor for getting language_id
    public function getLanguageIdAttribute($value){
        return json_decode($value, true) ?? [];
    }
}
