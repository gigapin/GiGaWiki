<?php 

namespace App\Repositories\Contracts;

interface ProjectInterface
{
    public function getSections(string $slug);

    public function findSubjectHasProject(string $slug);

    public function deletePages(string $slug);
}