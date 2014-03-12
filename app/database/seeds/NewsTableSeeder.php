<?php

class NewsTableSeeder extends Seeder {

	public function run()
	{
		// Delete existing data
		DB::table('news')->truncate();

		$old_news = DB::connection('old')->table('news')->get();

		if ($old_news)
		{
			foreach ($old_news AS $item)
			{
				$news[] = array(
					'title'        => $item->title,
					'content'      => $item->content,
					'user_id'      => $item->user_id,
					'edit_user_id' => $item->edit_user_id,
					'created_at'   => $item->date,
					'updated_at'   => $item->modified,
				);
			}

			// Insert the news
			DB::table('news')->insert($news);
		}
	}
}