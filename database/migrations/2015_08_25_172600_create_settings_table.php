<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function __construct()
    {
        if (version_compare(Application::VERSION, '5.0', '>=')) {
            $this->tablename = Config::get('settings.table');
        } else {
            $this->tablename = Config::get('anlutro/l4-settings::table');
        }
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->index();
            $table->text('value');
            $table->engine = 'MYISAM';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->tablename);
    }
}