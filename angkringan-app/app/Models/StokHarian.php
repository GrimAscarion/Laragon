<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class StokHarian extends Model
{
    protected $table = 'stok_harian';
    protected $primaryKey = 'id_stok';
    public $timestamps = false;
    protected $guarded = [];
}