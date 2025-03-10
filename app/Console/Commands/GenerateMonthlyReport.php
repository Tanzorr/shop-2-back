<?php
//
//namespace App\Console\Commands;
//
//use Carbon\Carbon;
//use Illuminate\Console\Command;
//
//class GenerateMonthlyReport extends Command
//{
//    /**
//     * The name and signature of the console command.
//     *
//     * @var string
//     */
//    protected $signature = 'report:monthly {year} {month}';
//
//    /**
//     * The console command description.
//     *
//     * @var string
//     */
//    protected $description = 'Generates a financial report for the given month and year';
//
//    /**
//     * Execute the console command.
//     */
//    public function handle()
//    {
//        $year = $this->argument('year');
//        $month = $this->argument('month');
//
//        if (! checkdate($year, $month)) {
//            $this->error('Invalid date');
//
//            return;
//        }
//
//        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
//        $endDate = $startDate->copy()->endOfMonth();
//
//        $this->info("Generating monthly report for: $startDate->format('F Y')");
//
//        // run jobs
//
//        $this->info('Report generation started.');
//    }
//}
