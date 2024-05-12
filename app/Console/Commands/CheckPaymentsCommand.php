<?php

namespace App\Console\Commands;

use App\Models\ProgramPayment;
use App\Models\Student;
use App\Services\Academic\StudentService;
use App\Services\Accounting\ProgramPaymentService;
use Illuminate\Console\Command;

class CheckPaymentsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-payments-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $students = StudentService::getAll();
        dd($students);
        foreach ($students as $student) {
            $hasDebt = ProgramPaymentService::hasDebt($student->id);
            if ($hasDebt) {
                $student->tiene_deuda = true;
            } else {
                $student->tiene_deuda = false;
            }
            $student->save();
        }
    }
}
