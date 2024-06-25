<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    use HasFactory;
    protected $fillable = ['option_type_id', 'value'];

    public function optionType()
    {
        return $this->belongsTo(OptionType::class);
    }
}
