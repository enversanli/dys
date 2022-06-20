<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\UpdateAssociationRequest;
use App\Interfaces\AssociationRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;

class AssociationController extends Controller
{
    /** @var User */
    protected $user;
    /** @var AssociationRepositoryInterface */
    protected $associationRepository;

    public function __construct(AssociationRepositoryInterface $associationRepository){
        $this->associationRepository = $associationRepository;
    }

    public function index(){

    }

    public function store(){

    }

    public function update(UpdateAssociationRequest $request){

    }

    public function destroy(){

    }
}
