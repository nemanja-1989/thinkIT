<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $dates = ['deleted_at'];

    public function author() {
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }

    public function scopeHasAllData($query)
    {
        $this->scopeSearchTitle($query);
        $this->scopeSearchBookNumber($query);
        $this->scopeSearchBookAuthor($query);
    }

    public function scopeSearchTitle($query)
    {
        if (\request()->get('search_title')) {
            $query->where('title', 'LIKE', '%' . \request()->get('search_title') . '%');
        }
    }

    public function scopeSearchBookNumber($query)
    {
        if (\request()->get('search_book_number')) {
            $query->where('book_number', 'LIKE', '%' . \request()->get('search_book_number') . '%');
        }
    }

    public function scopeSearchBookAuthor($query)
    {
        if (\request()->get('search_book_author')) {
            return $query->whereHas('author', function ($query) {
                return $query->where('author_id', \request()->get('search_book_author'));
            });
        }
    }
}
