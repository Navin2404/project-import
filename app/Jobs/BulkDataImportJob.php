<?php

namespace App\Imports;

use App\Models\BulkData;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class BulkDataImport implements ToModel, WithHeadingRow, ShouldQueue
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
{
    $existingRecord = BulkData::where('email', $row[2])->first();
    if ($existingRecord) {
        $existingRecord->update(['name' => $row[1]]);
    } else {
        return new BulkData([
            'name' => $row[1],
            'email' => $row[2],
        ]);
    }
}
}