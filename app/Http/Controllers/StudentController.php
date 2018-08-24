<?php

namespace App\Http\Controllers;

use App\StudentValidation;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    use ApiTrait;

    private $image_type = ['bmp', 'gif', 'jpeg', 'png', 'jpg'];

    public function store(Request $request)
    {
        $result = StudentValidation::updateOrCreate(
            [
                'verify_year' => $request->get('verify_year', date('Y')),
                'order_id' => $request->get('order_id'),
                'register_no' => $request->get('register_no'),
            ],
            [
                'purchase_date' => $request->get('purchase_date'),
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'school_name' => $request->get('school_name', ''),
                'file_link' => $request->get('file_link', ''),
                'comment' => $request->get('comment', '')
            ]
        );

        return $this->returnSuccess('Update or create success', $result);
    }

    public function destroy($id)
    {
        $result = StudentValidation::destroy($id);

        return $this->returnSuccess('Delete done', $result);
    }

    public function upload(Request $request)
    {
        if (!$request->hasFile('file')) {
            return $this->return400Response('Need upload file');
        }

        $file_path = $request->file('file')->getRealPath();
        $fp = fopen($file_path, 'r');
        $header = true;
        $result = [];
        while ($line = fgetcsv($fp)) {
            if ($header) {
                $header = false;
                continue;
            }

            $file_url = '';
            $file_type = '';
            if ($line[26] != '') {
                $file_url = explode('?', $line[26])[0];
                $parse_url = explode('.', $file_url);
                $file_extension = strtolower(last($parse_url));
                if (in_array($file_extension, $this->image_type)) {
                    $file_type = 'image';
                } elseif ($file_extension === 'pdf') {
                    $file_type = 'pdf';
                } elseif ($file_extension === 'zip') {
                    $file_type = 'zip';
                }
            }

            $result[] = [
                'order_id' => $line[1],
                'no' => $line[2],
                'purchase_date' => $line[8],
                'name' => $line[10],
                'email' => $line[11],
                'school' => $line[22],
                'file_url' => $file_url,
                'file_type' => $file_type
            ];
        }

        return $this->returnSuccess('get data success', $result);
    }
}
