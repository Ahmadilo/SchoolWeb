<?php

use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Given Nothing => When Reqoust Login form => Should Return 200 Code Response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('Given Currect Username and Password => When Reqoust Login => Should Return 200 code Respone and sussecc message', function () {
    $user = User::factory()->create([
        'name' => 'ahmadilo',
        'password' => '123456', // كلمة السر مشفرة
    ]);

    // إرسال طلب POST مع بيانات الدخول
    $response = $this->post(route('login.login'), [
        'username' => $user->name,
        'password' => $user->password, // كلمة السر التي وضعناها
    ]);

    // تحقق من إعادة التوجيه إلى داشبورد
    $response->assertRedirect(route('dashboard.index'));

    // تحقق من وجود رسالة نجاح في الجلسة
    $response->assertSessionHas('success', 'Login successful');
});
