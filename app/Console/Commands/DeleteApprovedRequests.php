<?php

namespace App\Console\Commands;

use App\Models\FoodRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteApprovedRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'request:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to delete approved requests which are not collected on the date';

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
     * @return int
     */
    public function handle()
    {
        $foodRequests = FoodRequest::whereDate('created_at',date("Y-m-d", strtotime( '-1 days' ) ))->where('status','approved')->get();

        // foreach ($foodRequests as $foodRequest) {
        //     $foodRequest->delete();
        // }

        // $this->info('Deleted all approved requests');

        Log::info($foodRequests);
    }
}
