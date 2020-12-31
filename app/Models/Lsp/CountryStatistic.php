<?php

namespace App\Models\Lsp;

use Illuminate\Database\Eloquent\Model;

class CountryStatistic extends Model
{
    protected $table = 'statistic_country';
    protected $primaryKey = 'Id';
    // Cast attributes JSON to array
    protected $casts = [
        'DayStatistic' => 'array',
        'LastDayStatistic' => 'array',
    ];

    public function song()
    {
        return $this->belongsTo('App\Models\Lsp\Songs', 'SongId');
    }
}
