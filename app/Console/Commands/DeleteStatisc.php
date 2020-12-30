<?php

namespace App\Console\Commands;

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
        echo json_encode($songIds);
    }
}
