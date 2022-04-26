<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Models\Author;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;


class AuthorController extends Controller
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * @return \App\Traits\Illuminate\Http\JsonResponse
     */
    public function index() {
        $author = Author::all();
        return $this->successResponse($author);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return Author successResponse
     */
    public function store(Request $request) {
        $rules = [
            'name' => 'required|max:255',
            'gender' => 'required|max:255|in:male,female',
            'country' => 'required|max:255'
        ];
        $this->validate($request, $rules);
        $author = Author::create($request->all());
        return $this->successResponse($author, Response::HTTP_CREATED);
    }

    /**
     * @param $author
     * @return \App\Traits\Illuminate\Http\JsonResponse
     */
    public function show($author) {
         $author = Author::findOrFail($author);
         return $this->successResponse($author);
    }

    /**
     * @param Request $request
     * @param $author
     * @return \App\Traits\Illuminate\Http\JsonResponse|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $author) {
        $rules = [
            'name' => 'max:255',
            'gender' => 'max:255|in:male,female',
            'country' => 'max:255'
        ];
        $this->validate($request, $rules);
        $author = Author::findOrFail($author);
        $author->fill($request->all());
        if ($author->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $author->save();
        return $this->successResponse($author);
    }


    /**
     * destroy
     *
     * @param  mixed $author
     * @return void
     */
    public function destroy($author) {
        $author = Author::findOrFail($author);
        $author->delete();
        return $this->successResponse($author);
    }
}
