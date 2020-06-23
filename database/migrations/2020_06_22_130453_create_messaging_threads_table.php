<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagingThreadsTable extends Migration {

	// -- Run the migrations.
	public function up()
	{
        $tableName = config('messenger.db.threads_table');

        if (empty($tableName)) {
            throw new \Exception('Error: config/messenger.php not found and defaults could not be merged. Please publish the package configuration before proceeding.');
        }

		Schema::create($tableName, function(Blueprint $table)
		{
            $table -> bigIncrements('id');
			$table -> string('subject');

            $table -> bigInteger('user_id') -> index();

            $table -> dateTime('created_at') -> nullable();
            $table -> dateTime('updated_at') -> nullable() -> useCurrent();
			$table -> dateTime('archived_at') -> nullable();
            $table -> dateTime('deleted_at') -> nullable();

		});
	}


	// -- Reverse the migrations.
	public function down()
	{
		$tableName = config('messenger.db.threads_table');

        if (empty($tableName)) {
			throw new \Exception('Error: config/messenger.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the table manually.');
        }

		Schema::dropIfExists($tableName);
	}

}
