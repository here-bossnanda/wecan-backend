<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_role')->delete();
        DB::table('permissions')->delete();
        
        DB::table('permissions')->insert(array(
            ['id'=>'1','nama' =>  'Data Divisi - Create',  'kategori' => 'Data Divisi','for' => 'Create','created_at' => now(),'updated_at' => now() ],
            ['id'=>'2','nama' =>  'Data Divisi - Read',  'kategori' => 'Data Divisi','for' => 'Read','created_at' => now(),'updated_at' => now() ],
            ['id'=>'3','nama' =>  'Data Divisi - Update',  'kategori' => 'Data Divisi','for' => 'Update','created_at' => now(),'updated_at' => now() ],
            ['id'=>'4','nama' =>  'Data Divisi - Delete',  'kategori' => 'Data Divisi','for' => 'Delete','created_at' => now(),'updated_at' => now() ],
            ['id'=>'5','nama' =>  'Data Divisi - CRUD',  'kategori' => 'Data Divisi','for' => 'CRUD','created_at' => now(),'updated_at' => now() ],
            ['id'=>'6','nama' =>  'Data Fakultas - Create',  'kategori' => 'Data Fakultas','for' => 'Create','created_at' => now(),'updated_at' => now() ],
            ['id'=>'7','nama' =>  'Data Fakultas - Read',  'kategori' => 'Data Fakultas','for' => 'Read','created_at' => now(),'updated_at' => now() ],
            ['id'=>'8','nama' =>  'Data Fakultas - Update',  'kategori' => 'Data Fakultas','for' => 'Update','created_at' => now(),'updated_at' => now() ],
            ['id'=>'9','nama' =>  'Data Fakultas - Delete',  'kategori' => 'Data Fakultas','for' => 'Delete','created_at' => now(),'updated_at' => now() ],
            ['id'=>'10','nama' =>  'Data Fakultas - CRUD',  'kategori' => 'Data Fakultas','for' => 'CRUD','created_at' => now(),'updated_at' => now() ],
            ['id'=>'11','nama' =>  'Data Jabatan - Create',  'kategori' => 'Data Jabatan','for' => 'Create','created_at' => now(),'updated_at' => now() ],
            ['id'=>'12','nama' =>  'Data Jabatan - Read',  'kategori' => 'Data Jabatan','for' => 'Read','created_at' => now(),'updated_at' => now() ],
            ['id'=>'13','nama' =>  'Data Jabatan - Update',  'kategori' => 'Data Jabatan','for' => 'Update','created_at' => now(),'updated_at' => now() ],
            ['id'=>'14','nama' =>  'Data Jabatan - Delete',  'kategori' => 'Data Jabatan','for' => 'Delete','created_at' => now(),'updated_at' => now() ],
            ['id'=>'15','nama' =>  'Data Jabatan - CRUD',  'kategori' => 'Data Jabatan','for' => 'CRUD','created_at' => now(),'updated_at' => now() ],
            ['id'=>'16','nama' =>  'Data Jurusan - Create',  'kategori' => 'Data Jurusan','for' => 'Create','created_at' => now(),'updated_at' => now() ],
            ['id'=>'17','nama' =>  'Data Jurusan - Read',  'kategori' => 'Data Jurusan','for' => 'Read','created_at' => now(),'updated_at' => now() ],
            ['id'=>'18','nama' =>  'Data Jurusan - Update',  'kategori' => 'Data Jurusan','for' => 'Update','created_at' => now(),'updated_at' => now() ],
            ['id'=>'19','nama' =>  'Data Jurusan - Delete',  'kategori' => 'Data Jurusan','for' => 'Delete','created_at' => now(),'updated_at' => now() ],
            ['id'=>'20','nama' =>  'Data Jurusan - CRUD',  'kategori' => 'Data Jurusan','for' => 'CRUD','created_at' => now(),'updated_at' => now() ],
            ['id'=>'21','nama' =>  'Aktivasi Wecan - Create',  'kategori' => 'Aktivasi Wecan','for' => 'Create','created_at' => now(),'updated_at' => now() ],
            ['id'=>'22','nama' =>  'Aktivasi Wecan - Read',  'kategori' => 'Aktivasi Wecan','for' => 'Read','created_at' => now(),'updated_at' => now() ],
            ['id'=>'23','nama' =>  'Aktivasi Wecan - Update',  'kategori' => 'Aktivasi Wecan','for' => 'Update','created_at' => now(),'updated_at' => now() ],
            ['id'=>'24','nama' =>  'Aktivasi Wecan - Delete',  'kategori' => 'Aktivasi Wecan','for' => 'Delete','created_at' => now(),'updated_at' => now() ],
            ['id'=>'25','nama' =>  'Aktivasi Wecan - CRUD',  'kategori' => 'Aktivasi Wecan','for' => 'CRUD','created_at' => now(),'updated_at' => now() ],
            ['id'=>'26','nama' =>  'Role Permission - Create',  'kategori' => 'Role Permission','for' => 'Create','created_at' => now(),'updated_at' => now() ],
            ['id'=>'27','nama' =>  'Role Permission - Read',  'kategori' => 'Role Permission','for' => 'Read','created_at' => now(),'updated_at' => now() ],
            ['id'=>'28','nama' =>  'Role Permission - Update',  'kategori' => 'Role Permission','for' => 'Update','created_at' => now(),'updated_at' => now() ],
            ['id'=>'29','nama' =>  'Role Permission - Delete',  'kategori' => 'Role Permission','for' => 'Delete','created_at' => now(),'updated_at' => now() ],
            ['id'=>'30','nama' =>  'Role Permission - CRUD',  'kategori' => 'Role Permission','for' => 'CRUD','created_at' => now(),'updated_at' => now() ],
            ['id'=>'31','nama' =>  'Users - Create',  'kategori' => 'Users','for' => 'Create','created_at' => now(),'updated_at' => now() ],
            ['id'=>'32','nama' =>  'Users - Read',  'kategori' => 'Users','for' => 'Read','created_at' => now(),'updated_at' => now() ],
            ['id'=>'33','nama' =>  'Users - Update',  'kategori' => 'Users','for' => 'Update','created_at' => now(),'updated_at' => now() ],
            ['id'=>'34','nama' =>  'Users - Delete',  'kategori' => 'Users','for' => 'Delete','created_at' => now(),'updated_at' => now() ],
            ['id'=>'35','nama' =>  'Users - CRUD',  'kategori' => 'Users','for' => 'CRUD','created_at' => now(),'updated_at' => now() ],
            ['id'=>'36','nama' =>  'Master Panitia Mahasiswa - Create',  'kategori' => 'Master Panitia Mahasiswa','for' => 'Create','created_at' => now(),'updated_at' => now() ],
            ['id'=>'37','nama' =>  'Master Panitia Mahasiswa - Read',  'kategori' => 'Master Panitia Mahasiswa','for' => 'Read','created_at' => now(),'updated_at' => now() ],
            ['id'=>'38','nama' =>  'Master Panitia Mahasiswa - Update',  'kategori' => 'Master Panitia Mahasiswa','for' => 'Update','created_at' => now(),'updated_at' => now() ],
            ['id'=>'39','nama' =>  'Master Panitia Mahasiswa - Delete',  'kategori' => 'Master Panitia Mahasiswa','for' => 'Delete','created_at' => now(),'updated_at' => now() ],
            ['id'=>'40','nama' =>  'Master Panitia Mahasiswa - CRUD',  'kategori' => 'Master Panitia Mahasiswa','for' => 'CRUD','created_at' => now(),'updated_at' => now() ],
            ['id'=>'41','nama' =>  'Master Panitia Dosen - Create',  'kategori' => 'Master Panitia Dosen','for' => 'Create','created_at' => now(),'updated_at' => now() ],
            ['id'=>'42','nama' =>  'Master Panitia Dosen - Read',  'kategori' => 'Master Panitia Dosen','for' => 'Read','created_at' => now(),'updated_at' => now() ],
            ['id'=>'43','nama' =>  'Master Panitia Dosen - Update',  'kategori' => 'Master Panitia Dosen','for' => 'Update','created_at' => now(),'updated_at' => now() ],
            ['id'=>'44','nama' =>  'Master Panitia Dosen - Delete',  'kategori' => 'Master Panitia Dosen','for' => 'Delete','created_at' => now(),'updated_at' => now() ],
            ['id'=>'45','nama' =>  'Master Panitia Dosen - CRUD',  'kategori' => 'Master Panitia Dosen','for' => 'CRUD','created_at' => now(),'updated_at' => now() ],
            ['id'=>'46','nama' =>  'Panitia Mahasiswa - Create',  'kategori' => 'Panitia Mahasiswa','for' => 'Create','created_at' => now(),'updated_at' => now() ],
            ['id'=>'47','nama' =>  'Panitia Mahasiswa - Read',  'kategori' => 'Panitia Mahasiswa','for' => 'Read','created_at' => now(),'updated_at' => now() ],
            ['id'=>'48','nama' =>  'Panitia Mahasiswa - Update',  'kategori' => 'Panitia Mahasiswa','for' => 'Update','created_at' => now(),'updated_at' => now() ],
            ['id'=>'49','nama' =>  'Panitia Mahasiswa - Delete',  'kategori' => 'Panitia Mahasiswa','for' => 'Delete','created_at' => now(),'updated_at' => now() ],
            ['id'=>'50','nama' =>  'Panitia Mahasiswa - CRUD',  'kategori' => 'Panitia Mahasiswa','for' => 'CRUD','created_at' => now(),'updated_at' => now() ],
            ['id'=>'51','nama' =>  'Panitia Dosen - Create',  'kategori' => 'Panitia Dosen','for' => 'Create','created_at' => now(),'updated_at' => now() ],
            ['id'=>'52','nama' =>  'Panitia Dosen - Read',  'kategori' => 'Panitia Dosen','for' => 'Read','created_at' => now(),'updated_at' => now() ],
            ['id'=>'53','nama' =>  'Panitia Dosen - Update',  'kategori' => 'Panitia Dosen','for' => 'Update','created_at' => now(),'updated_at' => now() ],
            ['id'=>'54','nama' =>  'Panitia Dosen - Delete',  'kategori' => 'Panitia Dosen','for' => 'Delete','created_at' => now(),'updated_at' => now() ],
            ['id'=>'55','nama' =>  'Panitia Dosen - CRUD',  'kategori' => 'Panitia Dosen','for' => 'CRUD','created_at' => now(),'updated_at' => now() ],
            ['id'=>'56','nama' =>  'Atribut - Create',  'kategori' => 'Atribut','for' => 'Create','created_at' => now(),'updated_at' => now() ],
            ['id'=>'57','nama' =>  'Atribut - Read',  'kategori' => 'Atribut','for' => 'Read','created_at' => now(),'updated_at' => now() ],
            ['id'=>'58','nama' =>  'Atribut - Update',  'kategori' => 'Atribut','for' => 'Update','created_at' => now(),'updated_at' => now() ],
            ['id'=>'59','nama' =>  'Atribut - Delete',  'kategori' => 'Atribut','for' => 'Delete','created_at' => now(),'updated_at' => now() ],
            ['id'=>'60','nama' =>  'Atribut - CRUD',  'kategori' => 'Atribut','for' => 'CRUD','created_at' => now(),'updated_at' => now() ],
            ['id'=>'61','nama' =>  'Perlengkapan - Create',  'kategori' => 'Perlengkapan','for' => 'Create','created_at' => now(),'updated_at' => now() ],
            ['id'=>'62','nama' =>  'Perlengkapan - Read',  'kategori' => 'Perlengkapan','for' => 'Read','created_at' => now(),'updated_at' => now() ],
            ['id'=>'63','nama' =>  'Perlengkapan - Update',  'kategori' => 'Perlengkapan','for' => 'Update','created_at' => now(),'updated_at' => now() ],
            ['id'=>'64','nama' =>  'Perlengkapan - Delete',  'kategori' => 'Perlengkapan','for' => 'Delete','created_at' => now(),'updated_at' => now() ],
            ['id'=>'65','nama' =>  'Perlengkapan - CRUD',  'kategori' => 'Perlengkapan','for' => 'CRUD','created_at' => now(),'updated_at' => now() ],
            ['id'=>'66','nama' =>  'Aturan - Create',  'kategori' => 'Aturan','for' => 'Create','created_at' => now(),'updated_at' => now() ],
            ['id'=>'67','nama' =>  'Aturan - Read',  'kategori' => 'Aturan','for' => 'Read','created_at' => now(),'updated_at' => now() ],
            ['id'=>'68','nama' =>  'Aturan - Update',  'kategori' => 'Aturan','for' => 'Update','created_at' => now(),'updated_at' => now() ],
            ['id'=>'69','nama' =>  'Aturan - Delete',  'kategori' => 'Aturan','for' => 'Delete','created_at' => now(),'updated_at' => now() ],
            ['id'=>'70','nama' =>  'Aturan - CRUD',  'kategori' => 'Aturan','for' => 'CRUD','created_at' => now(),'updated_at' => now() ],
            ['id'=>'71','nama' =>  'Tugas - Create',  'kategori' => 'Tugas','for' => 'Create','created_at' => now(),'updated_at' => now() ],
            ['id'=>'72','nama' =>  'Tugas - Read',  'kategori' => 'Tugas','for' => 'Read','created_at' => now(),'updated_at' => now() ],
            ['id'=>'73','nama' =>  'Tugas - Update',  'kategori' => 'Tugas','for' => 'Update','created_at' => now(),'updated_at' => now() ],
            ['id'=>'74','nama' =>  'Tugas - Delete',  'kategori' => 'Tugas','for' => 'Delete','created_at' => now(),'updated_at' => now() ],
            ['id'=>'75','nama' =>  'Tugas - CRUD',  'kategori' => 'Tugas','for' => 'CRUD','created_at' => now(),'updated_at' => now() ],
            ['id'=>'76','nama' =>  'Lagu - Create',  'kategori' => 'Lagu','for' => 'Create','created_at' => now(),'updated_at' => now() ],
            ['id'=>'77','nama' =>  'Lagu - Read',  'kategori' => 'Lagu','for' => 'Read','created_at' => now(),'updated_at' => now() ],
            ['id'=>'78','nama' =>  'Lagu - Update',  'kategori' => 'Lagu','for' => 'Update','created_at' => now(),'updated_at' => now() ],
            ['id'=>'79','nama' =>  'Lagu - Delete',  'kategori' => 'Lagu','for' => 'Delete','created_at' => now(),'updated_at' => now() ],
            ['id'=>'80','nama' =>  'Lagu - CRUD',  'kategori' => 'Lagu','for' => 'CRUD','created_at' => now(),'updated_at' => now() ],
            ['id'=>'81','nama' =>  'Berita - Create',  'kategori' => 'Berita','for' => 'Create','created_at' => now(),'updated_at' => now() ],
            ['id'=>'82','nama' =>  'Berita - Read',  'kategori' => 'Berita','for' => 'Read','created_at' => now(),'updated_at' => now() ],
            ['id'=>'83','nama' =>  'Berita - Update',  'kategori' => 'Berita','for' => 'Update','created_at' => now(),'updated_at' => now() ],
            ['id'=>'84','nama' =>  'Berita - Delete',  'kategori' => 'Berita','for' => 'Delete','created_at' => now(),'updated_at' => now() ],
            ['id'=>'85','nama' =>  'Berita - CRUD',  'kategori' => 'Berita','for' => 'CRUD','created_at' => now(),'updated_at' => now() ],
            ['id'=>'86','nama' =>  'Absensi - Create',  'kategori' => 'Absensi','for' => 'Create','created_at' => now(),'updated_at' => now() ],
            ['id'=>'87','nama' =>  'Absensi - Read',  'kategori' => 'Absensi','for' => 'Read','created_at' => now(),'updated_at' => now() ],
            ['id'=>'88','nama' =>  'Absensi - Update',  'kategori' => 'Absensi','for' => 'Update','created_at' => now(),'updated_at' => now() ],
            ['id'=>'89','nama' =>  'Absensi - Delete',  'kategori' => 'Absensi','for' => 'Delete','created_at' => now(),'updated_at' => now() ],
            ['id'=>'90','nama' =>  'Absensi - CRUD',  'kategori' => 'Absensi','for' => 'CRUD','created_at' => now(),'updated_at' => now() ],
            ));

            //Membuat Relasi Rule dan permissions Users
            // 1 Roles bisa memiliki banyak permission
            for ($admin2=1; $admin2 <= 90; $admin2++) {
                DB::table('permission_role')->insert([
                    'role_id' =>'1',
                    'permission_id'=>$admin2
            ]);
        }
    }
}
