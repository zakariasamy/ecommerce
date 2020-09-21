<?php
namespace App\Repositories;

use App\Http\Interfaces\RepositoryInterface;

public class implements RepositoryInterface{

    protected $model;
    function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function index(){
        return $this->model->paginate(PAGINATION_COUNT);
    }

    public function create(array $data){
        return $this->model->create($data);
    }

    public function update(array $data, $id){
        $record = $this->model->find($id);
        $record->update($data);
    }

    public function delete($id){
        $this->model->destroy($id);
    }

    public function show($id){
        return $this->model->findOrFail($id);
    }

    public function setModel($model){
        $this->model = $model;
        return $this;
    }

    public function getModel(){
        return $this->model;
    }

    public function with($relationship){
        return $this->model->with($relationship);
    }
}
