<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
    	'card_type',
    	'last_four',
    	'default',
    	'provider_id',
    ];

    public static function boot()
    {
    	parent::boot();

    	static::creating(function ($paymentMethod) {
    		if($paymentMethod->default) {
    			$paymentMethod->user->paymentMethods()->update([
    				'default' => false
    			]);
    		}
    	});
    }

    public function setDefaultAttribute($value)
    {
    	$this->attributes['default'] = ($value === 'true' || $value ? true : false);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

}
