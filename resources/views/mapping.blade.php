<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Aaron Aceves CSV Upload test | Upload CSV | Step 1</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
              background-color: #fff;
              color: #636b6f;
              font-family: 'Nunito', sans-serif;
              font-weight: 200;
              height: 100vh;
              margin: 0;
            }

            .full-height {
              height: 100vh;
            }

            .flex-center {
              align-items: center;
              display: flex;
              justify-content: center;
            }

            .position-ref {
              position: relative;
            }

            .top-right {
              position: absolute;
              right: 10px;
              top: 18px;
            }

            .content {
              text-align: center;
            }

            .title {
              font-size: 18px;
            }

            .boxed{
              color: #636b6f;
              padding: 25px;
              font-size: 13px;
              font-weight: 600;
              letter-spacing: .1rem;
              text-decoration: none;
              border-style: dashed;
              border-width: thin;
            }

            .links > a {
              color: #636b6f;
              padding: 0 25px;
              font-size: 13px;
              font-weight: 600;
              letter-spacing: .1rem;
              text-decoration: none;
              text-transform: uppercase;
            }

            .m-b-md {
              margin-bottom: 30px;
            }

            table {
              font-family: arial, sans-serif;
              border-collapse: collapse;
              width: 600px;
            }

            td, th {
              border: 1px solid #dddddd;
              text-align: left;
              padding: 8px;
            }

            tr:nth-child(even) {
              background-color: #dddddd;
            }
            .textleft {
              text-align: left;
            }
            .textcenter {
              text-align: center;
            }
            .submitButton {
              background-color: #4CAF50;
              border: none;
              color: white;
              padding: 10px 32px;
              text-align: center;
              text-decoration: none;
              display: inline-block;
              font-size: 16px;
            } /* Green */
            .cancelButton {
              background-color: #f44336;
              border: none;
              color: white;
              padding: 10px 32px;
              text-align: center;
              text-decoration: none;
              display: inline-block;
              font-size: 16px;
            } /* Red */
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md links">
                    Map Fields | Step 2
                </div>

                @if ($errors->any())
                  <div class="alert alert-danger">
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif

                {{ Form::open(['url' => '/parser/map', 'action' => 'post']) }}

                  <div class="boxed">
                    <h3 class="textleft">Map your CSV file fields to the Database</h3>
                    <h4 class="textleft"><strong>{{ $data['counter'] }}</strong> Records found in your CSV file | <a href="/">Upload a different file</a></h4>
                    <table>
                      <tr>
                        <th>CSV File Column</th>
                        <th>Database Column</th>
                      </tr>

                      @if(empty($data))
                      <tr>
                        <th colspan="2" class="textcenter">No data found</th>
                      </tr>
                      @else

                        @foreach($data['data'] as $key => $value)
                          <tr>
                            <th>{{ $value }}</th>
                            <th>{{ array_key_exists($key, $data['columns']) ? Form::select($key, $data['columns'], $key) : Form::select($key, $data['columns'], 5) }}</th>
                          </tr>
                        @endforeach

                        <tr>
                          <th colspan="2" class="textcenter">{{ Form::submit("Map {$data['counter']} Records", ['class' => 'submitButton']) }} | <a href="/">Cancel and Return Home</a></th>
                        </tr>

                      @endif
                    </table>
                  </div>

                {{ Form::close() }}

                <div class="title m-b-md textleft">
                    <a href="/">Return to Step 1</a>
                </div>
            </div>
        </div>
    </body>
</html>
