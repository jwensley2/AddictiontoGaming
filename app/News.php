<?php

namespace App;

class News extends \Illuminate\Database\Eloquent\Model
{
    protected $guarded = [];

    public static $rules = [
        'title'   => 'required|between:5,255',
        'content' => 'required',
    ];

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function editor()
    {
        return $this->belongsTo('App\User', 'edit_user_id');
    }

    public function getDisplayContent()
    {
        $content = $this->content;

        $phpamo = new \WillWashburn\Phpamo\Phpamo(
            \Config::get('services.camo.key'),
            \Config::get('services.camo.domain')
        );

        // Find http image urls
        preg_match_all("/src=\"(http:\/\/(.*))\"/", $content, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $camoUrl = $phpamo->camo($match[1]);

            $content = str_replace($match[1], $camoUrl, $content);
        }

        return $content;
    }
}