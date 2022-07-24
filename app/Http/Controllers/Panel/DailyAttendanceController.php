<?php

namespace App\Http\Controllers\Panel;

use App\Models\User;
use Illuminate\Http\Request;
use App\Support\ResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\UserRepositoryInterface;
use App\Http\Resources\Panel\DailyAttendanceResource;
use App\Interfaces\DailyAttendanceRepositoryInterface;
use App\Http\Requests\Panel\StoreDailyAttendanceRequest;
use App\Interfaces\Validators\DailyAttendanceValidatorInterface;

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
        $user = null;
        if ($request->user_id) {
            $user = $this->userRepository->getUserById($request->user_id);
        }

        if ($user && !$user->status) {
            return ResponseMessage::failed($user->message, null, $user->code);
        }

        $validator = $this->dailyAttendanceValidator->getAttendances($request, $this->user, $user ? $user->data : null);

        if (!$validator->status) {
            return ResponseMessage::failed($validator->message, null, $validator->code);
        }

        $dailyAttendance = $this->dailyAttendanceRepository->get($request, $this->user);

        if (!$dailyAttendance->status) {
            return ResponseMessage::failed($dailyAttendance->message, null, $dailyAttendance->code);
        }


        return ResponseMessage::success(null, DailyAttendanceResource::collection($dailyAttendance->data));
    }

    public function store(StoreDailyAttendanceRequest $request)
    {

        $validator = $this->dailyAttendanceValidator->storeAttendance($request, $this->user);

        if (!$validator->status) {
            return ResponseMessage::failed($validator->message, null, $validator->code);
        }

        $storedDailyAttendance = $this->dailyAttendanceRepository->store($request, $this->user);

        if (!$storedDailyAttendance->status) {
            return ResponseMessage::failed($storedDailyAttendance->message, null, $storedDailyAttendance->code);
        }

        return ResponseMessage::success();
    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
