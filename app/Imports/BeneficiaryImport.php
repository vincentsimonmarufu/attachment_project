<?php

namespace App\Imports;

use App\Models\Beneficiary;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BeneficiaryImport implements ToCollection ,WithHeadingRow,WithBatchInserts
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            if(!empty($row['paynumber']) && !empty($row['first_name']) && !empty($row['last_name']) && !empty($row['id_number']))
            {
                $user = User::where('paynumber',$row['paynumber'])->first();

                if ($user)
                {
                    $beneficiary_exists = Beneficiary::where('id_number',$row['id_number'])->first();

                    if (!$beneficiary_exists)
                    {
                        $new_beneficiary = Beneficiary::create([
                            'first_name' => $row['first_name'],
                            'last_name' => $row['last_name'],
                            'id_number' => $row['id_number'],
                            'mobile_number' => $row['mobile_number'],
                            'pin' => $user->pin,
                            'user_id' => $user->id,
                        ]);

                        $new_beneficiary->save();
                    }
                }
            }
        }
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
