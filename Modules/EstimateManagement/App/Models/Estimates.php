<?php

namespace Modules\EstimateManagement\App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\EstimateManagement\Database\factories\EstimatesFactory;

class Estimates extends Model
{
   use HasFactory,HasUuids;

   protected $table="estimates";

   protected $guarded=['id'];

}
