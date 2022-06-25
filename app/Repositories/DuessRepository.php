<?php

namespace App\Repositories;

use App\Interfaces\DuessRepositoryInterface;
use App\Models\Association;
use App\Models\Dues;
use App\Models\User;
use App\Support\DTOs\Dues\DuesDTO;
use App\Support\Enums\ErrorLogEnum;
use App\Support\PaginateData;
use App\Support\ResponseMessage;
use Illuminate\Http\Request;

class DuessRepository implements DuessRepositoryInterface
{
    /** @var Association */
    protected $model;

    public function __construct(Dues $dues)
    {
        $this->model = $dues;
    }

    public function getUserDuesses(Request $request, User $user)
    {
        try {
//            $paginateData = PaginateData::fromRequest($request);

            $year = $request->year ?? now()->format('Y');

            $duesses = $this->model->where('user_id', $user->id)
                ->where('year', (int)$year)
                ->get();

            return ResponseMessage::returnData(true, $duesses);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::RESET_PASSWORD_AUTH_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }

    public function makeYearPeriod($duesses, $year)
    {
        try {
            $duesData = collect();

            for ($x = 1; $x < 13; $x++) {
                $data = new DuesDTO();
                $data->month = $x;
                $data->year = $year;
                $data->month_translated = $this->translateMonth($x);

                if ($dues = $duesses->where('month', $x)->first()) {
                    $data->id = $dues->id;
                    $data->fee = $dues->fee;
                    $data->approved_at = $dues->approved_at;
                    $data->paid_at = $dues->paid_at;
                    $data->status = $dues->status;
                }
                $duesData->push($data);
            }


            return ResponseMessage::returnData(true, $duesData);
        } catch (\Exception $exception) {

            return ResponseMessage::returnData(false);
        }
    }

    private function translateMonth($month)
    {
        return __('dues.' . $month);
    }

}
