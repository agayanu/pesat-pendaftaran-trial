<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SchoolInfoSeeder::class,
            SchoolInfoSosmedSeeder::class,
            TmAchievementGroupSeeder::class,
            TmAchievementLevelSeeder::class,
            TmAchievementRankSeeder::class,
            TmBloodSeeder::class,
            TmCitizenSeeder::class,
            TmCitySeeder::class,
            TmCostRegistrationSeeder::class,
            TmDeadSeeder::class,
            TmDistricSeeder::class,
            TmEducationSeeder::class,
            TmFamilyMemberSeeder::class,
            TmFamilyStatusSeeder::class,
            TmGenderSeeder::class,
            TmGradeSeeder::class,
            TmHotlineSeeder::class,
            TmHotlineTypeSeeder::class,
            TmIncomeSeeder::class,
            TmJobSeeder::class,
            TmMajorSeeder::class,
            TmNoAccountSeeder::class,
            TmPayMethodSeeder::class,
            TmPeriodSeeder::class,
            TmPhaseRegistrationSeeder::class,
            TmProvinceSeeder::class,
            TmRegistDocumentSeeder::class,
            TmReligionSeeder::class,
            TmSchool2Seeder::class,
            TmSchool3Seeder::class,
            TmSchool4Seeder::class,
            TmSchool5Seeder::class,
            TmSchool6Seeder::class,
            TmSchool7Seeder::class,
            TmSchoolSeeder::class,
            TmSelectionSeeder::class,
            TmStatusSeeder::class,
            TmStaySeeder::class,
            TmTransportSeeder::class,
            UserSeeder::class,
            TmResignSeeder::class,
            CostPaymentDetailMasterSeeder::class,
            CostPaymentSeeder::class,
            CostPaymentDetailSeeder::class,
            RegistFakeSeeder::class,
            RegistFake2Seeder::class,
            RegistFake3Seeder::class,
            ReceiveSeeder::class,
            Receive2Seeder::class,
            Receive3Seeder::class,
            PayBillSeeder::class,
            PayBill2Seeder::class,
            PayBill3Seeder::class,
            PaySeeder::class,
            Pay2Seeder::class,
            Pay3Seeder::class,
            ResignSeeder::class,
            Resign2Seeder::class,
            Resign3Seeder::class,
        ]);
    }
}
