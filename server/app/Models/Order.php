<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Order extends Model{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'event_id',
        'event_date',
        'barcode',
        'ticket_adult_price',
        'ticket_adult_quantity',
        'ticket_kid_price',
        'ticket_kid_quantity',
        'user_id',
        'equal_price',
        'created'
    ];


    public static function rules(){
        return [
            'event_id' => 'required|integer',
            'event_date' => 'required|date',
            'barcode' => 'required|string|unique:orders,barcode',
            'ticket_adult_price' => 'required|numeric',
            'ticket_adult_quantity' => 'required|integer',
            'ticket_kid_price' => 'required|numeric',
            'ticket_kid_quantity' => 'required|integer',
        ];
    }
}
