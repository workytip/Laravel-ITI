<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute ;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    use Sluggable;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'image'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }


 /**
 * Get the user's first name.
 *
 * @return \Illuminate\Database\Eloquent\Casts\Attribute
 */
protected function createdAt(): Attribute
{
    return Attribute::make(
        get: fn ($value) => Carbon::create( $value)->format('Y/m/d'),
    );
}


}
