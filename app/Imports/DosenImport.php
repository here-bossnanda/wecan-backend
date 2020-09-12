<?php

namespace App\Imports;

use App\MasterPanitiaDosen;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;

class DosenImport implements ToCollection , WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
   
    public function collection(Collection $rows)
      {
          foreach ($rows as $row) {
              if (!isset($row['nip'])) {
                  return null;
              }
  
              MasterPanitiaDosen::updateOrCreate([
                  'nip' => $row['nip'],
              ], [
                'nip' => $row['nip'],
                'name'     => $row['nama_lengkap'],
                'email' => $row['email'],
                'no_telp' => $row['no_telp'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'alamat' => $row['alamat'],
                'jurusan_id' => $row['jurusan'],
                'created_at' => now(),
                'updated_at' => now()
              ]);
          }
      }
}
