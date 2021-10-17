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

    public function card()
    {
        $HTML =  '<a href="' .route('item.show', ( ( (  ( (  ($this->id*3)  +6)  *3)  +7) *13) +6)* 124) . '" >
        <div class="Item '; 
        if($this->status==0) {
            $HTML.= " bg-red ";
        }elseif($this->quantity==0){
                $HTML .=" inactive ";
            }
        
            $HTML.= '">
          <div class="cardName" > '. $this->name  .'</div>
            <div class="cardSize">';
              if(count($this->photos) > 0){
               $HTML.= ' <img class="cardImage" src="'.asset("/images/items/small/".$this->photos[0]->name).'" alt="">'; 
              }else{
                $HTML.= ' <img class="cardImage" src="'.asset("/images/icons/defaultPlaceholder.png").'" alt=""> ';
               }
               $HTML.= ' </div>';
            if($this->discount > 0){
                $HTML.= ' <div class="itemPrice">'.$this->price.'€';
                $HTML.= ' <div  class="itemDis">'.$this->discountPrice() .'</div>';
            }else{
                $HTML.= ' <div class="itemPriceFull">'.$this->price.'€';
            }
            $HTML.= ' </div>';
            $HTML.= '<div class="manufacturer">Gamintojas: '.$this->manufacturer.'</div>';
            $HTML.= ' <div class="quantity">Prekės likutis: '.$this->quantity.'</div>';
            $HTML.= '<object><a class="toCart"  '.($this->status==0 ||$this->quantity==0)?"avoid-clicks":"".'  class="btn btn-danger" href="">Į krepšelį</a> </object>';
           
            $HTML.= '  <a href="javascript:void(0)/'.$this->id.'" value="20"> <div class="heart"></div></a>
          </div>
      </a> ';
      return $HTML;
    }
}
