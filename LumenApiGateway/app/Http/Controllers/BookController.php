<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use App\Services\AuthorService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;

class BookController extends Controller
{
    use ApiResponser;

    public $bookService;

    public function __construct(
        BookService $bookService,
        AuthorService $authorService
    )
    {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    /**
     * @return \App\Traits\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->successResponse($this->bookService->obtainBooks());
    }

    /**
     * @param Request $request
     * @return \App\Traits\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->authorService->obtainAuthor($request->author_id);
        return $this->successResponse($this->bookService->createBook($request->all(), Response::HTTP_CREATED));
    }

    /**
     * @param $book
     * @return \App\Traits\Illuminate\Http\JsonResponse
     */
    public function show($book)
    {
        return $this->successResponse($this->bookService->obtainBook($book));
    }

    /**
     * @param Request $request
     * @param $book
     * @return \App\Traits\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $book)
    {
        return $this->successResponse($this->bookService->editBook($request->all(), $book));
    }

    /**
     * @param $book
     * @return \App\Traits\Illuminate\Http\JsonResponse
     */
    public function destroy($book)
    {
        return $this->successResponse($this->bookService->deleteBook($book));
    }
}
