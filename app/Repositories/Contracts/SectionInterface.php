<?php 

namespace App\Repositories\Contracts;

interface SectionInterface
{
	public function getPages(string $slug);

	public function getProject(string $slug);

	public function deletePages(string $slug);
}