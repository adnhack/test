<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

/**
* ParserController class handle the manipulation of CSV files to upload, parse
* and save the information
* @author Aaron Aceves
*/
class ParserController extends Controller
{
    /**
    * Global static variables
    */
    static $columns = ['team_id', 'name', 'phone', 'email', 'sticky_phone_number_id', 'Do not map'];

    public function __construct()
    {
      //
    }

    /**
    * parseUpload function parse the uploaded file to get the file headers and
    * records count. Expects a Request and return an array with counting, data and columns
    * @param Request $request
    * @return Array $data
    */
    public function parseUpload(Request $request)
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

    /**
    * mapData function loops the information and save it to the DB
    * @param Session csvpath
    * @return View success
    */
    public function mapData()
    {
      $data = self::parseCSVFile(['save'], session('csvpath'));

      if(empty($data)) {
        echo "Error No data found. <a href='/'>Try again</a>";
        exit;
      }

      array_shift($data);

      foreach($data as $key => $value) {
        $this->saveData($value);
      }
      return view('success');
    }

    /**
    * saveData private function Save the given information to the DB
    * @param Array $data
    * @return void
    */
    private function saveData(Array $data)
    {

      $mapped = [];
      $unmapped = [];

      foreach($data as $key => $value) {
        if($_POST[$key] == "5") {
          $alt = empty($_POST["a$key"]) ? $key : $_POST["a$key"];
          $unmapped[] = ['key' => $alt, 'value' => $value];
        } else {
          $mapped[self::$columns[$_POST[$key]]] = $value;
        }
      }

      $id = DB::table('contacts')->insertGetId($mapped);

      foreach($unmapped as $value) {
        DB::table('custom_attributes')->insert(
          array('contact_id' => $id, 'key' => $value['key'], 'value' => $value['value'])
        );
      }
    }

    /**
    * parseCSVFile static function parse the CSV file and return the results
    * in the given format. If requested for "save" return only the CSV data,
    * otherwise return CSV data, records count and DB columns
    * @param Array $requested
    * @param String $path
    * @return Array $data
    */
    public static function parseCSVFile(Array $requested, String $path)
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
