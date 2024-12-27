<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class ProductImport implements ToModel, WithHeadingRow, ShouldQueue, WithChunkReading, WithBatchInserts
{
    public function model(array $row)
    {
        $sku = trim($row['product_sku'] ?? '');
        $name = trim($row['product_name'] ?? '');

        if (!empty($sku)) {
            Product::where('sku', $sku)->update(['name' => $name]);
        }

        if (!empty($name)) {
            Product::where('name', $name)->update(['sku' => $sku]);
        }
    }

    /**
     * Define the batch size for database insert operations.
     *
     * @return int
     */
    public function batchSize(): int
    {
        return 5000; // Insert 5000 records per batch
    }

    /**
     * Define the chunk size for reading the Excel file.
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 5000; // Process 5000 rows per chunk
    }
}
