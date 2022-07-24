<?php

namespace Tests\Feature\Panel;

use App\Models\Association;
use App\Models\User;
use App\Models\UserRole;
use App\Support\Enums\UserRoleKeyEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreDailyAttendanceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testItStoreDailyAttendance()
    {
        $association  = $this->createAssociation();

        list($associationManager, $teacher)  = $this->createUsers($association);
        $this->actingAs($associationManager);

        $data = [
            'date' => now()->format('Y-m-d'),
            'users' => [
                ['id' => 1, 'at_lesson' => true],
                ['id' => 2, 'at_lesson' => false],
                ['id' => 2, 'at_lesson' => true],
                ['id' => 3, 'at_lesson' => true],
                ['id' => 4, 'at_lesson' => false],
            ]
        ];

        $response = $this->postJson(route('daily-attendance.store'), $data);

        $response->dd();
        $response->assertStatus(200);
    }

    private function createAssociation(){
        $association = Association::factory()->create();

        return $association;
    }

    private function createUsers($association){
        $associationManager = User::factory()->create([
            'role_id' => UserRole::where('key', UserRoleKeyEnum::ASSOCIATION_MANAGER->value)->first()->id,
            'association_id' => $association->id
        ]);

        $teacher = User::factory()->create([
            'role_id' => UserRole::where('key', UserRoleKeyEnum::TEACHER->value)->first()->id,
            'association_id' => $association->id
        ]);

        return [$associationManager, $teacher];
    }
}
