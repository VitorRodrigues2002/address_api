<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZipCode extends Model
{
    use HasFactory;

    protected $table = 'zip_codes';

    public function county()
    {
        return $this->belongsTo(County::class, 'county_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
