<?php

namespace App\Http\Controllers;

use App\Loan;
use App\Staff;
use App\Equipment;
use App\EquipmentBarcode;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\Http\Requests\LoanRequest;
use App\Http\Requests\LoanReturnRequest;
use App\Services\ApiService;

class LoanController extends Controller
{
    /**
     * @param Request $request
     * @return \App\Services\ApiService
     */
    public function index(Request $request)
    {

        $status = $request->input('status', [0, 1]);
        // dd($status);
        $barcode = $request->input('barcode', '');
        $order_field = $request->input('orderby_field', 'id');
        $order_method = $request->input('orderby_method', 'desc');
        $limit = $request->input('limit', 15);
        $loan = Loan::whereIn('status', $status)
            ->Where(function($query) use ($barcode) {
                $query->orWhere('barcode', 'LIKE', '%' . $barcode . '%');
            })
            ->orderBy($order_field, $order_method)
            ->paginate($limit);

        return ApiService::returnApiResponse('Success.', $loan);
    }

    /**
     * @param LoanRequest $request
     * @return \App\Services\ApiService
     */
    public function store(LoanRequest $request)
    {
        if ($request->input('staff_id') != 0) {
            $staff = Staff::find($request->input('staff_id'));
        } else {
            $staff = Staff::where('barcode', $request->input('staff_barcode'))->first();
        }

        if (!$staff) {
            return ApiService::returnApiResponse('Staff not found.', [], false, 404);
        }

        if ($request->input('equipment_id') != 0) {
            $equipment = Equipment::find($request->input('equipment_id'));

            if (!$equipment) {
                return ApiService::returnApiResponse('Equipment not found.', [], false, 404);
            }

            if ($equipment->last() < $request->input('amount')) {
                return ApiService::returnApiResponse('There is not enough equipment.', [], false, 400);
            }

            if ($equipment->hasBarcode) {
                return ApiService::returnApiResponse('Equipment has barcode.', [], false, 400);
            }

            $equipment->loan += $request->input('amount');
            $equipment->save();

            $loan = Loan::create([
                'staff_id'     => $staff->id,
                'equipment_id' => $equipment->id,
                'amount'       => $request->input('amount'),
            ]);
        } else {
            $equipmentBarcode = EquipmentBarcode::where('barcode', $request->input('equipment_barcode'))->first();

            if (!$equipmentBarcode) {
                return ApiService::returnApiResponse('Equipment barcode not found.', [], false, 404);
            }

            if ($equipmentBarcode->status == 1) {
                return ApiService::returnApiResponse('The equipment has been lent.', [], false, 400);
            }

            if ($equipmentBarcode->equipment->last() == 0) {
                return ApiService::returnApiResponse('There is not enough equipment.', [], false, 400);
            }

            $equipmentBarcode->equipment->loan++;
            $equipmentBarcode->equipment->save();
            $equipmentBarcode->status = 1;
            $equipmentBarcode->save();

            $loan = Loan::create([
                'staff_id'     => $staff->id,
                'equipment_id' => $equipmentBarcode->equipment->id,
                'amount'       => '1',
                'barcode'      => $equipmentBarcode->barcode,
            ]);
        }

        return ApiService::returnApiResponse('Loan success.', $loan);
    }

    /**
     * @param Loan $loan
     * @return \App\Services\ApiService
     */
    public function show(Loan $loan)
    {
        return ApiService::returnApiResponse('Show success.', $loan);
    }

    public function returnLoan(LoanReturnRequest $request)
    {
        if ($request->input('loan_id') != 0) {
            $loan = Loan::find($request->input('loan_id'));
        } else {
            $loan = Loan::where('barcode', $request->input('barcode'))->first();
        }

        if (!$loan) {
            return ApiService::returnApiResponse('Loan not found.', [], false, 404);
        }

        $loan->return_back += $request->input('amount');
        $loan->equipment->loan -= $request->input('amount');
        $loan->equipment->save();

        if ($loan->last() == 0) {
            $loan->status = 1;
            $loan->return_at = date('Y-m-d H:i:s');
        }

        $loan->save();

        if ($loan->equipmentBarcode) {
            $loan->equipmentBarcode->status = 0;
            $loan->equipmentBarcode->save();
        }

        return ApiService::returnApiResponse('Return success.', $loan);
    }

}
