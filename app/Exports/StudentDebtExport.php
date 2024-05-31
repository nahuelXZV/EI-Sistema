<?php

namespace App\Exports;

use App\Models\Student;
use App\Services\Accounting\ProgramPaymentService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class StudentDebtExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $hasdebt;

    public function __construct($hasdebt)
    {
        $this->hasdebt = $hasdebt;

    }

    public function view(): View
    {

        if($this->hasdebt){
            return view('exports.student-debt', [
                'students' => ProgramPaymentService::getAllByStudentWithPrograms(),
                'hasdebt' => $this->hasdebt
            ]);
        }else{
            return view('exports.student-debt', [
                'students' => Student::all(),
                'hasdebt' => $this->hasdebt
            ]);

        }
    }
}
