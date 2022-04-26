<?php

namespace App\Http\Controllers;

use App\Models\book;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ApiResponser;

class BookController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @return \App\Traits\Illuminate\Http\JsonResponse
     */
    public function index() {
        $book = Book::all();
        return $this->successResponse($book);
    }

    /**
     * @param Request $request
     * @return \App\Traits\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request) {
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|min:1',
            'author_id' => 'required|min:1'
        ];
        $this->validate($request, $rules);
        $book = Book::create($request->all());
        return $this->successResponse($book, Response::HTTP_CREATED);
    }

    /**
     * @param $book
     * @return \App\Traits\Illuminate\Http\JsonResponse
     */
    public function show($book) {
        $book = Book::findOrFail($book);
        return $this->successResponse($book);
    }

    /**
     * @param Request $request
     * @param $book
     * @return \App\Traits\Illuminate\Http\JsonResponse|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $book) {
        $rules = [
            'title' => 'max:255',
            'description' => 'required',
            'price' => 'min:1',
            'author_id' => 'min:1'
        ];
        $this->validate($request, $rules);
        $book = book::findOrFail($book);
        $book->fill($request->all());
        if ($book->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $book->save();
        return $this->successResponse($book);
    }

    /**
     * @param $book
     * @return \App\Traits\Illuminate\Http\JsonResponse
     */
    public function destroy($book) {
        $book = Book::findOrFail($book);
        $book->delete();
        return $this->successResponse($book);
    }
}
