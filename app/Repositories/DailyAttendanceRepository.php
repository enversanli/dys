<?php

namespace App\Repositories;

use App\Models\DailyPoll;
use App\Models\Association;
use App\Models\User;
use App\Support\Enums\ErrorLogEnum;
use App\Support\ResponseMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DailyAttendance;
use App\Interfaces\DailyAttendanceRepositoryInterface;

class DailyAttendanceRepository implements DailyAttendanceRepositoryInterface
{
    /** @var Association */
    protected $model;

    public function __construct(DailyAttendance $dailyAttendance)
    {
        $this->model = $dailyAttendance;
    }

    public function get(Request $request)
    {
        try {
            $dates = $this->getDatesFromRequest($request);

            $dailyAttendances = $this->model
                ->when($request->user_id, function ($q) use ($request) {
                    return $q->where('user_id', $request->user_id);
                })
                ->when($request->class_id, function ($q) use ($request){
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

    private function getDatesFromRequest(Request $request){

        $year = (string)$request->year ?? now()->format('Y');
        $month = (string)$request->month != 0 ? $request->month : now()->format('m');

        $startDate = Carbon::createFromFormat('Y-m', $year . '-' . $month)->startOfMonth()->toDateString();
        $endDate = Carbon::createFromFormat('Y-m', $year . '-' . $month)->endOfMonth()->toDateString();

        return (object)['startDate' => $startDate, 'endDate' => $endDate];
    }

}
