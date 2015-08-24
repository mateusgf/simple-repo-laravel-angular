<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationVersion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title'];


    /**
     * Get the owner application.
     */
    public function application()
    {
        return $this->belongsTo('App\Application', 'application_id');
    }
}
