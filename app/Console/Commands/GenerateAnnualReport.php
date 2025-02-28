<?php

namespace App\Console\Commands;

use App\Jobs\CalculateAnnualReportJob;
use DateTime;
use Illuminate\Console\Command;

class GenerateAnnualReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:annual {userId} {startDate} {endDate} {categories?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate annual user spend report';

    /**
     * Execute the console command.
     * @throws \DateMalformedStringException
     */
    public function handle()
    {
        $userId = $this->argument('userId');
        $startDate = new DateTime($this->argument('startDate'));
        $endDate = new DateTime($this->argument('endDate'));
        $categories = $this->argument('categories') ? explode(',', $this->argument('categories')) : null;

        $job = new CalculateAnnualReportJob($userId, $startDate, $endDate, $categories);
        $job->handle(app('\App\Services\ProfitReportService'));

        $this->info('Annual report job dispatched successfully.');
    }
}
