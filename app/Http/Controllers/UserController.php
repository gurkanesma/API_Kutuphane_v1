<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Illuminate\Database\QueryException;



class UserController extends Controller
{

    public function register(Request $request)
    {
        // Kullanıcıdan gelen verileri doğrulama
        $validatedData = $request->validate([
            'name_surname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // Kullanıcıyı kaydetme
        $user = new User();
        $user->name_surname = $validatedData['name_surname'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->status = '0';
        $user->group ='ogrenci';


        try {

            $user->save();
            return response()->json(['message' => 'Kullanıcı başarıyla kaydedildi'], 201);

        } catch (QueryException $e) {

            var_dump($e);

        }





    }


    public function login(Request $request)
    {
        // Kullanıcıdan gelen verileri doğrulama
        /*
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        */

        $email = $request->email;
        $password = $request->password;


        $credentials = array(
            "email" => $email,
            "password" => $password
        );

        // Kullanıcıyı kimlik doğrulama
        if (auth()->attempt($credentials)) {
            // Giriş başarılı

            // Kullanıcının oturum açmış haliyle işlem yapma
            $user = auth()->user();

            //  oturum açan kullanıcının bilgilerini yanıt olarak döndürme
            return response()->json(['status'=>'true','user' => $user, 'message' => 'Giriş başarılı'], 200);
        } else {
            // Kimlik doğrulama başarısız
            return response()->json(['status'=>'false','message' => 'Kimlik doğrulama başarısız'], 401);
        }
    }


    public function logout()
    {
        // Kullanıcı oturumunu sonlandır
        auth()->user()->token()->revoke();

        // Çıkış başarılı yanıtı
        return response()->json(['message' => 'Kullanıcı çıkış yaptı'], 200);
    }


}
