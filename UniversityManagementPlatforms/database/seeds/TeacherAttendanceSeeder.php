<?php

use Illuminate\Database\Seeder;
use App\TeacherAttendance;

class TeacherAttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(TeacherAttendance::class, 30)->create();
    }
}
