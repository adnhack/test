<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ParserController;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testDatabase()
    {
      $this->assertDatabaseHas('contacts', [
          'id' => '256',
      ]);
    }

    public function testParseCSVFileSave()
    {
        $path = "csv_file/upload_15977687505f3c042e4f974.csv";
        $data = ParserController::parseCSVFile(['save'], $path);
        $this->assertNotEmpty($data);
        $this->assertIsArray($data);
    }

    public function testParseCSVFileHeaders()
    {
        $path = "csv_file/upload_15977687505f3c042e4f974.csv";
        $data = ParserController::parseCSVFile(['lines', 'headers'], $path);
        $this->assertNotEmpty($data);
        $this->assertIsArray($data);
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('counter', $data);
        $this->assertArrayHasKey('columns', $data);
    }

}
