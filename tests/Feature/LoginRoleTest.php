<?php

namespace Tests\Feature;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LoginRoleTest extends TestCase
{
    public function test_login_page_has_admin_and_user_access_options(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('Admin');
        $response->assertSee('User');
    }

    public function test_user_role_can_login_using_user_selection(): void
    {
        User::query()->where('email', 'user@example.com')->delete();

        User::factory()->create([
            'name' => 'User Test',
            'email' => 'user@example.com',
            'password' => bcrypt('secret123'),
            'role' => 'anggota',
            'status' => 'aktif',
        ]);

        $response = $this->post('/login', [
            'email' => 'user@example.com',
            'password' => 'secret123',
            'role' => 'user',
        ]);

        $response->assertRedirect(route('user.dashboard'));
        $this->assertAuthenticatedAs(User::where('email', 'user@example.com')->first());
    }

    public function test_user_cannot_login_using_admin_selection(): void
    {
        User::query()->where('email', 'role-mismatch@example.com')->delete();

        User::factory()->create([
            'name' => 'Role Mismatch',
            'email' => 'role-mismatch@example.com',
            'password' => bcrypt('secret123'),
            'role' => 'anggota',
            'status' => 'aktif',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'role-mismatch@example.com',
            'password' => 'secret123',
            'role' => 'admin',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_admin_cannot_login_using_user_selection(): void
    {
        User::query()->where('email', 'admin-role-mismatch@example.com')->delete();

        User::factory()->create([
            'name' => 'Admin Role Mismatch',
            'email' => 'admin-role-mismatch@example.com',
            'password' => bcrypt('secret123'),
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'admin-role-mismatch@example.com',
            'password' => 'secret123',
            'role' => 'user',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_menu_pages_are_available_for_logged_in_member(): void
    {
        User::query()->where('email', 'memberpages@example.com')->delete();

        $user = User::factory()->create([
            'name' => 'Member Pages',
            'email' => 'memberpages@example.com',
            'password' => bcrypt('secret123'),
            'role' => 'anggota',
            'status' => 'aktif',
        ]);

        $this->actingAs($user);

        $this->get(route('user.returns'))->assertOk();
        $this->get(route('user.history'))->assertOk();
    }

    public function test_database_seeder_creates_active_admin_account_with_hashed_password(): void
    {
        User::query()->delete();
        Anggota::query()->delete();

        $this->artisan('db:seed')->assertSuccessful();

        $admin = User::query()->where('email', 'adminperpustakaan@gmail.com')->first();

        $this->assertNotNull($admin);
        $this->assertSame('admin', $admin->role);
        $this->assertSame('aktif', $admin->status);
        $this->assertTrue(Hash::check('Admin@2026', $admin->password));
        $this->assertSame(1, User::query()->where('role', 'anggota')->count());
    }

    public function test_admin_can_create_member_record_with_linked_user_account(): void
    {
        User::query()->whereIn('email', [
            'admintest@example.com',
            'anggota.baru@example.com',
        ])->delete();

        $admin = User::factory()->create([
            'name' => 'Admin Test',
            'email' => 'admintest@example.com',
            'password' => bcrypt('secret123'),
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        Anggota::query()->where('nis', 'ADMIN-NEW-001')->delete();

        $this->actingAs($admin);

        $response = $this->post(route('anggota.store'), [
            'email' => 'anggota.baru@example.com',
            'password' => 'Anggota@123',
            'password_confirmation' => 'Anggota@123',
            'nis' => 'ADMIN-NEW-001',
            'nama_lengkap' => 'Anggota Baru',
            'alamat' => 'Jl. Baru No. 5',
            'kelas' => 'XII IPS 1',
        ]);

        $response->assertRedirect(route('anggota.index'));
        $user = User::query()->where('email', 'anggota.baru@example.com')->first();

        $this->assertNotNull($user);
        $this->assertSame('anggota', $user->role);
        $this->assertSame('aktif', $user->status);
        $this->assertTrue(Hash::check('Anggota@123', $user->password));
        $this->assertDatabaseHas('anggota', [
            'nis' => 'ADMIN-NEW-001',
            'nama_lengkap' => 'Anggota Baru',
            'id_user' => $user->id,
        ]);
    }

    public function test_admin_can_login_with_plain_text_password_from_database(): void
    {
        User::query()->where('email', 'plainadmin@example.com')->delete();

        User::factory()->create([
            'name' => 'Plain Admin',
            'email' => 'plainadmin@example.com',
            'password' => 'Admin@123',
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $response = $this->post('/login', [
            'email' => 'plainadmin@example.com',
            'password' => 'Admin@123',
            'role' => 'admin',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs(User::where('email', 'plainadmin@example.com')->first());
    }

    public function test_user_can_register_and_is_sent_to_user_dashboard(): void
    {
        User::query()->where('email', 'newuser@example.com')->delete();
        Anggota::query()->where('nis', 'NEW-001')->delete();

        $response = $this->post(route('register.store'), [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'nis' => 'NEW-001',
            'kelas' => 'XI IPA 2',
            'alamat' => 'Jl. Contoh No. 1',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect(route('user.dashboard'));
        $this->assertAuthenticated();
        $this->assertSame('anggota', User::where('email', 'newuser@example.com')->value('role'));
        $this->assertSame('XI IPA 2', Anggota::where('nis', 'NEW-001')->value('kelas'));
        $this->assertSame('Jl. Contoh No. 1', Anggota::where('nis', 'NEW-001')->value('alamat'));
    }

    public function test_admin_can_upload_book_cover_image(): void
    {
        Storage::fake('public');
        User::query()->where('email', 'bookupload@example.com')->delete();
        Buku::query()->where('judul_buku', 'Pemrograman Laravel')->delete();

        $admin = User::factory()->create([
            'name' => 'Admin Book Upload',
            'email' => 'bookupload@example.com',
            'password' => bcrypt('secret123'),
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $this->actingAs($admin);

        $file = UploadedFile::fake()->image('cover.jpg', 600, 900);

        $response = $this->post(route('buku.store'), [
            'judul_buku' => 'Pemrograman Laravel',
            'penulis' => 'Budi',
            'penerbit' => 'Gramedia',
            'tahun' => 2026,
            'kategori' => 'Programming',
            'deskripsi' => 'Buku tentang Laravel',
            'stok' => 5,
            'gambar' => $file,
        ]);

        $response->assertRedirect(route('buku.index'));

        $book = Buku::query()->where('judul_buku', 'Pemrograman Laravel')->first();
        $this->assertNotNull($book);
        $this->assertNotNull($book->gambar);
        Storage::disk('public')->assertExists($book->gambar);
    }

    public function test_user_catalog_shows_cover_uploaded_by_admin_when_book_is_edited(): void
    {
        Storage::fake('public');
        User::query()->whereIn('email', ['bookcoveradmin@example.com', 'bookcoveruser@example.com'])->delete();
        Buku::query()->where('judul_buku', 'Sampul Terbaru')->delete();

        $admin = User::factory()->create([
            'name' => 'Admin Book Cover',
            'email' => 'bookcoveradmin@example.com',
            'password' => bcrypt('secret123'),
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $this->actingAs($admin);

        $this->post(route('buku.store'), [
            'judul_buku' => 'Sampul Terbaru',
            'penulis' => 'Penulis',
            'penerbit' => 'Penerbit',
            'tahun' => 2026,
            'kategori' => 'Novel',
            'stok' => 1,
            'gambar' => UploadedFile::fake()->image('cover-lama.jpg', 600, 900),
        ])->assertRedirect(route('buku.index'));

        $book = Buku::query()->where('judul_buku', 'Sampul Terbaru')->firstOrFail();
        $oldCoverPath = $book->gambar;

        $this->get(route('buku.edit', $book->id_buku))
            ->assertOk()
            ->assertSee($oldCoverPath);

        $this->put(route('buku.update', $book->id_buku), [
            'judul_buku' => $book->judul_buku,
            'penulis' => $book->penulis,
            'penerbit' => $book->penerbit,
            'tahun' => $book->tahun,
            'kategori' => $book->kategori,
            'stok' => $book->stok,
            'gambar' => UploadedFile::fake()->image('cover-baru.jpg', 600, 900),
        ])->assertRedirect(route('buku.index'));

        $book->refresh();
        $this->assertNotSame($oldCoverPath, $book->gambar);
        Storage::disk('public')->assertExists($book->gambar);

        $user = User::factory()->create([
            'name' => 'Book Cover User',
            'email' => 'bookcoveruser@example.com',
            'password' => bcrypt('secret123'),
            'role' => 'anggota',
            'status' => 'aktif',
        ]);

        $this->actingAs($user)
            ->get(route('user.catalog'))
            ->assertOk()
            ->assertSee($book->gambar)
            ->assertSee('book-cover-image');
    }
}
