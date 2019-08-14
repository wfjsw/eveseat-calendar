<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Seat\Kassie\Calendar\Models\Pap;
use Seat\Kassie\Calendar\Models\Operation;
use Illuminate\Support\Facades\Schema;

class AddPapCountAndMigration extends Migration {

    public function up()
    {

        Schema::table('calendar_operations', function(Blueprint $table){

            $table->decimal('pap_count', 2, 1)->default(1.0);

        });

        Operation::chunk(100, function ($ops) {
            foreach ($ops as $op) {
                $op->pap_count = $op->tags->max('quantifier');
                if (is_null($op->pap_count)) $op->pap_count = 1.0;
                $op->save();
            }
        });
    }

    public function down()
    {

        Schema::table('calendar_operations', function(Blueprint $table){

            $table->dropColumn('pap_count');

        });
    }

}
