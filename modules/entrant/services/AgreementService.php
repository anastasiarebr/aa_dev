<?php


namespace modules\entrant\services;


use common\transactions\TransactionManager;
use modules\dictionary\models\DictOrganizations;
use modules\dictionary\repositories\DictOrganizationsRepository;
use modules\entrant\forms\AgreementForm;
use modules\entrant\models\Agreement;
use modules\entrant\repositories\AgreementRepository;
use Mpdf\Tag\Tr;

class AgreementService
{
    private $repository;
    private $organizationsRepository;
    private $transactionManager;

    public function __construct(AgreementRepository $repository,
                                DictOrganizationsRepository $organizationsRepository,
                                TransactionManager $transactionManager
    )
    {
        $this->repository = $repository;
        $this->organizationsRepository = $organizationsRepository;
        $this->transactionManager = $transactionManager;
    }

    public function createOrUpdate(AgreementForm $form, Agreement $model = null)
    {
        $this->transactionManager->wrap(function () use($form, $model) {
            $organization_id = $this->addOrUpdateOrganization($form);
            if($model) {
                $agreement = $this->repository->get($model->id);
                $agreement->data($form, $organization_id);
            }else {
                $agreement = Agreement::create($form,$organization_id);
            }
            $this->repository->save($agreement);
        });
    }

    private function addOrUpdateOrganization(AgreementForm $form) {
        if($form->check_new && $form->name) {
            $organization = DictOrganizations::createNameUser($form->name);
            $this->organizationsRepository->save($organization);
        }
        else if($form->check_rename  && $form->name) {
            $organization = $this->organizationsRepository->get($form->organization_id);
            $organization->setName($form->name);
            $this->organizationsRepository->save($organization);
        }else {
            $organization = $this->organizationsRepository->get($form->organization_id);
        }
        return $organization->id;

    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }



}