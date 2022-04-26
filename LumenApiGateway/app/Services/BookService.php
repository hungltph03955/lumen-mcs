<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

class BookService
{
    use ConsumesExternalService;

    /**
     * @var
     */
    public $baseUri;

    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.books.base_uri');
        $this->secret = config('services.books.secret');
    }

    public function obtainBooks()
    {
        return $this->performRequest('GET', '/books');
    }

    public function createBook($data)
    {
        return $this->performRequest('POST', '/books', $data);
    }

    public function obtainBook($author)
    {
        return $this->performRequest('GET', "/books/{$author}");
    }

    public function editBook($data, $author)
    {
        return $this->performRequest('PUT', "books/{$author}", $data);
    }

    public function deleteBook($author)
    {
        return $this->performRequest('DELETE', "books/{$author}");
    }

}
