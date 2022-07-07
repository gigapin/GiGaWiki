<?php 

namespace App\Repositories\Contracts;

interface CommentInterface
{
	public function hasParent();

	public function getComments(string $slug, string $class);

	public function getParentComments(string $slug, string $class);
}