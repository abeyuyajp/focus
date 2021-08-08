<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Storage;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_全ての情報があれば登録できる()
    {
        $UserName = 'test';
        $Email    = 'test@example';
        $Password = 'password123';
        $PasswordConfirmation = 'password123';

        $response = $this->post(route('register'),
            [
                'name'  => $UserName,
                'email' => $Email,
                'password' => $Password,
                'password_confirmation' => $PasswordConfirmation,
            ]
        );
        $this->assertDatabaseHas('users', [
            'name' => $UserName,
            'email' => $Email,
        ]);

        $response->assertRedirect('/');
    }

    public function test_ユーザー名が必須()
    {
        $UserName = '';
        $Email    = 'test@example';
        $Password = 'password123';
        $PasswordConfirmation = 'password123';

        $response = $this->post(route('register'),
            [
                'name'  => $UserName,
                'email' => $Email,
                'password' => $Password,
                'password_confirmation' => $PasswordConfirmation,
            ]
        );
        $this->assertDatabaseMissing('users', [
            'name'  => $UserName,
            'email' => $Email,
        ]);
    }

    public function test_メールアドレスが必須()
    {
        $UserName = 'test';
        $Email    = '';
        $Password = 'password123';
        $PasswordConfirmation = 'password123';

        $response = $this->post(route('register'),
            [
                'name'  => $UserName,
                'email' => $Email,
                'password' => $Password,
                'password_confirmation' => $PasswordConfirmation,
            ]
        );
        $this->assertDatabaseMissing('users', [
            'name'  => $UserName,
            'email' => $Email,
        ]);
    }

    public function test_メールアドレスには＠を含む必要があること()
    {
        $UserName = 'test';
        $Email    = 'test';
        $Password = 'password123';
        $PasswordConfirmation = 'password123';

        $response = $this->post(route('register'),
            [
                'name'  => $UserName,
                'email' => $Email,
                'password' => $Password,
                'password_confirmation' => $PasswordConfirmation,
            ]
        );
        $this->assertDatabaseMissing('users', [
            'name'  => $UserName,
            'email' => $Email,
        ]);
    }

    public function test_パスワードが必須()
    {
        $UserName = 'test';
        $Email    = 'test@example';
        $Password = '';
        $PasswordConfirmation = '';

        $response = $this->post(route('register'),
            [
                'name'  => $UserName,
                'email' => $Email,
                'password' => $Password,
                'password_confirmation' => $PasswordConfirmation,
            ]
        );
        $this->assertDatabaseMissing('users', [
            'name'  => $UserName,
            'email' => $Email,
        ]);
    }

    public function test_パスワードは8文字以上での入力が必須であること()
    {
        $UserName = 'test';
        $Email    = 'test@example';
        $Password = 'test';
        $PasswordConfirmation = 'test';

        $response = $this->post(route('register'),
            [
                'name'  => $UserName,
                'email' => $Email,
                'password' => $Password,
                'password_confirmation' => $PasswordConfirmation,
            ]
        );
        $this->assertDatabaseMissing('users', [
            'name'  => $UserName,
            'email' => $Email,
        ]);
    }

    public function test_パスワードは半角英数字混合での入力が必須であること()
    {
        $UserName = 'test';
        $Email    = 'test@example';
        $Password = 'password';
        $PasswordConfirmation = 'password';

        $response = $this->post(route('register'),
            [
                'name'  => $UserName,
                'email' => $Email,
                'password' => $Password,
                'password_confirmation' => $PasswordConfirmation,
            ]
        );
        $this->assertDatabaseMissing('users', [
            'name'  => $UserName,
            'email' => $Email,
        ]);
    }

    public function test_パスワード（確認用）が必須であること()
    {
        $UserName = 'test';
        $Email    = 'test@example';
        $Password = 'password123';
        $PasswordConfirmation = '';

        $response = $this->post(route('register'),
            [
                'name'  => $UserName,
                'email' => $Email,
                'password' => $Password,
                'password_confirmation' => $PasswordConfirmation,
            ]
        );
        $this->assertDatabaseMissing('users', [
            'name'  => $UserName,
            'email' => $Email,
        ]);
    }

    public function test_パスワードとパスワード（確認用）は値の一致が必須であること()
    {
        $UserName = 'test';
        $Email    = 'test@example';
        $Password = 'password123';
        $PasswordConfirmation = 'test';

        $response = $this->post(route('register'),
            [
                'name'  => $UserName,
                'email' => $Email,
                'password' => $Password,
                'password_confirmation' => $PasswordConfirmation,
            ]
        );
        $this->assertDatabaseMissing('users', [
            'name'  => $UserName,
            'email' => $Email,
        ]);
    }

    public function test_ユーザー情報を更新するためには、ユーザー名が必須であること()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user);
        $response = $this->get(route('user.edit'));
        $response->assertStatus(200);

        $ProfileImage = Storage::disk('s3')->url('card.image');
        $Name = '';
        $Work = 'エンジニア';
        $Purpose = '個人サービスをリリースする';

        $update_path = route('user.update', ['user' => $user->id]);
        $update_data = [
            'profile_image' => $ProfileImage,
            'name' => $Name,
            'work' => $Work,
            'purpose' => $Purpose,
        ];

    }

    public function test_職業は未入力でも更新できる()
    {
       $user = factory(User::class)->create();
       $response = $this->actingAs($user);
       $response = $this->get(route('user.edit'));
       $response->assertStatus(200);

       $name = 'test';
       $work = 'engineer';
       $purpose = 'I will be global engineer';

       $update_path = route('user.update', ['user' => $user->id]);
       $update_data = [
           'name' => $name,
           'work' => $work,
           'purpose' => $purpose,
       ];
       eval(\Psy\sh());
       $response = $this->put($update_path, $update_data);
       
      
       $response->assertRedirect('user.show', ['user' => $user->id]);

    }
}
