<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportRule extends Model
{
    //
    use SoftDeletes;

    protected $table = 'report_rule';
    protected $primaryKey = 'id';
    protected $dates = ["checked_at"];
    protected $guarded = [];

    protected $casts = [
        'log' => 'array',
    ];

    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 1:
                return "Luật Hoạt Động Bình Thường";
            case 2:
                return "Lấy Được Link Nhưng Không Chơi Được";
            case 3:
                return "Không Lấy Được Link";
        }
    }
}
