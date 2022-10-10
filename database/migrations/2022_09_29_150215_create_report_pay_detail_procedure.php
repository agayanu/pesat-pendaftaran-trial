<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportPayDetailProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = 'CREATE PROCEDURE report_pay_detail(IN period int)
                    BEGIN         
                        SET @sql = NULL;
                        SELECT
                            GROUP_CONCAT(DISTINCT
                                CONCAT(
                                    "AVG(IF(e.name = """,e.name,""", c.amount, NULL)) AS ",CONCAT("\'",e.name,"\'")
                                )
                            ) INTO @sql
                        FROM registrations AS a 
                        INNER JOIN tr_pay as b ON a.id=b.id_regist
                        INNER JOIN tr_pay_details AS c ON b.id=c.id_pay
                        INNER JOIN tm_cost_payment_details AS d ON c.id_cost_payment_detail=d.id
                        INNER JOIN tm_cost_payment_detail_masters AS e ON d.id_detail_master=e.id
                        WHERE a.period=period;
                        SET @sql = CONCAT("SELECT a.no_regist, a.name as name_regist, ", @sql, " FROM registrations AS a                
                                        INNER JOIN tr_pay as b ON a.id=b.id_regist
                                        INNER JOIN tr_pay_details AS c ON b.id=c.id_pay
                                        INNER JOIN tm_cost_payment_details AS d ON c.id_cost_payment_detail=d.id
                                        INNER JOIN tm_cost_payment_detail_masters AS e ON d.id_detail_master=e.id                  
                                        WHERE a.period= period GROUP BY no_regist, name_regist ORDER BY no_regist");
                        PREPARE stmt FROM @sql;
                        EXECUTE stmt;
                    END';
  
        DB::unprepared("DROP procedure IF EXISTS report_pay_detail");
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
