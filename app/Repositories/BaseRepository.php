<?php

namespace App\Repositories;

abstract class BaseRepository
{
    protected $model;

    public function getAll()
    {
        return $this->model::get();
    }

    public function find($id)
    {
        return $this->model::findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model::create($data);
    }

    public function update($id, array $data)
    {
        $model = $this->find($id);
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        return $this->model::destroy($id);
    }
}
