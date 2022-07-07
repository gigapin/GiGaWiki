<?php 

namespace App\Repositories\Contracts;

interface PageInterface
{
	public function getProject(int $id);

	public function setNextPaginate(string $slug);

	public function setPrevPaginate(string $slug);
}