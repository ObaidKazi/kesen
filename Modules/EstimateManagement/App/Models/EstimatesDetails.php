<?php

namespace Modules\EstimateManagement\App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ClientManagement\App\Models\Client;
use Modules\ClientManagement\App\Models\ContactPerson;
use Modules\EstimateManagement\Database\factories\EstimatesFactory;
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

}
