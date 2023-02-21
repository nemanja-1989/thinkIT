<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'surname',
    ];

    public function avatar() {
        return $this->hasOne(AuthorAvatar::class, 'author_id', 'id');
    }

    public function books() {
        return $this->hasOne(Book::class, 'author_id', 'id');
    }
}
