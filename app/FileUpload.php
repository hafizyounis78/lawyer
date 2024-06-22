<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    protected $appends=['type_desc','file_loc'];
    public function fileType()
    {
        return $this->belongsTo(UploadFileType::class,'file_type','id');
    }
    public function fileLocation()
    {
        return $this->belongsTo(FileLocation::class,'file_location','id');
    }
    public function getTypeDescAttribute($key)
    {
        $rec=$this->fileType()->first();
        if(isset($rec))
            return $rec->desc;
        return $this->file_type;
    }
    public function getFileLocAttribute($key)
    {
        $rec=$this->fileLocation()->first();
        if(isset($rec))
            return $rec->desc;
        return $this->file_type;
    }
}
