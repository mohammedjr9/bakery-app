<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    public function test_user_can_login_and_see_dashboard(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('user_name', '400008371')   // 👈 رقم الهوية (زي اللي في قاعدة البيانات)
                ->type('password', '123456')       // 👈 كلمة المرور
                ->press('تسجيل الدخول')
                ->assertPathIs('/dashboard')       // 👈 لاحظ المسار بعد تسجيل الدخول عندك هو dashboard
                ->assertSee('لوحة التحكم');        // 👈 تأكد أن هذه الكلمة موجودة فعلاً في الصفحة
        });
    }
}
