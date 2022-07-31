<?php

namespace App\Http\Validators;

use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Panel\StoreDailyAttendanceRequest;
use App\Interfaces\Validators\DailyAttendanceValidatorInterface;
use App\Models\DailyAttendance;
use App\Models\User;
use App\Support\ResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DailyAttendanceValidator implements DailyAttendanceValidatorInterface
{
    /** @var DailyAttendance */
    protected $model;

    public function __construct(DailyAttendance $dailyAttendance)
    {
        $this->model = $dailyAttendance;
    }

    public function getAttendances(Request $request, User $authUser, User $user = null)
    {
        try {
            if ($authUser->isStudent() || $authUser->isParent()) {
                return ResponseMessage::returnData(false, null, __('common.not_have_authority'), 401);
            }

            if (isset($user) && $user->association_id != $authUser->association_id) {
                return ResponseMessage::returnData(false, null, __('user.not_found'), 404);
            }

            return ResponseMessage::returnData(true);
        } catch (\Exception $exception) {

            return ResponseMessage::returnData(false);
        }
    }

    public function storeAttendance(StoreDailyAttendanceRequest $request, User $authUser)
    {
        try {

            foreach ($request->users as $user) {
                $user = (object)$user;
                if (!User::where('id', $user->id)->where('association_id', $authUser->association->id)->exists()) {
                    return ResponseMessage::returnData(false, $user, __('user.not_found'), 404);
                }
            }

            return ResponseMessage::returnData(true);
        } catch (\Exception $exception) {
            return ResponseMessage::returnData(false);
        }
    }
}
