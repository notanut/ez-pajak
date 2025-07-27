@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-column">
        <h1>Riwayat Perhitungan Kamu</h1>
        <p>Hasil perhitungan yang telah kamu input tersimpan dalam list ini. Unduh untuk disimpan menjadi arsip pribadi.</p>

        <div class="table-responsive"> {{-- Untuk tabel yang responsif di layar kecil --}}
            <table class="table table-striped table-hover text-center align-middle">
                {{-- Bagian Header Tabel --}}
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Metode Pembayaran</th>
                        <th scope="col">Total</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                {{-- Bagian Isi Tabel --}}
                <tbody>
                    @forelse ($Transaksi as $index => $item)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th> {{-- Nomor Urut --}}
                        <td>{{ $item->metode_pembayaran }}</td> {{-- Nama Dokumen --}}
                        <td>{{ $item->total }}</td> {{-- Periode --}}
                        <td>
                            {{-- Gambar ini akan menjadi pemicu modal --}}
                            <a href="#" class="btn btn-link p-0" {{-- Menggunakan btn-link untuk menghilangkan gaya tombol default, p-0 untuk padding 0 --}}
                                data-bs-toggle="modal"
                                data-bs-target="#transactionDetailModal"
                                data-id="{{ $item->id }}"
                                data-nomor-urut="{{ $index + 1 }}"
                                data-metode-pembayaran="{{ $item->metode_pembayaran }}"
                                data-total="{{ $item->total }}"
                                data-tanggal="{{ $item->created_at ? $item->created_at->format('d/m/Y') : '-' }}"
                                data-waktu="{{ $item->created_at ? $item->created_at->format('H:i:s') : '-' }}">
                                <img src="{{ asset('images/see.png') }}" alt="Lihat Detail" class="img-fluid" style="max-width: 30px;">
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada riwayat perhitungan yang tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Detail Transaksi --}}
<div class="modal fade" id="transactionDetailModal" tabindex="-1" aria-labelledby="transactionDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transactionDetailModalLabel">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Data detail transaksi akan ditampilkan di sini --}}
                <p><strong>ID Transaksi:</strong> <span id="transactionId"></span></p>
                <p><strong>Nomor Urut:</strong> <span id="transactionNumber"></span></p>
                <p><strong>Metode Pembayaran:</strong> <span id="paymentMethod"></span></p>
                <p><strong>Total:</strong> <span id="totalAmount"></span></p>
                <p><strong>Tanggal:</strong> <span id="transactionDate"></span></p>
                <p><strong>Waktu:</strong> <span id="transactionTime"></span></p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const eyeIcons = document.querySelectorAll('.btn-link');
        
        eyeIcons.forEach(icon => {
            icon.addEventListener('click', function (e) {
                const id = e.target.closest('a').getAttribute('data-id');
                const nomorUrut = e.target.closest('a').getAttribute('data-nomor-urut');
                const metodePembayaran = e.target.closest('a').getAttribute('data-metode-pembayaran');
                const total = e.target.closest('a').getAttribute('data-total');
                const tanggal = e.target.closest('a').getAttribute('data-tanggal');
                const waktu = e.target.closest('a').getAttribute('data-waktu');
                
                document.getElementById('transactionId').textContent = id;
                document.getElementById('transactionNumber').textContent = nomorUrut;
                document.getElementById('paymentMethod').textContent = metodePembayaran;
                document.getElementById('totalAmount').textContent = total;
                document.getElementById('transactionDate').textContent = tanggal;
                document.getElementById('transactionTime').textContent = waktu;
            });
        });
    });
</script>
@endpush
