<?php

namespace App\Console\Commands;

use App\Services\Academic\StudentService;
use App\Services\Accounting\ProgramPaymentService;
use Illuminate\Console\Command;

class CheckPaymentsCommand extends Command
{

    protected $signature = 'app:check-payments-command';

    protected $description = 'Command description';

    public function handle()
    {
        $students = StudentService::getAll();
        foreach ($students as $student) {
            $hasDebt = ProgramPaymentService::hasDebt($student->id);
            if ($hasDebt) {
                $student->tiene_deuda = true;
                $student->save();
            } else {
                $student->tiene_deuda = false;
                $student->save();
            }
        }
    }
}
