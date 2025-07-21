<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Step\Given;

class FeatureContext implements Context
{
    private array $penghasilan = [];
    private array $potongan = [];
    private string $status = 'TK/0';
    private int $lamaKerja = 12;
    private array $hasil = [];

    /**
     * @Given pegawai memiliki penghasilan berupa:
     */
    public function pegawaiMemilikiPenghasilanBerupa(Behat\Gherkin\Node\TableNode $table)
    {
        foreach ($table as $row) {
            $this->penghasilan[$row['Komponen']] = (int) str_replace(['_', ','], '', $row['Nilai']);
        }
    }

    /**
     * @Given pegawai membayar:
     */
    public function pegawaiMembayar(Behat\Gherkin\Node\TableNode $table)
    {
        foreach ($table as $row) {
            $this->potongan[$row['Komponen']] = (int) str_replace(['_', ','], '', $row['Nilai']);
        }
    }

    /**
     * @Given pegawai memiliki status :status dan bekerja selama :bulan bulan
     */
    public function pegawaiMemilikiStatusDanBekerjaSelamaBulan($status, $bulan)
    {
        $this->status = $status;
        $this->lamaKerja = (int) $bulan;
    }

    /**
     * @When sistem menghitung PPh 21
     */
    public function sistemMenghitungPph21()
    {
        // 1. Hitung penghasilan bruto
        $bruto = array_sum($this->penghasilan);
        $this->hasil['Penghasilan Bruto'] = $bruto;

        // 2. Biaya jabatan: 5% dari bruto, max 500.000/bulan
        $biayaJabatan = min($bruto * 0.05, 500000 * $this->lamaKerja);
        $this->hasil['Biaya Jabatan'] = $biayaJabatan;

        // 3. Penghasilan neto
        $pengurangan = $biayaJabatan + ($this->potongan['Iuran Pensiun'] ?? 0) + ($this->potongan['Zakat'] ?? 0);
        $neto = $bruto - $pengurangan;
        $this->hasil['Penghasilan Neto'] = $neto;

        // 4. Disetahunkan
        $netoTahun = ($neto / $this->lamaKerja) * 12;
        $this->hasil['Penghasilan Neto Disetahunkan'] = $netoTahun;

        // 5. PTKP
        $ptkp = 54000000;
        if (str_starts_with($this->status, 'K')) {
            $jumlahTanggungan = (int) substr($this->status, 2, 1);
            $ptkp += min(3, $jumlahTanggungan) * 4500000;
        }
        $this->hasil['PTKP'] = $ptkp;

        // 6. Penghasilan Kena Pajak
        $pkp = max(0, $netoTahun - $ptkp);
        $this->hasil['Penghasilan Kena Pajak (PKP)'] = $pkp;

        // 7. Hitung pajak progresif
        $pphTahun = $this->hitungPajakProgresif($pkp);
        $this->hasil['Total PPh 21 Setahun'] = $pphTahun;

        // 8. Bagi per bulan
        $pphBulan = ($pphTahun / 12) * $this->lamaKerja;
        $this->hasil['PPh 21 Bulanan'] = round($pphBulan);
    }

    /**
     * @Then sistem harus menampilkan:
     */
    public function sistemHarusMenampilkan(Behat\Gherkin\Node\TableNode $table)
    {
        foreach ($table as $row) {
            $komponen = $row['Komponen'];
            $expected = str_replace(['_', ','], '', $row['Nilai']);

            if ($expected === '<' . strtolower(str_replace(' ', '_', $komponen)) . '>') {
                // Placeholder, abaikan validasi
                continue;
            }

            $expected = (int) $expected;
            $actual = $this->hasil[$komponen] ?? null;
            Assert::assertEquals(
                $expected,
                $actual,
                "Nilai untuk {$komponen} tidak sesuai. Diharapkan {$expected}, dapat {$actual}"
            );
        }
    }

    private function hitungPajakProgresif($pkp)
    {
        $lapis = [
            [50000000, 0.05],
            [250000000, 0.15],
            [500000000, 0.25],
            [5000000000, 0.30],
            [INF, 0.35],
        ];

        $sisa = $pkp;
        $pajak = 0;
        $batasBawah = 0;

        foreach ($lapis as [$batasAtas, $tarif]) {
            $batas = min($sisa, $batasAtas - $batasBawah);
            $pajak += $batas * $tarif;
            $sisa -= $batas;
            $batasBawah = $batasAtas;

            if ($sisa <= 0) break;
        }

        return round($pajak);
    }
}

