<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Language;
use App\Models\Faculty;
use App\Models\Year;
use App\Models\UploadForm;
use App\Models\UploadFormCreator;
use App\Models\UploadFormDivision;
use App\Models\UploadFormType;
use App\Models\UploadFormSubject;
use App\Models\User;
use Illuminate\Support\Facades\DB;

// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;

class DepositExport implements FromView, ShouldAutoSize, WithEvents
{
    // use Exportable, RegistersEventListeners;
    protected $data;

    function __construct($data) {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('reports/DepositExcelReport', $this->data);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(40);
                $event->sheet->getDelegate()->getRowDimension('2')->setRowHeight(30);
                $event->sheet->getStyle('A1:I2')->getAlignment()->setVertical('center');
                $event->sheet->getStyle('A2:I2')->getAlignment()->setHorizontal('center');  
            },
        ];
    }
}
