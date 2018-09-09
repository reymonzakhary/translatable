<?php

namespace Upon\Translatable\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model_class', 'model_id', 'key',
        'local', 'value'
    ];
}
