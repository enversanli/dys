<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Resources\Panel\DailyAttendanceResource;
use App\Interfaces\DailyAttendanceRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\Validators\DailyAttendanceValidatorInterface;
use App\Models\User;
use App\Support\ResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyAttendanceController extends Controller
{
    /** @var User */
    protected $user;

    /** @var UserRepositoryInterface */
    protected $userRepository;

    /** @var DailyAttendanceRepositoryInterface */
    protected $dailyAttendanceRepository;

    /** @var DailyAttendanceValidatorInterface */
    protected $dailyAttendanceValidator;

    public function __construct(
        UserRepositoryInterface            $userRepository,
        DailyAttendanceValidatorInterface  $dailyAttendanceValidator,
        DailyAttendanceRepositoryInterface $dailyAttendanceRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->dailyAttendanceValidator = $dailyAttendanceValidator;
        $this->dailyAttendanceRepository = $dailyAttendanceRepository;

        // Auth user
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }


    public function index(Request $request)
    {
        $user = $this->userRepository->getUserById($request->user_id);

        if (!$user->status) {
            return ResponseMessage::failed($user->message, null, $user->code);
        }

        $validator = $this->dailyAttendanceValidator->getStudentAttendances($request, $user->data);

        if (!$validator->status) {
            return ResponseMessage::failed($validator->message, null, $validator->code);
        }

        $dailyAttendance = $this->dailyAttendanceRepository->get($request, $user->data);

        if (!$dailyAttendance->status) {
            return ResponseMessage::failed($dailyAttendance->message, null, $dailyAttendance->code);
        }


        return ResponseMessage::success(null, DailyAttendanceResource::collection($dailyAttendance->data));
    }

    public function store()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
