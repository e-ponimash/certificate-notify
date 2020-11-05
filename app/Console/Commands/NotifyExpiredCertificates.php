<?php

namespace App\Console\Commands;

use App\Certificate;
use App\Mail\ExpiredCertificate;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Console\Output\OutputInterface;

class NotifyExpiredCertificates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:notify_expired_certificates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify Expired Certificates';

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
        $this->info('Start certificate notify');
        $certificates = Certificate::whereNull('notified_at')
            ->where('expired_at', '<=', Carbon::now()->addDays(env('NOTIFY_CERT_DAYS_BEFORE', 7)))->get();
        $proceed = 0;

        $certificates->each(function($cert) use (&$proceed){
            try{
                $this->info('Sending notification about expired certificate '.$cert, OutputInterface::VERBOSITY_VERBOSE);
                Mail::send(new ExpiredCertificate($cert));

                $cert->notified_at = Carbon::now();
                $cert->save();

                $proceed = $proceed +1;
            }  catch (\Exception $exception){
                Log::error("NotifyExpiredCertificates error:\n".$exception->getMessage());
            }
        });

        $this->info(sprintf('Notified %d of %d certificates', $proceed, $certificates->count()) );
    }
}
