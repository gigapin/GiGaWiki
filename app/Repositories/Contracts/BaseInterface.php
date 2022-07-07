<?php 

namespace App\Repositories\Contracts;

interface BaseInterface
{
  public function all();

  public function find(int $id);

  public function findSlug(string $slug);

  public function findIdFromSlug(string $slug);

  public function findWhere(string $column, int|string $value);

  public function findWhereFirst(string $column, string $value);

  public function wherePaginate(string $column, int|string $value);

  public function create(array $data);

  public function update(string $slug, array $data);

  public function delete(string $slug);

  public function allBelongsUser();

  public function paginate();

  public function latestBelongsUser();

}