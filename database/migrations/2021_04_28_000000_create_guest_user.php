<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

class CreateGuestUser extends Migration
{
    /**
     * The credentials for the shared guest account. These are intentionally
     * public so anyone can explore the project without registering.
     */
    const GUEST_EMAIL = 'guest@tierlist.app';
    const GUEST_PASSWORD = 'guest1234';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        User::firstOrCreate(
            ['email' => self::GUEST_EMAIL],
            [
                'name' => 'Guest',
                'password' => Hash::make(self::GUEST_PASSWORD),
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        User::where('email', self::GUEST_EMAIL)->delete();
    }
}
