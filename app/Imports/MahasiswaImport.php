<?php

namespace App\Imports;

use App\Jurusan;
use App\MasterPanitiaMahasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;

class MahasiswaImport implements ToCollection , WithHeadingRow
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
              if (!isset($row['npm'])) {
                  return null;
              }
              $jurusan = Jurusan::selectRaw('id,name')
                ->where('name','LIKE',"%".$row['jurusan']."%")->first();

                if($row['jenis_kelamin'] == "Laki-Laki"){
                    $jenis_kelamin = "L";
                }else{
                    $jenis_kelamin = "P";
                }
                
                // dd($jurusan->id);
              MasterPanitiaMahasiswa::updateOrCreate([
                  'npm' => $row['npm'],
              ], [
                'npm' => $row['npm'],
                'name'     => $row['nama_lengkap'],
                'email' => $row['email'],
                'no_telp' => ($row['no_telp']) ? $row['no_telp'] : "-",
                'jenis_kelamin' => $jenis_kelamin,
                'alamat' => ($row['alamat']) ? $row['alamat'] : "",
                'angkatan' => $row['angkatan'],
                'jurusan_id' => ($jurusan) ? $jurusan->id : 1,
                'created_at' => now(),
                'updated_at' => now()
              ]);
          }
      }
}
