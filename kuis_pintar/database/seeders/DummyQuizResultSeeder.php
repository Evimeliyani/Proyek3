<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DummyQuizResultSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $userIds = DB::table('users')->pluck('id')->toArray();
        if (count($userIds) === 0) return;

        $kategoriList = ['Penjumlahan', 'Pengurangan', 'Perkalian', 'Pembagian'];

        $rows = [];

        foreach (array_slice($userIds, 0, 4) as $uid) {
            foreach ($kategoriList as $kat) {
                for ($i = 1; $i <= 5; $i++) {
                    $rows[] = [
                        'user_id'    => $uid,
                        'kategori'   => $kat,
                        'score'      => rand(60, 100),
                        'taken_at'   => $now->copy()->subDays(10 - $i),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
        }

        DB::table('quiz_results')->insert($rows);
    }
}
