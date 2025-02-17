<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    private $current = 0;

    public function model(array $row)
    {
        $this->current++;
        if ($this->current > 1) {
            return new \App\Models\Product([
                'name' => $row[1],
                'description' => $row[2],
                'price' => $row[3],
                'stock' => $row[4],
                'sku' => $row[5],
                'category_id' => $row[6],
            ]);
        }
    }
}
