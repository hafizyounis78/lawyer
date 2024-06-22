<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadFileType extends Model
{
    public function uploadFiles()
    {
        return $this->hasMany(FileUpload::class,'file_type','id');

    }
}
