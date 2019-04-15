<?php

namespace App\Http\Controllers;

use App\Group;
use App\Staff;
use App\Equipment;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ImportRequest;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{
    use ApiTrait;

    private $allowImportField = [
        'staff'     => ['name', 'email', 'phone', 'group_id', 'duties', 'role_name'],
        'equipment' => ['name', 'source', 'memo', 'amount', 'hasBarcode', 'prefix'],
    ];

    private $allowExportField = [
        'staff'     => ['name', 'email', 'phone', 'group_name', 'role_name', 'duties', 'barcode'],
        'equipment' => ['name', 'source', 'memo', 'amount', 'hasBarcode', 'prefix'],
    ];

    /**
     * @param $model
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function export($model, $type)
    {
        if (! isset($this->allowExportField[$model])) {
            return $this->return400Response('Unknown model name');
        }

        $data = ('App\\' . ucfirst($model))::get()->plucks($this->allowExportField[$model]);
        Excel::create($model, function ($excel) use ($model, $data) {
            $excel->sheet($model, function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->export($type);
    }

    /**
     * @param ImportRequest $request
     * @param               $model
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(ImportRequest $request, $model)
    {
        if (! isset($this->allowImportField[$model])) {
            return $this->return400Response('Unknown model name');
        }

        $extension = $request->file('upload')->getMimeType();
        if (! ($extension === 'application/vnd.ms-office' || $extension === 'text/plain'
            || $extension === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')) {
            return $this->return400Response('File type error');
        }

        try {
            DB::beginTransaction();
            $data = Excel::load($request->file('upload')->getRealPath())->get();
            $this->{'import' . ucfirst($model)}($data);
            DB::commit();

            return $this->returnSuccess('Import successful');
        } catch (\Exception $e) {
            \Log::error($e->getTraceAsString());
            DB::rollBack();

            return $this->return400Response('發生不明錯誤');
        }
    }

    /**
     * @param $model
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function exportTemplate($model, $type)
    {
        if (! isset($this->allowExportField[$model])) {
            return $this->return400Response('Unknown model name');
        }

        $data = $this->allowExportField[$model];
        Excel::create($model, function ($excel) use ($model, $data) {
            $excel->sheet($model, function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->export($type);
    }

    private function importStaff($data)
    {
        $role = ['組員' => 0, '副組長' => 1, '組長' => 2];
        $allowImportField = $this->allowImportField['staff'];
        $data->each(function ($item, $key) use ($role, $allowImportField) {
            $item['role'] = $role[$item->role_name];

            $group_id = Group::where('name', $item->group_name)->first();

            // 無建立組別則建立新的
            if (! $group_id) {
                $group_id = Group::create([
                    'name' => $item->group_name,
                ]);
            }
            $item['group_id'] = $group_id->id;

            $staff = Staff::create($item->only($allowImportField)->toArray());
            $staff->setRole($item->role);
        });
    }

    private function importEquipment($data)
    {
        $allowImportField = $this->allowImportField['equipment'];
        $data->each(function ($item, $key) use ($allowImportField) {
            $item['hasBarcode'] = $item->hasbarcode > 0;
            $equipment = Equipment::create($item->only($allowImportField)->toArray());
            $equipment->setBarcode();
        });
    }
}
