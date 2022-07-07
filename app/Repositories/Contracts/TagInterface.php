<?php 

namespace App\Repositories\Contracts;

interface TagInterface
{
    public function createTag(string $data, object $page, string $type);

    public function updateTags(object $page, string $page_type);

    public function deleteTags(int $id, string $type);
}