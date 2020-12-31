<?php

namespace App\Models\Lsp;

class CountryStatistic extends Base
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
