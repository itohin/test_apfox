<?php

namespace App\Models;

use App\Events\ProductCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::created(function ($product) {

            $employes = $product->company->employees()->get();
            $users = $product->company->users()->hasProductsNotifications()->get();
            foreach ($employes as $employee) {
                ProductCreated::dispatch($product, 'employee', $employee->id);
            }
            foreach ($users as $user) {
                ProductCreated::dispatch($product, 'user', $user->id);
            }
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
