<?php

namespace Tests\Feature\Panel\DailyAttendance;

use App\Models\Association;
use App\Models\StudentClass;
use App\Models\User;
use App\Models\UserRole;
use App\Support\Enums\UserRoleKeyEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreDailyAttendanceTest extends TestCase
{

    public function testItStoreDailyAttendance()
    {
        $association  = $this->createAssociation();

        list($associationManager, $teacher)  = $this->createUsers($association);

        $this->actingAs($associationManager);

        $students = $this->createStudents($association, 5);

        $data = [
            'date' => now()->format('Y-m-d'),
            'users' => [
                ['id' => $students->first()->id, 'at_lesson' => true],
                ['id' => $students->skip(1)->first()->id, 'at_lesson' => false],
                ['id' => $students->skip(2)->first()->id, 'at_lesson' => true],
                ['id' => $students->skip(3)->first()->id, 'at_lesson' => true],
                ['id' => $students->skip(4)->first()->id, 'at_lesson' => false],
            ]
        ];


        $response = $this->postJson(route('daily-attendance.store'), $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('daily_attendances', [
            'user_id' => $data['users'][0]['id'],
            'at_lesson' => $data['users'][0]['at_lesson'],
            'class_id' => null,
            'processed_by' => $associationManager->id
        ]);

        $this->assertDatabaseCount('daily_attendances', 5);

    }

    public function testItStoreDailyAttendanceWithClassAndNote()
    {
        $association  = $this->createAssociation();

        list($associationManager, $teacher)  = $this->createUsers($association);

        $this->actingAs($associationManager);

        $classData = ['association_id' => $association->id, 'teacher_id' => $teacher->id, 'creator_id' => $associationManager->id];

        $studentClass = $this->createClass($classData);

        $students = $this->createStudents($association, 5);

        $data = [
            'date' => now()->format('Y-m-d'),
            'class_id' => $studentClass->id,
            'note' => 'Some text for the request',
            'users' => [
                ['id' => $students->first()->id, 'at_lesson' => true, 'note' => 'Some special note'],
                ['id' => $students->skip(1)->first()->id, 'at_lesson' => false],
                ['id' => $students->skip(2)->first()->id, 'at_lesson' => true],
                ['id' => $students->skip(3)->first()->id, 'at_lesson' => true],
                ['id' => $students->skip(4)->first()->id, 'at_lesson' => false],
            ]
        ];

        $response = $this->postJson(route('daily-attendance.store'), $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('daily_attendances', [
            'user_id' => $data['users'][0]['id'],
            'at_lesson' => $data['users'][0]['at_lesson'],
            'class_id' => $studentClass->id,
            'processed_by' => $associationManager->id,
            'note' => $data['users'][0]['note']
        ]);

        $this->assertDatabaseHas('daily_attendances', [
            'user_id' => $data['users'][1]['id'],
            'at_lesson' => $data['users'][1]['at_lesson'],
            'class_id' => $studentClass->id,
            'processed_by' => $associationManager->id,
            'note' => $data['note']
        ]);

        $this->assertDatabaseCount('daily_attendances', 5);

    }

    private function createAssociation($data = []){
        $association = Association::factory()
            ->state($data)
            ->create();

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

    private function createClass($data = []){
        return StudentClass::factory()->state($data)->create();
    }

    private function createStudents($association, $count = 1)
    {
        $students = User::factory()
            ->count($count)
            ->create([
            'role_id' => UserRole::where('key', UserRoleKeyEnum::STUDENT->value)->first()->id,
            'association_id' => $association->id
        ]);

        return $students;
    }
}
