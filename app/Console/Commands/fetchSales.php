<?php

namespace App\Console\Commands;

use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\ReportsController;
use Carbon\Carbon;
use Illuminate\Console\Command;

class fetchSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:fetchSales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Sales hourly Basis';

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
        $report = new ProductController();
        $report->fetchSalesWithItems('http://182.184.82.123/wecare-branch/');
        $this->info('Sale Fetch Successfully: '. Carbon::now()->format('d-m-Y h:i:s'));
    }
}
