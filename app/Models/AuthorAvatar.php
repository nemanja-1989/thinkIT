<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorAvatar extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'author_id',
        'image_name',
        'org_filename',
    ];

    public function author() {
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }
}
