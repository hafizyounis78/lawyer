<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileLocation extends Model
{
    use SoftDeletes;

    public function uploadFiles()
    {
        return $this->hasMany(FileUpload::class,'file_location','id');

    }
}
