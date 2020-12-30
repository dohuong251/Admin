<?php

namespace App\Console\Commands;

use App\Models\Lsp\Songs;
use App\Models\Lsp\Views;
use Illuminate\Console\Command;

class DeleteStatisc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:song';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $songIds = Views::pluck('SongId')->toArray();
        $deleteSongId = array();
        if($songIds){
            foreach ($songIds as $songId){
                if(Songs::find($songId)){}
                else {
                    $deleteSongId[] = $songId;
                }
            }
            //echo "tìm thấy " . count($deleteSongId) . "\n";
            // Xoa songId trong bang views
            $deleted = Views::destroy($deleteSongId);
            echo "Đã xóa " . $deleted ;
        }
    }
}
