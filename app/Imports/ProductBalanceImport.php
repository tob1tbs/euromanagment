<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductCountLog;
use App\Modules\Products\Models\ProductCountLogItem;

use Validator;
use \Carbon\Carbon;

class ProductBalanceImport implements ToCollection
{

    public function collection(Collection $collection) {

        // Validator::make($collection->toArray(), [
        //      'id' => 'required',
        //      'name' => 'required',
        //      'count' => 'required',
        // ])->validate();  

        $ProductCountLog = new ProductCountLog();
        $ProductCountLog->user_id = 1;
        $ProductCountLog->method = 'Excel';
        $ProductCountLog->save();

        foreach ($collection as $item) {   

            $Product = new Product();
            $ProductData = $Product::find($item[0]);

            if($item[2] != $ProductData->count) {
                $ProductCountLogItem = new ProductCountLogItem();
                $ProductCountLogItem->product_id = $item[0];
                $ProductCountLogItem->value_old = $ProductData->count;
                $ProductCountLogItem->value_new = $item[2];
                $ProductCountLogItem->log_id = $ProductCountLog->id;
                $ProductCountLogItem->save();

                $ProductData->update([
                    'count' => $item[2],
                ]);
            }
            
        }
    }
}
