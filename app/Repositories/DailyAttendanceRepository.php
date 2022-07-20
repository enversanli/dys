<?php

namespace App\Repositories;

use App\Models\DailyPoll;
use App\Models\Association;
use App\Models\User;
use App\Support\ResponseMessage;
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

    public function get(Request $request, User $user)
    {
        try {
            $dates = $this->getDatesFromRequest($request);

            $dailyAttendances = $this->model
                ->where('user_id', $user->id)
                ->whereBetween('date', [$dates->startDate, $dates->endDate])
                ->with('user')
                ->get();

            return ResponseMessage::returnData(true, $dailyAttendances);
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return ResponseMessage::returnData(false);
        }
    }

    private function getDatesFromRequest(Request $request){

        $startDate = $request->start_date ?? now()->days(-30)->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');

        return (object)['startDate' => $startDate, 'endDate' => $endDate];
    }

}
