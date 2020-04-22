<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                Jurusan_SMA::class,
                Fakultas::class,
                Program_Studi::class,
                Mata_Pelajaran::class
            ]
        );
    }
}
