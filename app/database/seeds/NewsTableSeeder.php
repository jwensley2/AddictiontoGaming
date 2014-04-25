<?php

use Carbon\Carbon;

class NewsTableSeeder extends Seeder {

	public function run()
	{
		// Delete existing data
		DB::table('news')->truncate();

		$news = [
			[
				'title'        => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit',
				'content'      => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor, culpa architecto est eius tenetur saepe ut fugit quam commodi possimus?</p><p>Doloribus, vitae, delectus, incidunt molestias deserunt ducimus ipsam saepe ad possimus necessitatibus eum suscipit dolores ullam beatae non. Quia, deleniti.</p><p>Corporis, labore, doloribus aliquid maxime tempore debitis amet? Tempore, corrupti nostrum harum qui sequi magni aspernatur ut repellendus debitis aliquid?</p>',
				'user_id'      => 1,
				'edit_user_id' => '',
				'created_at'   => Carbon::now(),
				'updated_at'   => '',
			]
		];

		// Insert the news
		DB::table('news')->insert($news);
	}
}