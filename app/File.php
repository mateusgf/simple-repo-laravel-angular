<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'filename', 'mime'];


    /**
     * Get the owner application.
     */
    public function application()
    {
        return $this->belongsTo('App\Application', 'application_id');
    }


    /**
     * Get the owner version.
     */
    public function version()
    {
        return $this->belongsTo('App\ApplicationVersion', 'application_version_id');
    }
}
