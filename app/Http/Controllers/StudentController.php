<?php

namespace App\Http\Controllers;

use App\StudentValidation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                'is_verify' => (bool) $request->get('is_verify', false),
                'verify_user_id' => Auth::id(),
                'purchase_date' => $request->get('purchase_date'),
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'school_name' => $request->get('school_name', ''),
                'file_link' => $request->get('file_link', ''),
                'comment' => $request->get('comment', '')
            ]
        );
        $result->user;

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

        $validated_data = StudentValidation::where('verify_year', date('Y'))
            ->get()
            ->keyBy('order_id');

        $users = User::all()->keyBy('id');

        $file_path = $request->file('file')->getRealPath();
        $fp = fopen($file_path, 'r');
        $header = true;
        $result = [];
        $verified_result = [];
        while ($line = fgetcsv($fp)) {
            if ($header) {
                $header = false;
                continue;
            }

            $file_url = '';
            $file_type = '';
            if ($line[25] != '') {
                $file_url = explode('?', $line[25])[0];
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

            $id = null;
            $is_verify = false;
            $comment = '';
            $order_id = $line[1];
            $purchase_date = $line[8];
            $name = $line[10];
            $email = $line[11];
            $school = $line[21];
            $verify_user_name = '';
            if (isset($validated_data[$order_id])) {
                $id = $validated_data[$order_id]->id;
                $is_verify = (bool) $validated_data[$order_id]->is_verify;
                $comment = $validated_data[$order_id]->comment;
                $purchase_date = $validated_data[$order_id]->purchase_date;
                $name = $validated_data[$order_id]->name;
                $email = $validated_data[$order_id]->email;
                $school = $validated_data[$order_id]->school_name;
                $verify_user_name = $users[$validated_data[$order_id]->verify_user_id]->name;
            }

            $data = [
                'id' => $id,
                'order_id' => $line[1],
                'register_no' => $line[2],
                'is_verify' => $is_verify,
                'purchase_date' => $purchase_date,
                'name' => $name,
                'email' => $email,
                'school' => $school,
                'file_url' => $file_url,
                'file_type' => $file_type,
                'comment' => $comment,
                'verify_user_name' => $verify_user_name
            ];

            if ($is_verify) {
                $verified_result[] = $data;
            } else {
                $result[] = $data;
            }
        }

        $result = array_merge($result, $verified_result);

        return $this->returnSuccess('get data success', $result);
    }
}
