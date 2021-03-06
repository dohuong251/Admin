<?php

namespace App\Console\Commands;

use App\Models\Lsp\Songs;
use App\Models\Lsp\Views;
use Illuminate\Console\Command;
use phpDocumentor\Reflection\Types\Array_;

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
        $array = array("a"=>1,"b"=>2);
        unset($array["a"]);
        echo json_encode($array);
    }
}
