<?php

namespace App\Exports;

use App\Models\InventarisationItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use App\Modules\Users\Models\UserWorkSalary;

class UserSalaryExport implements FromCollection, WithMapping, WithHeadings
{
    
    use Exportable;

    public function __construct(int $user_id, $start_date, $end_date)
    {
        $this->user_id = $user_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection() {
        return $this->salary_data->all();
    }

    public function headings(): array
    {
        return ["ხელფასის თარიღი", "პოზიცია", "ხელფასი", "ბონუსი", "ჯარიმა", "კომენტარი"];
    }

    public function map($salary): array
    {

    }
}
