<?php


namespace modules\entrant\services;

use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\forms\OtherDocumentForm;
use modules\entrant\models\OtherDocument;
use modules\entrant\repositories\OtherDocumentRepository;
use modules\entrant\repositories\StatementRepository;

class OtherDocumentService
{
    private $repository;
    private $statementRepository;

    public function __construct(OtherDocumentRepository $repository, StatementRepository $statementRepository)
    {
        $this->repository = $repository;
        $this->statementRepository = $statementRepository;
    }

    public function create(OtherDocumentForm $form)
    {
        $model  = OtherDocument::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, OtherDocumentForm $form)
    {
        $model = $this->repository->get($id);
        $model->data($form);
        if(!$this->statementRepository->getStatementStatusNoDraft($model->user_id) ) {
            $model->detachBehavior("moderation");
        }
        $model->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        if($model->type_note || $model->type == DictIncomingDocumentTypeHelper::ID_PATRIOT_DOC) {
            throw new \DomainException('Вы не можеете, удалить данный прочий документ, так как он необходим для загрузки файла');
        }
        $this->repository->remove($model);
    }

}