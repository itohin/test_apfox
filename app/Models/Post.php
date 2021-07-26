<?php

namespace App\Models;

use App\Events\PostCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::created(function ($post) {

            $employes = $post->company->employees()->get();
            $users = $post->company->users()->hasPostsNotifications()->get();
            foreach ($employes as $employee) {
                PostCreated::dispatch($post, 'employee', $employee->id);
            }
            foreach ($users as $user) {
                PostCreated::dispatch($post, 'user', $user->id);
            }
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
