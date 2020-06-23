<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        $tableName = config('messenger.db.participants_table');

        if (empty($tableName)) {
            throw new \Exception('Error: config/messenger.php not found and defaults could not be merged. Please publish the package configuration before proceeding.');
        }

		Schema::create($tableName, function(Blueprint $table)
		{
			$table -> bigInteger('thread_id') -> unsigned() -> index();
			$table -> bigInteger('message_id') -> unsigned() -> index();
            $table -> bigInteger('receiver_id') -> unsigned() -> index();

			$table -> dateTime('first_read_at') -> nullable();
			$table -> dateTime('last_read_at') -> nullable();

            $table -> dateTime('created_at') -> nullable();
            $table -> dateTime('updated_at') -> nullable() -> useCurrent();
            $table -> dateTime('deleted_at') -> nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$tableName = config('messenger.db.participants_table');

        if (empty($tableName)) {
			throw new \Exception('Error: config/messenger.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the table manually.');
        }

		Schema::drop($tableName);
	}

}
