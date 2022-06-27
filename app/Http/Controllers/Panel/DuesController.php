<?php

namespace App\Http\Controllers\Panel;

use App\Http\Requests\Panel\StoreDuesRequest;
use App\Http\Requests\Panel\UpdateDuesRequest;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\Validators\DuesValidatorInterface;
use App\Models\User;
use Illuminate\Http\Request;
use App\Support\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Resources\Panel\DuesResource;
use App\Interfaces\DuessRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class DuesController extends Controller
{
    /** @var User */
    protected $user;

    /** @var DuessRepositoryInterface */
    protected $duesRepository;

    /** @var UserRepositoryInterface */
    protected $userRepository;

    /** @var DuesValidatorInterface */
    protected $duesValidator;

    public function __construct(
        DuessRepositoryInterface $duesRepository,
        UserRepositoryInterface $userRepository,
        DuesValidatorInterface $duesValidator
    ){
        $this->duesRepository = $duesRepository;
        $this->userRepository = $userRepository;
        $this->duesValidator = $duesValidator;

        // Auth user
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index(Request $request){

        $user = $this->userRepository->getUserById($request->user_id);

        if (!$user->status){
            return ResponseMessage::failed($user->message, null, $user->code);
        }

        $validator = $this->duesValidator->index($user->data, $this->user);

        if (!$validator->status){
            return ResponseMessage::failed($validator->message, null, $validator->code);
        }

        $userDuesses = $this->duesRepository->getUserDuesses($request, $user->data);

        if (!$userDuesses->status){
            return ResponseMessage::failed($userDuesses->message);
        }

        $duesPeriod = $this->duesRepository->makeYearPeriod($userDuesses->data, $request->year);

        return ResponseMessage::success(null, DuesResource::collection($duesPeriod->data));
    }

    public function store(StoreDuesRequest $request){

        $user = $this->userRepository->getUserById($request->user_id);

        if (!$user->status){
            return ResponseMessage::failed($user->message, null, $user->code);
        }

        $validator = $this->duesValidator->storeDues($request, $user->data);

        if (!$validator->status)
            return ResponseMessage::failed($validator->message, null, $validator->code);

        $storedDues = $this->duesRepository->store($request, $user->data, $this->user);

        if (!$storedDues->status)
            return ResponseMessage::failed($storedDues->message, null, $storedDues->code);

        return ResponseMessage::success();
    }

    public function update(UpdateDuesRequest $request){

        $user = null;

        if ($request->user_id){
            $user = $this->userRepository->getUserById($request->user_id);
        }

        if ($user && !$user->status){
            return ResponseMessage::failed($user->message);
        }

        $dues = $this->duesRepository->getDuesById($request->dues_id, $user->data);

        if (!$dues->status){
            return ResponseMessage::failed($dues->message);
        }

        $updatedDues = $this->duesRepository->update($request, $dues->data, $this->user, $user->data);

        if (!$updatedDues->status){
            return ResponseMessage::failed($updatedDues->message);
        }

        return ResponseMessage::success();
    }

    public function destroy(){

    }

}
