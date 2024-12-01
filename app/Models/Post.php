<?php

namespace App\Models;

use App\Models\Catagory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $table = 'post';

    protected $fillable =[
        'id',
        'category_id',
        'post_name',
        'meta_title',
        'image',
        'Post_keywords',
        'post_content',
        'status'

    ];

    public function category(){

        return $this->belongsTo(Catagory::class,'category_id','id');
    }
}
