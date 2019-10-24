<?php
namespace backend\services\dictionary;

use backend\forms\dictionary\DictClassForm;
use backend\models\dictionary\DictClass;
use backend\repositories\dictionary\DictClassRepository;

class DictClassService
{
    private $repository;

    public function __construct(DictClassRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(DictClassForm $form) {
        $model = DictClass::create($form);
        $this->repository->save($model);
    }

    public function edit($id, DictClassForm $form) {
        $model = $this->repository->get($id);
        $model->edit($form);
        $this->repository->save($model);
    }

    public function remove($id) {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}