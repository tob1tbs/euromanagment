<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

use App\Modules\Products\Models\Product;

class ProductBalanceExport implements FromQuery
{
    use Exportable;

    public function query() {
        return Product::query()->select('id', 'name_ge', 'count')->where('deleted_at_int', '!=', 0);
    }
}
