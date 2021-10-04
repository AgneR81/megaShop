<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    public function parameters()
    {
        return $this->belongsToMany(Parameter::class,'item_parameters')->withPivot(['data']);
    }
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
    public function discountPrice(){
        // round( $item->price - (),2 )
        return $this->round_up(  $this->price - ($this->price *  ($this->discount / 100) ),2  );
    }

    public function round_up ( $value, $precision ) { 
        $pow = pow ( 10, $precision ); 
        return ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow; 
    } 
}
