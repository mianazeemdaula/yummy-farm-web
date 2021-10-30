<?php

use App\Models\Student;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tutor;
use App\Models\TutorVideos;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'tutor']);
        Role::create(['name' => 'student']);

        $superAdmin = User::insert([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $superAdmin = User::find(1);
        $superAdmin->assignRole('super-admin');

        $admin = User::insert([
            'name' => 'Admin One',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $admin = User::find(2);
        $admin->assignRole('admin');

        $user = User::insert([
            'name' => 'Alexander Trub',
            'email' => 'tutor@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $user = User::find(3);
        $user->assignRole('tutor');
        $tutor = new Tutor();
        $tutor->bio = 'hi bio';
        $tutor->in_search = false;
        $tutor->save();
        $tutor->user()->save($user);
        $user->instruments()->sync([1,2,4,5]);
        $videos = [new TutorVideos(['url' => 'https://www.youtube.com/watch?v=Dpv6lUKNL9o'])];
        $user->tutorVideos()->saveMany($videos);
        $user->languages()->sync([1,3]);


        $user = User::insert([
            'name' => 'Danial Sundin',
            'email' => 'tutor2@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $user = User::find(4);
        $user->assignRole('tutor');
        $tutor = new Tutor();
        $tutor->bio = 'A graduate of the slsdl fd sl';
        $tutor->save();
        $tutor->user()->save($user);
        $user->instruments()->sync([1,4,3,6]);
        $videos = [new TutorVideos(['url' => 'https://www.youtube.com/watch?v=HyOtpmCUOCM']), new TutorVideos(['url' => 'https://www.youtube.com/watch?v=fwObwGKIeSo'])];
        $user->tutorVideos()->saveMany($videos);
        $user->languages()->sync([1,2]);


        // User

        $user = User::insert([
            'name' => 'John Ell',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $user = User::find(5);
        $user->assignRole('student');
        $student = new Student();
        $student->save();
        $student->user()->save($user);
    }
}
