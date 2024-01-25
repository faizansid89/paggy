<?php

namespace App\Console\Commands;

use App\Http\Controllers\ReportsController;
use Carbon\Carbon;
use Illuminate\Console\Command;

class generateCostPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:generateCostPrice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Cost Price hourly Basis';

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
        $report = new ReportsController();
        $report->generateCostPrice();
        $this->info('Generate Cost Price Completed: '. Carbon::now()->format('d-m-Y h:i:s'));
    }
}
