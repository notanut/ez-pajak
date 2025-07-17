<?php

namespace App\Jobs;

use App\Models\Pengguna;
use App\Notifications\NotifikasiEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifikasiBayar implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pengguna;
    protected $pesan;

    /**
     * Create a new job instance.
     */
    public function __construct(Pengguna $pengguna, array $pesan)
    {
        //
        $this->pengguna = $pengguna;
        $this->pesan = $pesan;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $this->pengguna->notify(new NotifikasiEmail($this->pesan));
    }

}
