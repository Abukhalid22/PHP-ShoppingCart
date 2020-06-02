<?php


namespace Cart\Models;

use Illuminate\Database\Eloquent\Model;
use Cart\Models\Address;

class Address extends Model
{
   protected $fillable = [
       'address1',
       'address2',
       'city',
       'postal_code',
   ];


}
