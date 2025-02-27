<?php

namespace App\Http\Controllers;

use App\Imports\ProductImport;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Excel;


class ProductImportController extends Controller
{
    public function import(Request $request): void
    {
        Excel::import(new ProductImport, $request->file('file'));
    }
}
