<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    protected $guarded = [];

    public static $rules = [
        'title'   => 'required|between:5,255',
        'content' => 'required',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'edit_user_id');
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