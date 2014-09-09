<?php
use Illuminate\Database\Migrations\Migration;

class ConfideSetupUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        // waiting on feedback from github
        $foreign_prefix = '';//Config::get('database.connections.mysql.prefix', '');

        // Creates the users table
        Schema::create('users', function($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('username');
            $table->string('firstname');
            $table->string('lastname');
            $table->text('google_token');
            $table->string('email');
            $table->string('password');
            $table->string('confirmation_code');
            $table->string('remember_token')->nullable();
            $table->boolean('confirmed')->default(false);
            $table->timestamps();
        });


        // Creates password reminders table
        Schema::create('password_reminders', function($table)
        {
            $table->engine = 'InnoDB';
            $table->string('email');
            $table->string('token');
            $table->timestamp('created_at');
        });

        // Creates the roles table
        Schema::create('roles', function($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });


        // Creates the assigned_roles (Many-to-Many relation) table
        Schema::create('assigned_roles', function($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
        });
        Schema::table('assigned_roles', function($table) use($foreign_prefix) {
            $table->integer($foreign_prefix.'user_id')->unsigned();
            $table->integer($foreign_prefix.'role_id')->unsigned();
        });
        
        Schema::table('assigned_roles', function($table) use($foreign_prefix) {
            $table->foreign($foreign_prefix.'user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign($foreign_prefix.'role_id')->references('id')->on('roles')->onUpdate('cascade')->onDelete('cascade');
        });

        // Creates the permissions table
        Schema::create('permissions', function($table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->unique();
        });

        // Creates the permission_role (Many-to-Many relation) table
        Schema::create('permission_role', function($table) {
            $table->increments('id');
        });
        Schema::table('permission_role', function($table) use($foreign_prefix) {
            $table->integer($foreign_prefix.'permission_id')->unsigned();
            $table->integer($foreign_prefix.'role_id')->unsigned();
        });
        Schema::table('permission_role', function($table) use($foreign_prefix) {
            $table->unique(array($foreign_prefix.'permission_id', $foreign_prefix.'role_id'));
            $table->foreign($foreign_prefix.'permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign($foreign_prefix.'role_id')->references('id')->on('roles')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('password_reminders');
        Schema::drop('users');

        Schema::drop('assigned_roles');
        Schema::drop('roles');

        Schema::drop('permission_role');
        Schema::drop('permissions');
    }

}
