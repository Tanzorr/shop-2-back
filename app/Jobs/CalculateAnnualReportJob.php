<?php

namespace App\Jobs;

use App\Mail\AnnualReportMail;
use App\Models\User;
use App\Services\ProfitReportService;
use DateTime;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class CalculateAnnualReportJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private User $receiver,
        private DateTime $startDate,
        private DateTime $endDate,
        private ?array $categories = null
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(ProfitReportService $service): void
    {
        $report = $service->getAnnualUsersReport($this->receiver, $this->startDate, $this->endDate, $this->categories);

        Mail::to($this->receiver->email)->send(new AnnualReportMail($report));
    }
}
