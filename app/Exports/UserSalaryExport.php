<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use App\Modules\Users\Models\UserWorkSalary;

use Carbon\Carbon

class UserSalaryExport implements FromQuery, WithHeadings
{
    
    use Exportable;

    public function __construct(int $user_id, $start_date, $end_date)
    {
        $this->user_id = $user_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function query()
    {
        
        $Array = [];

        $UserWorkSalary = new UserWorkSalary();
        $UserWorkSalaryData = $UserWorkSalary::where('user_id', $this->user_id)
                                            ->whereDate('date', '>=', $this->start_date)
                                            ->whereDate('date', '<=', $this->end_date)
                                            ->get();

        foreach ($$UserWorkSalaryData as $Item) {
            $Array[] = [
                'created_at' => Carbon::parse($Item->created_at)->format('Y-m-d');
            ];
        }
    }

    public function headings(): array
    {
        return ["ხელფასის თარიღი", "პოზიცია", "ხელფასი", "ბონუსი", "ჯარიმა", "კომენტარი"];
    }
}
