<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\ParserController;

class TestParser extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testParseCSVFileSave()
    {
        $path = "/Library/WebServer/Documents/test/storage/app/csv_file/upload_15977687505f3c042e4f974.csv";
        $data = ParserController::parseCSVFile(['save'], $path);

        var_dump($data);

        $this->assertTrue($data);
    }
}
