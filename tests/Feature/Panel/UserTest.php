<?php

namespace Tests\Feature\Panel;

use App\Models\Association;
use App\Models\User;
use App\Models\UserRole;
use App\Support\Enums\UserRoleKeyEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function getOnlyStudents()
    {
        // Create association
        $associations = $this->createAssociation(1);
        $association = $associations->first();


        // Create User
        $students = $this->createUser($association);
        $teacher = $this->createUser($association,UserRoleKeyEnum::TEACHER, 1);
        $parents = $this->createUser($association,UserRoleKeyEnum::PARENT);

        $this->actingAs($teacher->first());

        $response = $this->get(route('users.list'));

        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');
        $response->assertJsonPath('pagination.total', 21);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function studentCanNotDisplayUserList()
    {
        // Create association
        $associations = $this->createAssociation(1);
        $association = $associations->first();


        // Create User
        $students = $this->createUser($association, UserRoleKeyEnum::STUDENT->value);
        $teacher = $this->createUser($association,UserRoleKeyEnum::TEACHER->value, 1);
        $parents = $this->createUser($association,UserRoleKeyEnum::PARENT->value);

        // Acting
        $this->actingAs($students->first());

        $response = $this->get(route('users.list'));

        $response->assertStatus(401);
        $response->assertJsonPath('message', __('common.not_have_authority'));
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function parentCanNotDisplayUserList()
    {
        // Create association
        $associations = $this->createAssociation(1);
        $association = $associations->first();


        // Create User
        $students = $this->createUser($association, UserRoleKeyEnum::STUDENT->value);
        $teacher = $this->createUser($association,UserRoleKeyEnum::TEACHER->value, 1);
        $parents = $this->createUser($association,UserRoleKeyEnum::PARENT->value);

        // Acting
        $this->actingAs($parents->first());

        $response = $this->get(route('users.list'));

        $response->assertStatus(401);
        $response->assertJsonPath('message', __('common.not_have_authority'));
    }

    private function createAssociation($count = 1)
    {
        $associations = Association::factory()->count($count)->create();

        return $associations;
    }

    private function createUser($association = null, $role = null, $count = 10)
    {
        if (!$role)
            $role = UserRoleKeyEnum::STUDENT->value;


        $users = User::factory()->count($count)->create([
            'role_id' => UserRole::where('key', $role)->first()->id,
            'association_id' => $association ? $association->id : null
        ]);

        return $users;

    }
}
