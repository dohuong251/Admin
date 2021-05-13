<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportRuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_rule', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name");
            $table->integer("status")->comment("1: lấy và chạy được link, 2: lấy được link nhưng không chạy được, 3: không lấy được link");
            $table->text("url");
            $table->text("parse_url");
            $table->json("log");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_rule');
    }
}
