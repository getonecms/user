<?php

declare(strict_types=1);

namespace Webify\User\Infrastructure\Presentation\Admin\Form\Person;

use Webify\Base\Domain\Service\Uuid\UuidServiceInterface;
use Webify\Base\Infrastructure\Framework\Form\FormModel;
use Webify\User\Application\Person\Action\CreatePersonAction;
use Webify\User\Application\Person\Request\CreatePersonRequest;
use Webify\User\Application\Person\Repository\PersonRepositoryInterface;
use Throwable;
use Yii;

/**
 * Undocumented class
 */
class CreateFormPerson extends FormModel
{
    public $firstName;

    public $lastName;

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->setRedirectUrlOnValidationFailed(['create']);
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['firstName', 'lastName'], 'required'],
            [['firstName', 'lastName'], 'string'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels(): array
    {
        return [
            'firstName' => Yii::t('user', 'First Name'),
            'lastName' => Yii::t('user', 'Last Name'),
        ];
    }

    /**
     * Save to database.
     *
     * @return boolean
     */
    public function save(
        PersonRepositoryInterface $repository,
        UuidServiceInterface $uuidService
    ): bool {
        if (!$this->hasErrors()) {
            try {
                $action = new CreatePersonAction($repository, $uuidService);

                $action->execute(new CreatePersonRequest($this->firstName, $this->lastName));

                return true;
            } catch (Throwable $t) {
                log_message('error', $t->getMessage() . "\n" . $t->getTraceAsString());
            }
        }

        return false;
    }
}
