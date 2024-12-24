<?php

namespace App\Imports;

use App\Models\BulkData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class BulkDataImport implements ToModel, WithChunkReading, ShouldQueue, WithBatchInserts
{
    public function model(array $row)
    {
        return new BulkData([
            'name' => $row[1], // Assuming 'name' is in the second column
            'email' => $row[2], // Assuming 'email' is in the third column
        ]);
    }

    public function batchSize(): int
    {
        return 10000; // This will batch inserts in groups of 1000 rows
    }

    public function chunkSize(): int
    {
        return 10000; // This will process 1000 rows at a time
    }
}
