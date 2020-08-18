<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ParserController extends Controller
{

    static $columns = ['team_id', 'name', 'phone', 'email', 'sticky_phone_number_id', 'Do not map'];

    public function __construct()
    {
      //
    }

    public function validateFile(Request $request)
    {
      $validatedData = $request->validate(['csv_file' => 'required|mimes:txt,csv|file']);

      if(!$request->file('csv_file')->isValid()) {
        echo "Invalid request <a href='/'>Return Home</a>";
        exit;
      }

      $new_name = "upload_".time().uniqid().".csv";
      $path = $request->csv_file->storeAs('csv_file', $new_name);
      session(['csvpath' => $path]);
      $data = self::parseCSVFile(['lines', 'headers'], $path);
      return view('/mapping', ['data' => $data]);

    }

    public function mapData()
    {
      $data = self::parseCSVFile(['save'], session('csvpath'));
      foreach($data as $key => $value) {
        $this->saveData($value);
      }

    }


    private function saveData(Array $data)
    {

      if(empty($data)) {
        echo "Error No data found. <a href='/'>Try again</a>";
        exit;
      }

      $mapped = [];
      $unmapped = [];

      echo "parsing new row <br>";

      echo "<pre>";
      var_dump(self::$columns);
      var_dump($data);
      var_dump($_POST);

      foreach($data as $key => $value) {

        echo self::$columns[$_POST[$key]]. " => $value <br>";

        if($_POST[$key] == "5") {
          $unmapped[] = ['unmapped' => $value];
        } else {
          $mapped[self::$columns[$_POST[$key]]] = $value;
        }

      }

      var_dump($unmapped);
      var_dump($mapped);

      exit;

      DB::table('users')->insert(
        array('email' => 'john@example.com', 'votes' => 0)
      );

      DB::table('users')->insert(
        array('email' => 'john@example.com', 'votes' => 0)
      );

    }

    public static function parseCSVFile(Array $requested, $path)
    {
      $url = Storage::url($path);
      $csv_handle = fopen($url, 'r');
      $counter = 0;
      $data = [];

      while (($row = fgetcsv($csv_handle, 0, ",")) !== FALSE) {
        $data[] = $row;
        $counter++;
      }

      fclose($csv_handle);
      return in_array('save', $requested) ? $data : ['data' => $data[0], 'counter' => $counter - 1, 'columns' => self::$columns];
    }

}
