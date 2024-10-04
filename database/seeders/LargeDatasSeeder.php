<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class LargeDatasSeeder extends Seeder
{
    const BATCH_SIZE = 1000;
    const TOTAL_RECORDS = 1000; // 100000 records

    public function run()
    {
        $this->seedAnggarans();
        $this->seedSubAnggarans();
        $this->seedPermintaanPembelians();
        $this->seedTransaksis();
        $this->seedSubPermintaanPembelians();
        $this->seedOrderPembelians();
        $this->seedSubOrderPembelians();
    }

    private function seedAnggarans()
    {
        $faker = Faker::create();
        $data = [];

        for ($i = 0; $i < self::TOTAL_RECORDS; $i++) {
            $data[] = [
                'project_id' => $faker->numberBetween(1, 1000),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (($i + 1) % self::BATCH_SIZE === 0) {
                DB::table('anggarans')->insert($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            DB::table('anggarans')->insert($data);
        }
    }

    private function seedSubAnggarans()
    {
        $faker = Faker::create();
        $data = [];
        $noDetails = range(1, self::TOTAL_RECORDS);
        shuffle($noDetails);

        for ($i = 0; $i < self::TOTAL_RECORDS; $i++) {
            $data[] = [
                'anggaran_id' => $faker->numberBetween(1, self::TOTAL_RECORDS),
                'kel_anggaran_id' => $faker->numberBetween(1, 1000),
                'no_detail' => $noDetails[$i],
                'produk_id' => $faker->numberBetween(1, 10000),
                'kuantitas_anggaran' => $faker->numberBetween(1, 1000),
                'harga_anggaran' => $faker->numberBetween(10000, 10000000),
                'total_anggaran' => $faker->numberBetween(100000, 100000000),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (($i + 1) % self::BATCH_SIZE === 0) {
                DB::table('sub_anggarans')->insert($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            DB::table('sub_anggarans')->insert($data);
        }
    }

    private function seedPermintaanPembelians()
    {
        $faker = Faker::create();
        $data = [];
        $nomorPPs = $this->generateUniqueAlphanumeric('PP', self::TOTAL_RECORDS);

        for ($i = 0; $i < self::TOTAL_RECORDS; $i++) {
            $data[] = [
                'anggaran_id' => $faker->numberBetween(1, self::TOTAL_RECORDS),
                'nomor_pp' => $nomorPPs[$i],
                'tgl_pp' => $faker->date(),
                'tandatangan_pp' => json_encode([
                    'nama' => $faker->name,
                    'jabatan' => $faker->jobTitle,
                    'tanggal' => $faker->date()
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (($i + 1) % self::BATCH_SIZE === 0) {
                DB::table('permintaan_pembelians')->insert($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            DB::table('permintaan_pembelians')->insert($data);
        }
    }

    private function seedTransaksis()
    {
        $faker = Faker::create();
        $data = [];
        $kodeTransaksis = $this->generateUniqueAlphanumeric('TRX', self::TOTAL_RECORDS);

        for ($i = 0; $i < self::TOTAL_RECORDS; $i++) {
            $data[] = [
                'kode_transaksi' => $kodeTransaksis[$i],
                'nama_transaksi' => $faker->words(3, true),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (($i + 1) % self::BATCH_SIZE === 0) {
                DB::table('transaksis')->insert($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            DB::table('transaksis')->insert($data);
        }
    }

    private function seedSubPermintaanPembelians()
    {
        $faker = Faker::create();
        $data = [];

        for ($i = 0; $i < self::TOTAL_RECORDS; $i++) {
            $data[] = [
                'permintaanpembelian_id' => $faker->numberBetween(1, self::TOTAL_RECORDS),
                'sub_anggaran_id' => $faker->numberBetween(1, self::TOTAL_RECORDS),
                'produk_id' => $faker->numberBetween(1, 10000),
                'spesifikasi_sub_permintaan_pembelian' => $faker->sentence,
                'kuantitas_sub_permintaan_pembelian' => $faker->numberBetween(1, 1000),
                'harga_sub_permintaan_pembelian' => $faker->numberBetween(10000, 10000000),
                'total_sub_permintaan_pembelian' => $faker->numberBetween(100000, 100000000),
                'keterangan_sub_permintaan_pembelian' => $faker->optional()->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (($i + 1) % self::BATCH_SIZE === 0) {
                DB::table('sub_permintaan_pembelian')->insert($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            DB::table('sub_permintaan_pembelian')->insert($data);
        }
    }

    private function seedOrderPembelians()
    {
        $faker = Faker::create();
        $data = [];
        $nomorOPs = $this->generateUniqueAlphanumeric('OP', self::TOTAL_RECORDS);

        for ($i = 0; $i < self::TOTAL_RECORDS; $i++) {
            $data[] = [
                'permintaanpembelian_id' => $faker->numberBetween(1, self::TOTAL_RECORDS),
                'rekanan_id' => $faker->numberBetween(1, 1000),
                'nomor_op' => $nomorOPs[$i],
                'tgl_op' => $faker->date(),
                'tandatangan_op' => json_encode([
                    'nama' => $faker->name,
                    'jabatan' => $faker->jobTitle,
                    'tanggal' => $faker->date()
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (($i + 1) % self::BATCH_SIZE === 0) {
                DB::table('order_pembelians')->insert($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            DB::table('order_pembelians')->insert($data);
        }
    }

    private function seedSubOrderPembelians()
    {
        $faker = Faker::create();
        $data = [];

        for ($i = 0; $i < self::TOTAL_RECORDS; $i++) {
            $data[] = [
                'orderpembelian_id' => $faker->numberBetween(1, self::TOTAL_RECORDS),
                'sub_permintaanpembelian_id' => $faker->numberBetween(1, self::TOTAL_RECORDS),
                'ppn_sub_order_pembelian' => $faker->numberBetween(1000, 1000000),
                'kuantitas_sub_order_pembelian' => $faker->numberBetween(1, 1000),
                'total_sub_order_pembelian' => $faker->numberBetween(100000, 100000000),
                'catatan_sub_order_pembelian' => $faker->optional()->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (($i + 1) % self::BATCH_SIZE === 0) {
                DB::table('sub_order_pembelians')->insert($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            DB::table('sub_order_pembelians')->insert($data);
        }
    }

    private function generateUniqueAlphanumeric($prefix, $count)
    {
        $result = [];
        for ($i = 0; $i < $count; $i++) {
            $result[] = $prefix . str_pad($i + 1, 8, '0', STR_PAD_LEFT);
        }
        shuffle($result);
        return $result;
    }
}
