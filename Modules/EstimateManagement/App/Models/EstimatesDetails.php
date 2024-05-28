<?php

namespace Modules\EstimateManagement\App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ClientManagement\App\Models\Client;
use Modules\ClientManagement\App\Models\ContactPerson;
use Modules\EstimateManagement\Database\factories\EstimatesFactory;
use Modules\JobCardManagement\App\Models\JobCard;
use Modules\JobRegisterManagement\App\Models\JobRegister;
use Modules\LanguageManagement\App\Models\Language;

class EstimatesDetails extends Model
{
   use HasFactory,HasUuids;

   protected $table="estimate_details";

   protected $guarded=['id'];

   public function getLangAttribute(){

       $lang=Language::where('id',$this->attributes['lang'])->first();
       return $lang->name;
   }

   public function jobRegister()
    {
        return $this->belongsTo(JobRegister::class, 'estimate_document_id', 'document_name');
    }

    public function jobCard()
    {
        return $this->hasOne(JobCard::class, 'estimate_detail_id', 'id');
    }

}
