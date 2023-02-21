<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'author_id',
        'title',
        'description',
        'book_number',
    ];

    public function author() {
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }
}
