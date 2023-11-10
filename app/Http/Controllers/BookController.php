<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return response()->json($books);
    }

    public function store(Request $request)
    {
        // Kullanıcıdan gelen verileri doğrulama
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'location' => 'required',
        ]);

        // Yeni kitabı oluştur
        $book = Book::create($data);

        return response()->json($book, 201);
    }



    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        // Kullanıcıdan gelen verileri doğrulama

        $gelenVeri = array();

        if(isset($request['title']) and $request['title']!=NULL) $gelenVeri['title'] = 'nullable';
        if(isset($request['description']) and $request['description']!=NULL) $gelenVeri['description'] = 'nullable';
        if(isset($request['location']) and $request['location']!=NULL) $gelenVeri['location'] = 'nullable';

        $data = $request->validate($gelenVeri);

        // Kitabı güncelleme işlemi
        $book->update($data);

        return response()->json($book, 200);
    }


    public function destroy($id)
    {
        $book = Book::find($id);
        if(is_object($book))
        {
            $book->delete();
        }
        else
            return response()->json(0, 200);

        return response()->json(1, 200);
    }

}
