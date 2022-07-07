<?php 

namespace App\Actions;

use App\Models\Tag;

class TagAction
{
    /**
     * Create new tags.
     *
     * @param string $data
     * @param object $page
     * @param string $type
     * @return mixed
     */
    public function createTag(string $data, object $page, string $type)
    {
        return Tag::create([
            'name' => $data,
            'page_id' => $page->id,
            'page_type' => $type
        ]);

    }

    /**
     * Update tags.
     *
     * @param object $page_id
     * @param string $page_type
     * @return void
     */
    public function updateTags(object $page_id, string $page_type)
    {
        if(request()->edit !== null) {
            foreach(request()->edit as $row) {
                foreach($row as $k => $v) {
                    $tag = Tag::find($k);
                    $tag->name = $v;
                    $tag->save();
                }
            }
        }
        if (request()->tags != null) {
            foreach(request()->tags as $tag) {
                if ($tag !== null) {
                    Tag::create([
                        'name' => $tag,
                        'page_id' => $page_id->id,
                        'page_type' => $page_type
                    ]);
                }
            }
        }
    }

    /**
     * Delete tags.
     *
     * @param int $id
     * @param string $type
     * @return void
     */
    public function deleteTags(int $id, string $type)
    {
        $tags = Tag::where('page_id', $id)->where('page_type', $type)->get();
        if ($tags !== null) {
            foreach($tags as $tag) {
                $tag->delete();
            }
        }
    }
}