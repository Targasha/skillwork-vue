<?php

namespace App\Transformers;

class ArticleTransformer extends Transformer
{
    /**
     * Transform a article
     * @param $article
     * @return array
     */
    public function transform($article)
    {
        return [
            'id' => (int) $article->id,
            'user_id' => (int) $article->user_id,
            'title' => $article->title,
            'content' => $article->content,
            'autor' => $article->autor,
            'created_at' => $article->created_at->toDateTimeString(),
            'updated_at' => $article->updated_at->toDateTimeString(),
        ];
    }

    public function list($article)
    {
        return [
            'id' => (int) $article->id,
            'title' => $article->title,
            'autor' => $article->autor->name,
            'created_at' => $article->created_at->toDateTimeString(),
            'updated_at' => $article->updated_at->toDateTimeString(),
        ];
    }
}
