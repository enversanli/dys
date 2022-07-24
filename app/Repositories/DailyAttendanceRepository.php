<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Association;
use Illuminate\Http\Request;
use App\Models\DailyAttendance;
use App\Support\ResponseMessage;
use App\Support\Enums\ErrorLogEnum;
use App\Interfaces\DailyAttendanceRepositoryInterface;
use App\Http\Requests\Panel\StoreDailyAttendanceRequest;

class DailyAttendanceRepository implements DailyAttendanceRepositoryInterface
{
    /** @var Association */
    protected $model;

    public function __construct(DailyAttendance $dailyAttendance)
    {
        $this->model = $dailyAttendance;
    }

    /**
     * @param Request $request
     * @param User $user
     * @return object
     */
    public function get(Request $request, User $user): object
    {
        try {
            $dates = $this->getDatesFromRequest($request);

            $dailyAttendances = $this->model
                ->when($request->user_id, function ($q) use ($request) {
                    return $q->where('user_id', $request->user_id);
                })
                ->when($request->class_id, function ($q) use ($request) {
                    return $q->where('class_id', $request->class_id);
                })
                ->whereBetween('date', [$dates->startDate, $dates->endDate])
                ->with('user')
                ->get();

            return ResponseMessage::returnData(true, $dailyAttendances);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::GET_DAILY_ATTENDANCES_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }

    /**
     * @param StoreDailyAttendanceRequest $request
     * @param User $authUser
     * @return object
     */
    public function store(StoreDailyAttendanceRequest $request, User $authUser): object
    {
        try {
            // key is to group data
            $key = now()->timestamp;

            foreach ($request->users as $userRow) {
                $userRow = (object)$userRow;

                $dailyAttendance = $this->model->create([
                    'key' => $key,
                    'class_id' => $request->class_id ?? null,
                    'lesson_id' => $request->lesson_id ?? null,
                    'user_id' => $userRow->id,
                    'at_lesson' => $userRow->at_lesson,
                    'date' => $request->date,
                    'status' => 'success',
                    'note' => $request->note ?? null,
                    'processed_by' => $authUser->id
                ]);
            }

            return ResponseMessage::returnData(true);
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::STORE_DAILY_ATTENDANCES_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }

    private function getDatesFromRequest(Request $request)
    {

        $year = (string)$request->year ?? now()->format('Y');
        $month = (string)$request->month != 0 ? $request->month : now()->format('m');

        $startDate = Carbon::createFromFormat('Y-m', $year . '-' . $month)->startOfMonth()->toDateString();
        $endDate = Carbon::createFromFormat('Y-m', $year . '-' . $month)->endOfMonth()->toDateString();

        return (object)['startDate' => $startDate, 'endDate' => $endDate];
    }

}
