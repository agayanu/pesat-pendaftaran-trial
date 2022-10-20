<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;

class RegistFake3Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $account = DB::table('tm_noaccounts')
                    ->select(
                        'account',
                        'account_min',
                        'account_max',
                        'account2',
                        'account2_min',
                        'account2_max',
                    )
                    ->first();
        $period  = 2022;
        $fams    = DB::table('tm_familymembers')->select('id')->get();
        $docs    = DB::table('tm_regist_documents')->select('id')->get();

        for ($i=0; $i < 366; $i++) {
            $randSchool   = DB::table('tm_schools')->select('id')->inRandomOrder()->first();
            $randGrade    = DB::table('tm_grades')->select('id')->inRandomOrder()->first();
            $randMajor    = DB::table('tm_majors')->select('id')->inRandomOrder()->first();
            $randReligion = DB::table('tm_religions')->select('id')->inRandomOrder()->first();
            do {
                $NoHPx = mt_rand(11111111, 99999999);
            } while (DB::table('registrations')->where('hp_student', 'like', '%'.$NoHPx.'%')->exists());
            do {
                $AccountNo2x = mt_rand($account->account2_min, $account->account2_max);
            } while (DB::table('registrations')->where('no_account2', 'like', '%'.$AccountNo2x.'%')->exists());
            $No_Daf_x   = DB::table('registrations')->where('period', $period)->max('no_regist');
            $No_Daf     = $No_Daf_x + 1;
            $No_Daf_str = str_pad($No_Daf, 4, "0", STR_PAD_LEFT);
            $genderx    = $faker->randomElement(['male', 'female']);
            $gender     = $genderx == 'male' ? 1 : 2;
            
            $noHP       = '0812'.$NoHPx; 
            $noHpParent = '0813'.$NoHPx; 
            $AccountNo  = NULL;
            $AccountNo2 = $account->account2.$AccountNo2x;
            $name       = $faker->name($genderx);
            $email      = $faker->unique()->safeEmail();
            $user       = 'operator@smapluspgri.sch.id';

            $idRegist   = DB::table('registrations')
                            ->insertGetId([
                                'period'        => $period,
                                'no_regist'     => $No_Daf_str,
                                'status'        => 1,
                                'grade'         => $randGrade->id,
                                'major'         => $randMajor->id,
                                'phase'         => 5,
                                'name'          => $name,
                                'religion'      => $randReligion->id,
                                'gender'        => $gender,
                                'hp_student'    => $noHP,
                                'hp_parent'     => $noHpParent,
                                'email_student' => $email,
                                'no_account'    => $AccountNo,
                                'no_account2'   => $AccountNo2,
                                'school'        => $randSchool->id,
                                'user'          => $user,
                                'created_at'    => now()
                            ]);

            foreach($fams as $f){
                DB::table('familys')->insert([
                    'id_regist'     => $idRegist,
                    'family_member' => $f->id,
                    'user'          => $user,
                    'created_at'    => now()
                ]);
            }
            
            foreach($docs as $d){
                DB::table('regist_documents')->insert([
                    'id_regist'  => $idRegist,
                    'document'   => $d->id,
                    'status'     => 'N',
                    'user'       => $user,
                    'created_at' => now()
                ]);
            }

            DB::table('familys')
            ->where([['id_regist', $idRegist], ['family_member', 1],])
            ->update([
                'name'       => $faker->name(),
                'updated_at' => now()
            ]);

            DB::table('users')->insert([
                'id_regist'  => $idRegist,
                'name'       => $name,
                'email'      => $email,
                'password'   => Hash::make('123456'),
                'created_at' => now()
            ]);
        }

        for ($i=0; $i < 48; $i++) {
            $randGrade    = DB::table('tm_grades')->select('id')->inRandomOrder()->first();
            $randMajor    = DB::table('tm_majors')->select('id')->inRandomOrder()->first();
            $randReligion = DB::table('tm_religions')->select('id')->inRandomOrder()->first();
            do {
                $NoHPx = mt_rand(11111111, 99999999);
            } while (DB::table('registrations')->where('hp_student', 'like', '%'.$NoHPx.'%')->exists());
            do {
                $AccountNo2x = mt_rand($account->account2_min, $account->account2_max);
            } while (DB::table('registrations')->where('no_account2', 'like', '%'.$AccountNo2x.'%')->exists());
            $No_Daf_x   = DB::table('registrations')->where('period', $period)->max('no_regist');
            $No_Daf     = $No_Daf_x + 1;
            $No_Daf_str = str_pad($No_Daf, 4, "0", STR_PAD_LEFT);
            $genderx    = $faker->randomElement(['male', 'female']);
            $gender     = $genderx == 'male' ? 1 : 2;
            
            
            $noHP       = '0812'.$NoHPx; 
            $noHpParent = '0813'.$NoHPx; 
            $AccountNo  = NULL;
            $AccountNo2 = $account->account2.$AccountNo2x;
            $name       = $faker->name($genderx);
            $email      = $faker->unique()->safeEmail();
            $user       = 'operator@smapluspgri.sch.id';

            $idRegist   = DB::table('registrations')
                            ->insertGetId([
                                'period'        => $period,
                                'no_regist'     => $No_Daf_str,
                                'status'        => 1,
                                'grade'         => $randGrade->id,
                                'major'         => $randMajor->id,
                                'phase'         => 5,
                                'name'          => $name,
                                'religion'      => $randReligion->id,
                                'gender'        => $gender,
                                'hp_student'    => $noHP,
                                'hp_parent'     => $noHpParent,
                                'email_student' => $email,
                                'no_account'    => $AccountNo,
                                'no_account2'   => $AccountNo2,
                                'school'        => 1981,
                                'user'          => $user,
                                'created_at'    => now()
                            ]);

            foreach($fams as $f){
                DB::table('familys')->insert([
                    'id_regist'     => $idRegist,
                    'family_member' => $f->id,
                    'user'          => $user,
                    'created_at'    => now()
                ]);
            }
            
            foreach($docs as $d){
                DB::table('regist_documents')->insert([
                    'id_regist'  => $idRegist,
                    'document'   => $d->id,
                    'status'     => 'N',
                    'user'       => $user,
                    'created_at' => now()
                ]);
            }

            DB::table('familys')
            ->where([['id_regist', $idRegist], ['family_member', 1],])
            ->update([
                'name'       => $faker->name(),
                'updated_at' => now()
            ]);

            DB::table('users')->insert([
                'id_regist'  => $idRegist,
                'name'       => $name,
                'email'      => $email,
                'password'   => Hash::make('123456'),
                'created_at' => now()
            ]);
        }

        for ($i=0; $i < 40; $i++) {
            $randGrade    = DB::table('tm_grades')->select('id')->inRandomOrder()->first();
            $randMajor    = DB::table('tm_majors')->select('id')->inRandomOrder()->first();
            $randReligion = DB::table('tm_religions')->select('id')->inRandomOrder()->first();
            do {
                $NoHPx = mt_rand(11111111, 99999999);
            } while (DB::table('registrations')->where('hp_student', 'like', '%'.$NoHPx.'%')->exists());
            do {
                $AccountNo2x = mt_rand($account->account2_min, $account->account2_max);
            } while (DB::table('registrations')->where('no_account2', 'like', '%'.$AccountNo2x.'%')->exists());
            $No_Daf_x   = DB::table('registrations')->where('period', $period)->max('no_regist');
            $No_Daf     = $No_Daf_x + 1;
            $No_Daf_str = str_pad($No_Daf, 4, "0", STR_PAD_LEFT);
            $genderx    = $faker->randomElement(['male', 'female']);
            $gender     = $genderx == 'male' ? 1 : 2;
            
            
            $noHP       = '0812'.$NoHPx; 
            $noHpParent = '0813'.$NoHPx; 
            $AccountNo  = NULL;
            $AccountNo2 = $account->account2.$AccountNo2x;
            $name       = $faker->name($genderx);
            $email      = $faker->unique()->safeEmail();
            $user       = 'operator@smapluspgri.sch.id';

            $idRegist   = DB::table('registrations')
                            ->insertGetId([
                                'period'        => $period,
                                'no_regist'     => $No_Daf_str,
                                'status'        => 1,
                                'grade'         => $randGrade->id,
                                'major'         => $randMajor->id,
                                'phase'         => 5,
                                'name'          => $name,
                                'religion'      => $randReligion->id,
                                'gender'        => $gender,
                                'hp_student'    => $noHP,
                                'hp_parent'     => $noHpParent,
                                'email_student' => $email,
                                'no_account'    => $AccountNo,
                                'no_account2'   => $AccountNo2,
                                'school'        => 1965,
                                'user'          => $user,
                                'created_at'    => now()
                            ]);

            foreach($fams as $f){
                DB::table('familys')->insert([
                    'id_regist'     => $idRegist,
                    'family_member' => $f->id,
                    'user'          => $user,
                    'created_at'    => now()
                ]);
            }
            
            foreach($docs as $d){
                DB::table('regist_documents')->insert([
                    'id_regist'  => $idRegist,
                    'document'   => $d->id,
                    'status'     => 'N',
                    'user'       => $user,
                    'created_at' => now()
                ]);
            }

            DB::table('familys')
            ->where([['id_regist', $idRegist], ['family_member', 1],])
            ->update([
                'name'       => $faker->name(),
                'updated_at' => now()
            ]);

            DB::table('users')->insert([
                'id_regist'  => $idRegist,
                'name'       => $name,
                'email'      => $email,
                'password'   => Hash::make('123456'),
                'created_at' => now()
            ]);
        }

        for ($i=0; $i < 36; $i++) {
            $randGrade    = DB::table('tm_grades')->select('id')->inRandomOrder()->first();
            $randMajor    = DB::table('tm_majors')->select('id')->inRandomOrder()->first();
            $randReligion = DB::table('tm_religions')->select('id')->inRandomOrder()->first();
            do {
                $NoHPx = mt_rand(11111111, 99999999);
            } while (DB::table('registrations')->where('hp_student', 'like', '%'.$NoHPx.'%')->exists());
            do {
                $AccountNo2x = mt_rand($account->account2_min, $account->account2_max);
            } while (DB::table('registrations')->where('no_account2', 'like', '%'.$AccountNo2x.'%')->exists());
            $No_Daf_x   = DB::table('registrations')->where('period', $period)->max('no_regist');
            $No_Daf     = $No_Daf_x + 1;
            $No_Daf_str = str_pad($No_Daf, 4, "0", STR_PAD_LEFT);
            $genderx    = $faker->randomElement(['male', 'female']);
            $gender     = $genderx == 'male' ? 1 : 2;
            
            
            $noHP       = '0812'.$NoHPx; 
            $noHpParent = '0813'.$NoHPx; 
            $AccountNo  = NULL;
            $AccountNo2 = $account->account2.$AccountNo2x;
            $name       = $faker->name($genderx);
            $email      = $faker->unique()->safeEmail();
            $user       = 'operator@smapluspgri.sch.id';

            $idRegist   = DB::table('registrations')
                            ->insertGetId([
                                'period'        => $period,
                                'no_regist'     => $No_Daf_str,
                                'status'        => 1,
                                'grade'         => $randGrade->id,
                                'major'         => $randMajor->id,
                                'phase'         => 5,
                                'name'          => $name,
                                'religion'      => $randReligion->id,
                                'gender'        => $gender,
                                'hp_student'    => $noHP,
                                'hp_parent'     => $noHpParent,
                                'email_student' => $email,
                                'no_account'    => $AccountNo,
                                'no_account2'   => $AccountNo2,
                                'school'        => 7142,
                                'user'          => $user,
                                'created_at'    => now()
                            ]);

            foreach($fams as $f){
                DB::table('familys')->insert([
                    'id_regist'     => $idRegist,
                    'family_member' => $f->id,
                    'user'          => $user,
                    'created_at'    => now()
                ]);
            }
            
            foreach($docs as $d){
                DB::table('regist_documents')->insert([
                    'id_regist'  => $idRegist,
                    'document'   => $d->id,
                    'status'     => 'N',
                    'user'       => $user,
                    'created_at' => now()
                ]);
            }

            DB::table('familys')
            ->where([['id_regist', $idRegist], ['family_member', 1],])
            ->update([
                'name'       => $faker->name(),
                'updated_at' => now()
            ]);

            DB::table('users')->insert([
                'id_regist'  => $idRegist,
                'name'       => $name,
                'email'      => $email,
                'password'   => Hash::make('123456'),
                'created_at' => now()
            ]);
        }

        for ($i=0; $i < 33; $i++) {
            $randGrade    = DB::table('tm_grades')->select('id')->inRandomOrder()->first();
            $randMajor    = DB::table('tm_majors')->select('id')->inRandomOrder()->first();
            $randReligion = DB::table('tm_religions')->select('id')->inRandomOrder()->first();
            do {
                $NoHPx = mt_rand(11111111, 99999999);
            } while (DB::table('registrations')->where('hp_student', 'like', '%'.$NoHPx.'%')->exists());
            do {
                $AccountNo2x = mt_rand($account->account2_min, $account->account2_max);
            } while (DB::table('registrations')->where('no_account2', 'like', '%'.$AccountNo2x.'%')->exists());
            $No_Daf_x   = DB::table('registrations')->where('period', $period)->max('no_regist');
            $No_Daf     = $No_Daf_x + 1;
            $No_Daf_str = str_pad($No_Daf, 4, "0", STR_PAD_LEFT);
            $genderx    = $faker->randomElement(['male', 'female']);
            $gender     = $genderx == 'male' ? 1 : 2;
            
            
            $noHP       = '0812'.$NoHPx; 
            $noHpParent = '0813'.$NoHPx; 
            $AccountNo  = NULL;
            $AccountNo2 = $account->account2.$AccountNo2x;
            $name       = $faker->name($genderx);
            $email      = $faker->unique()->safeEmail();
            $user       = 'operator@smapluspgri.sch.id';

            $idRegist   = DB::table('registrations')
                            ->insertGetId([
                                'period'        => $period,
                                'no_regist'     => $No_Daf_str,
                                'status'        => 1,
                                'grade'         => $randGrade->id,
                                'major'         => $randMajor->id,
                                'phase'         => 5,
                                'name'          => $name,
                                'religion'      => $randReligion->id,
                                'gender'        => $gender,
                                'hp_student'    => $noHP,
                                'hp_parent'     => $noHpParent,
                                'email_student' => $email,
                                'no_account'    => $AccountNo,
                                'no_account2'   => $AccountNo2,
                                'school'        => 1957,
                                'user'          => $user,
                                'created_at'    => now()
                            ]);

            foreach($fams as $f){
                DB::table('familys')->insert([
                    'id_regist'     => $idRegist,
                    'family_member' => $f->id,
                    'user'          => $user,
                    'created_at'    => now()
                ]);
            }
            
            foreach($docs as $d){
                DB::table('regist_documents')->insert([
                    'id_regist'  => $idRegist,
                    'document'   => $d->id,
                    'status'     => 'N',
                    'user'       => $user,
                    'created_at' => now()
                ]);
            }

            DB::table('familys')
            ->where([['id_regist', $idRegist], ['family_member', 1],])
            ->update([
                'name'       => $faker->name(),
                'updated_at' => now()
            ]);

            DB::table('users')->insert([
                'id_regist'  => $idRegist,
                'name'       => $name,
                'email'      => $email,
                'password'   => Hash::make('123456'),
                'created_at' => now()
            ]);
        }

        for ($i=0; $i < 32; $i++) {
            $randGrade    = DB::table('tm_grades')->select('id')->inRandomOrder()->first();
            $randMajor    = DB::table('tm_majors')->select('id')->inRandomOrder()->first();
            $randReligion = DB::table('tm_religions')->select('id')->inRandomOrder()->first();
            do {
                $NoHPx = mt_rand(11111111, 99999999);
            } while (DB::table('registrations')->where('hp_student', 'like', '%'.$NoHPx.'%')->exists());
            do {
                $AccountNo2x = mt_rand($account->account2_min, $account->account2_max);
            } while (DB::table('registrations')->where('no_account2', 'like', '%'.$AccountNo2x.'%')->exists());
            $No_Daf_x   = DB::table('registrations')->where('period', $period)->max('no_regist');
            $No_Daf     = $No_Daf_x + 1;
            $No_Daf_str = str_pad($No_Daf, 4, "0", STR_PAD_LEFT);
            $genderx    = $faker->randomElement(['male', 'female']);
            $gender     = $genderx == 'male' ? 1 : 2;
            
            
            $noHP       = '0812'.$NoHPx; 
            $noHpParent = '0813'.$NoHPx; 
            $AccountNo  = NULL;
            $AccountNo2 = $account->account2.$AccountNo2x;
            $name       = $faker->name($genderx);
            $email      = $faker->unique()->safeEmail();
            $user       = 'operator@smapluspgri.sch.id';

            $idRegist   = DB::table('registrations')
                            ->insertGetId([
                                'period'        => $period,
                                'no_regist'     => $No_Daf_str,
                                'status'        => 1,
                                'grade'         => $randGrade->id,
                                'major'         => $randMajor->id,
                                'phase'         => 5,
                                'name'          => $name,
                                'religion'      => $randReligion->id,
                                'gender'        => $gender,
                                'hp_student'    => $noHP,
                                'hp_parent'     => $noHpParent,
                                'email_student' => $email,
                                'no_account'    => $AccountNo,
                                'no_account2'   => $AccountNo2,
                                'school'        => 1978,
                                'user'          => $user,
                                'created_at'    => now()
                            ]);

            foreach($fams as $f){
                DB::table('familys')->insert([
                    'id_regist'     => $idRegist,
                    'family_member' => $f->id,
                    'user'          => $user,
                    'created_at'    => now()
                ]);
            }
            
            foreach($docs as $d){
                DB::table('regist_documents')->insert([
                    'id_regist'  => $idRegist,
                    'document'   => $d->id,
                    'status'     => 'N',
                    'user'       => $user,
                    'created_at' => now()
                ]);
            }

            DB::table('familys')
            ->where([['id_regist', $idRegist], ['family_member', 1],])
            ->update([
                'name'       => $faker->name(),
                'updated_at' => now()
            ]);

            DB::table('users')->insert([
                'id_regist'  => $idRegist,
                'name'       => $name,
                'email'      => $email,
                'password'   => Hash::make('123456'),
                'created_at' => now()
            ]);
        }

        for ($i=0; $i < 29; $i++) {
            $randGrade    = DB::table('tm_grades')->select('id')->inRandomOrder()->first();
            $randMajor    = DB::table('tm_majors')->select('id')->inRandomOrder()->first();
            $randReligion = DB::table('tm_religions')->select('id')->inRandomOrder()->first();
            do {
                $NoHPx = mt_rand(11111111, 99999999);
            } while (DB::table('registrations')->where('hp_student', 'like', '%'.$NoHPx.'%')->exists());
            do {
                $AccountNo2x = mt_rand($account->account2_min, $account->account2_max);
            } while (DB::table('registrations')->where('no_account2', 'like', '%'.$AccountNo2x.'%')->exists());
            $No_Daf_x   = DB::table('registrations')->where('period', $period)->max('no_regist');
            $No_Daf     = $No_Daf_x + 1;
            $No_Daf_str = str_pad($No_Daf, 4, "0", STR_PAD_LEFT);
            $genderx    = $faker->randomElement(['male', 'female']);
            $gender     = $genderx == 'male' ? 1 : 2;
            
            
            $noHP       = '0812'.$NoHPx; 
            $noHpParent = '0813'.$NoHPx; 
            $AccountNo  = NULL;
            $AccountNo2 = $account->account2.$AccountNo2x;
            $name       = $faker->name($genderx);
            $email      = $faker->unique()->safeEmail();
            $user       = 'operator@smapluspgri.sch.id';

            $idRegist   = DB::table('registrations')
                            ->insertGetId([
                                'period'        => $period,
                                'no_regist'     => $No_Daf_str,
                                'status'        => 1,
                                'grade'         => $randGrade->id,
                                'major'         => $randMajor->id,
                                'phase'         => 5,
                                'name'          => $name,
                                'religion'      => $randReligion->id,
                                'gender'        => $gender,
                                'hp_student'    => $noHP,
                                'hp_parent'     => $noHpParent,
                                'email_student' => $email,
                                'no_account'    => $AccountNo,
                                'no_account2'   => $AccountNo2,
                                'school'        => 1977,
                                'user'          => $user,
                                'created_at'    => now()
                            ]);

            foreach($fams as $f){
                DB::table('familys')->insert([
                    'id_regist'     => $idRegist,
                    'family_member' => $f->id,
                    'user'          => $user,
                    'created_at'    => now()
                ]);
            }
            
            foreach($docs as $d){
                DB::table('regist_documents')->insert([
                    'id_regist'  => $idRegist,
                    'document'   => $d->id,
                    'status'     => 'N',
                    'user'       => $user,
                    'created_at' => now()
                ]);
            }

            DB::table('familys')
            ->where([['id_regist', $idRegist], ['family_member', 1],])
            ->update([
                'name'       => $faker->name(),
                'updated_at' => now()
            ]);

            DB::table('users')->insert([
                'id_regist'  => $idRegist,
                'name'       => $name,
                'email'      => $email,
                'password'   => Hash::make('123456'),
                'created_at' => now()
            ]);
        }

        for ($i=0; $i < 27; $i++) {
            $randGrade    = DB::table('tm_grades')->select('id')->inRandomOrder()->first();
            $randMajor    = DB::table('tm_majors')->select('id')->inRandomOrder()->first();
            $randReligion = DB::table('tm_religions')->select('id')->inRandomOrder()->first();
            do {
                $NoHPx = mt_rand(11111111, 99999999);
            } while (DB::table('registrations')->where('hp_student', 'like', '%'.$NoHPx.'%')->exists());
            do {
                $AccountNo2x = mt_rand($account->account2_min, $account->account2_max);
            } while (DB::table('registrations')->where('no_account2', 'like', '%'.$AccountNo2x.'%')->exists());
            $No_Daf_x   = DB::table('registrations')->where('period', $period)->max('no_regist');
            $No_Daf     = $No_Daf_x + 1;
            $No_Daf_str = str_pad($No_Daf, 4, "0", STR_PAD_LEFT);
            $genderx    = $faker->randomElement(['male', 'female']);
            $gender     = $genderx == 'male' ? 1 : 2;
            
            
            $noHP       = '0812'.$NoHPx; 
            $noHpParent = '0813'.$NoHPx; 
            $AccountNo  = NULL;
            $AccountNo2 = $account->account2.$AccountNo2x;
            $name       = $faker->name($genderx);
            $email      = $faker->unique()->safeEmail();
            $user       = 'operator@smapluspgri.sch.id';

            $idRegist   = DB::table('registrations')
                            ->insertGetId([
                                'period'        => $period,
                                'no_regist'     => $No_Daf_str,
                                'status'        => 1,
                                'grade'         => $randGrade->id,
                                'major'         => $randMajor->id,
                                'phase'         => 5,
                                'name'          => $name,
                                'religion'      => $randReligion->id,
                                'gender'        => $gender,
                                'hp_student'    => $noHP,
                                'hp_parent'     => $noHpParent,
                                'email_student' => $email,
                                'no_account'    => $AccountNo,
                                'no_account2'   => $AccountNo2,
                                'school'        => 1979,
                                'user'          => $user,
                                'created_at'    => now()
                            ]);

            foreach($fams as $f){
                DB::table('familys')->insert([
                    'id_regist'     => $idRegist,
                    'family_member' => $f->id,
                    'user'          => $user,
                    'created_at'    => now()
                ]);
            }
            
            foreach($docs as $d){
                DB::table('regist_documents')->insert([
                    'id_regist'  => $idRegist,
                    'document'   => $d->id,
                    'status'     => 'N',
                    'user'       => $user,
                    'created_at' => now()
                ]);
            }

            DB::table('familys')
            ->where([['id_regist', $idRegist], ['family_member', 1],])
            ->update([
                'name'       => $faker->name(),
                'updated_at' => now()
            ]);

            DB::table('users')->insert([
                'id_regist'  => $idRegist,
                'name'       => $name,
                'email'      => $email,
                'password'   => Hash::make('123456'),
                'created_at' => now()
            ]);
        }

        for ($i=0; $i < 18; $i++) {
            $randGrade    = DB::table('tm_grades')->select('id')->inRandomOrder()->first();
            $randMajor    = DB::table('tm_majors')->select('id')->inRandomOrder()->first();
            $randReligion = DB::table('tm_religions')->select('id')->inRandomOrder()->first();
            do {
                $NoHPx = mt_rand(11111111, 99999999);
            } while (DB::table('registrations')->where('hp_student', 'like', '%'.$NoHPx.'%')->exists());
            do {
                $AccountNo2x = mt_rand($account->account2_min, $account->account2_max);
            } while (DB::table('registrations')->where('no_account2', 'like', '%'.$AccountNo2x.'%')->exists());
            $No_Daf_x   = DB::table('registrations')->where('period', $period)->max('no_regist');
            $No_Daf     = $No_Daf_x + 1;
            $No_Daf_str = str_pad($No_Daf, 4, "0", STR_PAD_LEFT);
            $genderx    = $faker->randomElement(['male', 'female']);
            $gender     = $genderx == 'male' ? 1 : 2;
            
            
            $noHP       = '0812'.$NoHPx; 
            $noHpParent = '0813'.$NoHPx; 
            $AccountNo  = NULL;
            $AccountNo2 = $account->account2.$AccountNo2x;
            $name       = $faker->name($genderx);
            $email      = $faker->unique()->safeEmail();
            $user       = 'operator@smapluspgri.sch.id';

            $idRegist   = DB::table('registrations')
                            ->insertGetId([
                                'period'        => $period,
                                'no_regist'     => $No_Daf_str,
                                'status'        => 1,
                                'grade'         => $randGrade->id,
                                'major'         => $randMajor->id,
                                'phase'         => 5,
                                'name'          => $name,
                                'religion'      => $randReligion->id,
                                'gender'        => $gender,
                                'hp_student'    => $noHP,
                                'hp_parent'     => $noHpParent,
                                'email_student' => $email,
                                'no_account'    => $AccountNo,
                                'no_account2'   => $AccountNo2,
                                'school'        => 1947,
                                'user'          => $user,
                                'created_at'    => now()
                            ]);

            foreach($fams as $f){
                DB::table('familys')->insert([
                    'id_regist'     => $idRegist,
                    'family_member' => $f->id,
                    'user'          => $user,
                    'created_at'    => now()
                ]);
            }
            
            foreach($docs as $d){
                DB::table('regist_documents')->insert([
                    'id_regist'  => $idRegist,
                    'document'   => $d->id,
                    'status'     => 'N',
                    'user'       => $user,
                    'created_at' => now()
                ]);
            }

            DB::table('familys')
            ->where([['id_regist', $idRegist], ['family_member', 1],])
            ->update([
                'name'       => $faker->name(),
                'updated_at' => now()
            ]);

            DB::table('users')->insert([
                'id_regist'  => $idRegist,
                'name'       => $name,
                'email'      => $email,
                'password'   => Hash::make('123456'),
                'created_at' => now()
            ]);
        }

        for ($i=0; $i < 10; $i++) {
            $randGrade    = DB::table('tm_grades')->select('id')->inRandomOrder()->first();
            $randMajor    = DB::table('tm_majors')->select('id')->inRandomOrder()->first();
            $randReligion = DB::table('tm_religions')->select('id')->inRandomOrder()->first();
            do {
                $NoHPx = mt_rand(11111111, 99999999);
            } while (DB::table('registrations')->where('hp_student', 'like', '%'.$NoHPx.'%')->exists());
            do {
                $AccountNo2x = mt_rand($account->account2_min, $account->account2_max);
            } while (DB::table('registrations')->where('no_account2', 'like', '%'.$AccountNo2x.'%')->exists());
            $No_Daf_x   = DB::table('registrations')->where('period', $period)->max('no_regist');
            $No_Daf     = $No_Daf_x + 1;
            $No_Daf_str = str_pad($No_Daf, 4, "0", STR_PAD_LEFT);
            $genderx    = $faker->randomElement(['male', 'female']);
            $gender     = $genderx == 'male' ? 1 : 2;
            
            
            $noHP       = '0812'.$NoHPx; 
            $noHpParent = '0813'.$NoHPx; 
            $AccountNo  = NULL;
            $AccountNo2 = $account->account2.$AccountNo2x;
            $name       = $faker->name($genderx);
            $email      = $faker->unique()->safeEmail();
            $user       = 'operator@smapluspgri.sch.id';

            $idRegist   = DB::table('registrations')
                            ->insertGetId([
                                'period'        => $period,
                                'no_regist'     => $No_Daf_str,
                                'status'        => 1,
                                'grade'         => $randGrade->id,
                                'major'         => $randMajor->id,
                                'phase'         => 5,
                                'name'          => $name,
                                'religion'      => $randReligion->id,
                                'gender'        => $gender,
                                'hp_student'    => $noHP,
                                'hp_parent'     => $noHpParent,
                                'email_student' => $email,
                                'no_account'    => $AccountNo,
                                'no_account2'   => $AccountNo2,
                                'school'        => 7143,
                                'user'          => $user,
                                'created_at'    => now()
                            ]);

            foreach($fams as $f){
                DB::table('familys')->insert([
                    'id_regist'     => $idRegist,
                    'family_member' => $f->id,
                    'user'          => $user,
                    'created_at'    => now()
                ]);
            }
            
            foreach($docs as $d){
                DB::table('regist_documents')->insert([
                    'id_regist'  => $idRegist,
                    'document'   => $d->id,
                    'status'     => 'N',
                    'user'       => $user,
                    'created_at' => now()
                ]);
            }

            DB::table('familys')
            ->where([['id_regist', $idRegist], ['family_member', 1],])
            ->update([
                'name'       => $faker->name(),
                'updated_at' => now()
            ]);

            DB::table('users')->insert([
                'id_regist'  => $idRegist,
                'name'       => $name,
                'email'      => $email,
                'password'   => Hash::make('123456'),
                'created_at' => now()
            ]);
        }

        for ($i=0; $i < 8; $i++) {
            $randGrade    = DB::table('tm_grades')->select('id')->inRandomOrder()->first();
            $randMajor    = DB::table('tm_majors')->select('id')->inRandomOrder()->first();
            $randReligion = DB::table('tm_religions')->select('id')->inRandomOrder()->first();
            do {
                $NoHPx = mt_rand(11111111, 99999999);
            } while (DB::table('registrations')->where('hp_student', 'like', '%'.$NoHPx.'%')->exists());
            do {
                $AccountNo2x = mt_rand($account->account2_min, $account->account2_max);
            } while (DB::table('registrations')->where('no_account2', 'like', '%'.$AccountNo2x.'%')->exists());
            $No_Daf_x   = DB::table('registrations')->where('period', $period)->max('no_regist');
            $No_Daf     = $No_Daf_x + 1;
            $No_Daf_str = str_pad($No_Daf, 4, "0", STR_PAD_LEFT);
            $genderx    = $faker->randomElement(['male', 'female']);
            $gender     = $genderx == 'male' ? 1 : 2;
            
            
            $noHP       = '0812'.$NoHPx; 
            $noHpParent = '0813'.$NoHPx; 
            $AccountNo  = NULL;
            $AccountNo2 = $account->account2.$AccountNo2x;
            $name       = $faker->name($genderx);
            $email      = $faker->unique()->safeEmail();
            $user       = 'operator@smapluspgri.sch.id';

            $idRegist   = DB::table('registrations')
                            ->insertGetId([
                                'period'        => $period,
                                'no_regist'     => $No_Daf_str,
                                'status'        => 1,
                                'grade'         => $randGrade->id,
                                'major'         => $randMajor->id,
                                'phase'         => 5,
                                'name'          => $name,
                                'religion'      => $randReligion->id,
                                'gender'        => $gender,
                                'hp_student'    => $noHP,
                                'hp_parent'     => $noHpParent,
                                'email_student' => $email,
                                'no_account'    => $AccountNo,
                                'no_account2'   => $AccountNo2,
                                'school'        => 7188,
                                'user'          => $user,
                                'created_at'    => now()
                            ]);

            foreach($fams as $f){
                DB::table('familys')->insert([
                    'id_regist'     => $idRegist,
                    'family_member' => $f->id,
                    'user'          => $user,
                    'created_at'    => now()
                ]);
            }
            
            foreach($docs as $d){
                DB::table('regist_documents')->insert([
                    'id_regist'  => $idRegist,
                    'document'   => $d->id,
                    'status'     => 'N',
                    'user'       => $user,
                    'created_at' => now()
                ]);
            }

            DB::table('familys')
            ->where([['id_regist', $idRegist], ['family_member', 1],])
            ->update([
                'name'       => $faker->name(),
                'updated_at' => now()
            ]);

            DB::table('users')->insert([
                'id_regist'  => $idRegist,
                'name'       => $name,
                'email'      => $email,
                'password'   => Hash::make('123456'),
                'created_at' => now()
            ]);
        }
    }
}
