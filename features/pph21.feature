Feature: Kalkulator Pajak PPh 21 Pegawai Tetap
  Sebagai bagian HRD atau pegawai
  Saya ingin menghitung PPh 21 sesuai ketentuan perpajakan
  Agar saya tahu berapa pajak yang harus dipotong setiap bulan

  Scenario: Menghitung PPh 21 pegawai tetap yang bekerja selama 6 bulan
    Given pegawai memiliki penghasilan berupa:
      | Komponen         | Nilai         |
      | Gaji Pokok       | 10_000_000    |
      | Tunjangan PPh    | 1_000_000     |
      | Tunjangan Lain   | 500_000       |
      | Bonus            | 2_000_000     |
      | Premi Asuransi   | 300_000       |
      | Natura           | 200_000       |
    And pegawai membayar:
      | Komponen             | Nilai     |
      | Iuran Pensiun        | 200_000   |
      | Zakat                | 100_000   |
    And pegawai memiliki status "K/1" dan bekerja selama 6 bulan
    When sistem menghitung PPh 21
    Then sistem harus menampilkan:
    | Komponen                        | Nilai         |
    | Penghasilan Bruto              | 14_000_000    |
    | Biaya Jabatan                  | 700_000       |
    | Penghasilan Neto               | 13_000_000    |
    | Penghasilan Neto Disetahunkan | 26_000_000      |
    | PTKP                           | 58_500_000    |
    | Penghasilan Kena Pajak (PKP)   | 0    |
    | Tarif Pajak                    | 0      |
    | Total PPh 21 Setahun           | 0     |
    | PPh 21 Bulanan                 | 0      |
