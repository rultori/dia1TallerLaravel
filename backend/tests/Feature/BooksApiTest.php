<?php

// namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BooksApiTest extends TestingTestCase
{
    use RefreshDatabase;

    /** @test */

    function test_can_get_all_books()
    {
        $books = Book::factory(4)->create();

        $response = $this->getJson(route('books.index'));

        $response->assertJsonFragment([
            'title'=> $books[0]->title
        ])->assertJsonFragment([
            'title'=> $books[1]->title
        ]);




    }

    function test_can_get_one_book()
    {
        $book = Book::factory()->create();

        $response = $this->getJson(route('books.show',$book));

        $response->assertJsonFragment([
            'title' => $book->title
        ]);

    }

    function test_can_create_books()
    {
        $this->postJson(route('books.store',[])
        ->assertJsonValidationErronFor('tittle');

        $this->postJson(route('books.store'),[
            'title' => 'My new book'
        ])->assertJsonFragment([
            'tittle'=> 'My new book'
        ]);

        $this->assertDatabaseHas('books',[
            'tittle' => 'My new book'
        ]);
    }

    function test_update_books()
    {
        $book = Book::factory()->create();

        $this->patchJson(route('books.update',$book),[])
        ->assertJsonValidationErronFor('tittle');


        $this->pathcJson(route('books.update', $book),[
            'title' => 'Edited Book'
        ])->assertJsonFragment([
            'title' => 'Edited Book'
        ]);

        $this->assertDatabaseHas('books',[
            'title' => 'Edited Book'

        ])
    }

    function test_can_delete_books()
    {
        $book = Book::factory()->create();

        $this->deleteJson(route('books.destroy',$book))
        ->assertNoContent();

        $this->assertDatabaseCount('books',0);
    }

}

?>

