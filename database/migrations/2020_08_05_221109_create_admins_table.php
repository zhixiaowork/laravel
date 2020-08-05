<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('account')->default('')->comment('账号');
            $table->string('name')->default('')->comment('真实姓名');
            $table->string('email')->default('')->index()->comment('邮箱');
            $table->string('phone')->default('')->index()->comment('手机号');
            $table->integer('role_id')->default(0)->comment('角色ID');
            $table->string('role_name')->default('')->comment('角色');
            $table->string('password')->default('')->comment('密码');
            $table->rememberToken()->comment('记住密码');
            $table->string('token')->defalut('')->comment('token');
            $table->dateTime('expired_at')->nullable()->comment('token过期时间');
            $table->tinyInteger('status')->default(0)->comment('管理员状态(0:正常,1:不可登录)');
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
        Schema::dropIfExists('admins');
    }
}
