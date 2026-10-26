<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {name?} {email?} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Buat atau update akun admin baru dengan password yang aman';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->argument('name') ?? $this->ask('Nama admin');
        $email = $this->argument('email') ?? $this->ask('Email admin');
        $password = $this->argument('password') ?? $this->secret('Password admin');

        if (empty($name) || empty($email) || empty($password)) {
            $this->error('Nama, email, dan password wajib diisi.');
            return self::FAILURE;
        }

        $user = User::firstOrNew(['email' => $email]);
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->role = 'admin';
        $user->status = 'aktif';
        $user->save();

        $this->info('Admin berhasil dibuat/diupdate: ' . $email);
        $this->info('Password sudah di-hash menggunakan bcrypt secara otomatis.');

        return self::SUCCESS;
    }
}
