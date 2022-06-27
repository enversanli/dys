<?php

namespace App\Repositories;

use App\Http\Requests\Panel\StoreDuesRequest;
use App\Http\Requests\Panel\UpdateDuesRequest;
use App\Interfaces\DuessRepositoryInterface;
use App\Models\Association;
use App\Models\Dues;
use App\Models\User;
use App\Support\DTOs\Dues\DuesDTO;
use App\Support\Enums\DuesStatusEnum;
use App\Support\Enums\ErrorLogEnum;
use App\Support\PaginateData;
use App\Support\ResponseMessage;
use Illuminate\Http\Request;

class DuessRepository implements DuessRepositoryInterface
{
    /** @var Dues */
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
                ->where('status', DuesStatusEnum::PAID->value)
                ->get();

            return ResponseMessage::returnData(true, $duesses);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::RESET_PASSWORD_AUTH_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }

    public function getDuesById($id, User $user = null)
    {
        try {

            $dues = $this->model->where('id', $id)
                ->when($user, function ($q) use ($user) {
                    return $q->where('user_id', $user->id);
                })->first();

            if (!$dues) {
                return ResponseMessage::returnData(false, null, __('dues.not_found'));
            }

            return ResponseMessage::returnData(true, $dues);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::GET_DUES_BY_ID_REPOSITORY_ERROR->value);

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

            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::MAKE_YEAR_PERIOD_DUES_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }

    public function store(StoreDuesRequest $request, User $user, User $authUser)
    {
        try {

            $dues = $this->model->create([
                'user_id' => $user->id,
                'year' => $request->year,
                'month' => $request->month,
                'approved_at' => now()->format('Y-m-d H:i:s'),
                'approved_by' => $authUser->id,
                'status' => DuesStatusEnum::PAID->value,
                'fee' => 20
            ]);


            return ResponseMessage::returnData(true, $dues);
        } catch (\Exception $exception) {

            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::STORE_DUES_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }

    public function update(UpdateDuesRequest $request, Dues $dues, User $authUser, User $user = null)
    {
        try {
            $data = ['status' => $request->status];
            if ($request->status == DuesStatusEnum::CANCELLED->value) {
                $data['cancelled_by'] = $authUser->id;
            }

            $dues->update($data);

            return ResponseMessage::returnData(true, $dues);
        } catch (\Exception $exception) {

            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::UPDATE_DUES_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }

    private function translateMonth($month)
    {
        return __('dues.' . $month);
    }

}
