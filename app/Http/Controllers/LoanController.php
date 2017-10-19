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
use App\Http\Controllers\ApiTrait;

class LoanController extends Controller
{

    use ApiTrait;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {

        $status = $request->input('status', [0, 1]);
        $barcode = $request->input('barcode', '');
        $order_field = $request->input('orderby_field', 'id');
        $order_method = $request->input('orderby_method', 'desc');
        $limit = $request->input('limit', 15);
        $loan = Loan::whereIn('status', $status)
            ->Where(function ($query) use ($barcode) {
                $query->orWhere('barcode', 'LIKE', '%' . $barcode . '%');
            })
            ->orderBy($order_field, $order_method)
            ->paginate($limit);

        return $this->returnSuccess('Success.', $loan);
    }

    /**
     * @param LoanRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LoanRequest $request)
    {
        if ($request->input('staff_id') != 0) {
            $staff = Staff::find($request->input('staff_id'));
        } else {
            $staff = Staff::where('barcode', $request->input('staff_barcode'))->first();
        }

        if (!$staff) {
            return $this->return404Response('Staff not found.');
        }

        if ($request->input('equipment_id') != 0) {
            $equipment = Equipment::find($request->input('equipment_id'));

            if (!$equipment) {
                return $this->return404Response('Equipment not found.');
            }

            if ($equipment->last() < $request->input('amount')) {
                return $this->return400Response('There is not enough equipment.');
            }

            if ($equipment->hasBarcode) {
                return $this->return400Response('Equipment has barcode.');
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
                return $this->return404Response('Equipment barcode not found.');
            }

            if ($equipmentBarcode->status == 1) {
                return $this->return400Response('The equipment has been lent.');
            }

            if ($equipmentBarcode->equipment->last() == 0) {
                return $this->return400Response('There is not enough equipment.');
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

        return $this->returnSuccess('Loan success.', $loan);
    }

    /**
     * @param Loan $loan
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Loan $loan)
    {
        return $this->returnSuccess('Show success.', $loan);
    }

    /**
     * @param LoanReturnRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnLoan(LoanReturnRequest $request)
    {
        if ($request->input('loan_id') != 0) {
            $loan = Loan::find($request->input('loan_id'));
        } else {
            $loan = Loan::where('barcode', $request->input('barcode'))->where('status', 0)->first();
        }

        if (!$loan) {
            return $this->return404Response('Loan not found.');
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

        return $this->returnSuccess('Return success.', $loan);
    }

}
