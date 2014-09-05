<?php
use Illuminate\Database\Migrations\Migration;

class EntrustPermissions extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Creates the permissions table
        Schema::create('permissions', function($table)
        {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->unique();
        });

        // Creates the permission_role (Many-to-Many relation) table
        Schema::create('permission_role', function($table)
        {
            $table->increments('id');
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->unique(array('permission_id','role_id'));
            $table->foreign('permission_id')->unsigned()->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('role_id')->unsigned()->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permission_role');
        Schema::drop('permissions');
    }

}
