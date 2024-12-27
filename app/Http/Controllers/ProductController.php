<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use Illuminate\Support\Facades\Log;
use Yoeunes\Toastr\Facades\Toastr;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductController extends Controller
{
    public function importPage()
    {
        $products = Product::paginate(100); 
        return view('products.import', compact('products'));
    }

    public function product(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            $file = $request->file('file');

            ini_set('memory_limit', '2048M');
            set_time_limit(0);

            Excel::queueImport(new ProductImport, $file);

            Log::info('Product import job dispatched successfully.');
            Toastr::success('Import process completed successfully.');
            return redirect()->route('products.import.page');
        } catch (\Throwable $th) {
            Log::error('Product import error: ' . $th->getMessage());
            return redirect()->route('products.import.page')->with('error', 'Error during import: ' . $th->getMessage());
        }
    }

    public function updateProducts(Request $request)
    {
        $request->validate([
            'update_file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            $file = $request->file('update_file');

            Excel::import(new class implements ToModel, WithHeadingRow {
                public function model(array $row)
            {
                $sku = trim($row['product_sku'] ?? '');
                $name = trim($row['product_name'] ?? '');

                // Store updates in batches
                if (!empty($sku)) {
                    Product::where('sku', $sku)->update(['name' => $name]);
                }

                if (!empty($name)) {
                    Product::where('name', $name)->update(['sku' => $sku]);
                }
            }
        }, $file);

        return redirect()->route('products.import.page')->with('success', 'Products updated successfully.');
        } catch (\Throwable $th) {
            Log::error('Update error: ' . $th->getMessage());
            return redirect()->route('products.import.page')->with('error', 'Error during update: ' . $th->getMessage());
        }
    }
}
