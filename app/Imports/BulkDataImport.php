<?php

namespace App\Imports;

use App\Models\BulkData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class BulkDataImport implements ToModel, WithChunkReading, ShouldQueue, WithBatchInserts
{
    /**
     * Transform each row of data into a BulkData model.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Assume the first column is 'id', second is 'name', third is 'email'
        $id = $row[0]; // ID is assumed to be the first column
        $name = $row[1]; // Name is assumed to be the second column
        $email = $row[2]; // Email is assumed to be the third column

        // Check if record with this ID exists
        $bulkData = BulkData::find($id);

        if ($bulkData) {
            // If the record exists, update it
            $bulkData->update([
                'name' => $name,
                'email' => $email,
            ]);
            return null; // Return null because we don't want to create a new record here
        } else {
            // If the record does not exist, create a new one
            return new BulkData([
                'id' => $id,
                'name' => $name,
                'email' => $email,
            ]);
        }
    }

    /**
     * Define the batch size for batch insert.
     *
     * @return int
     */
    public function batchSize(): int
    {
        return 1000; 
    }

    /**
     * Define the chunk size for processing chunks of rows at a time.
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000; 
    }
}
