<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailSenderRequest;
use App\Http\Resources\MailSenderResource;
use Core\Mail\Service\MailService;
use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\Validation\ValidationException;

class MailController extends BaseController {
    /**
     * @var MailService
     */
    protected MailService $service;
    /**
     * @var ValidationFactory
     */
    protected ValidationFactory $validationFactory;

    /**
     * Constructor
     *
     * @param MailService $service
     * @param ValidationFactory $validationFactory
     */
    public function __construct(
        MailService $service,
        ValidationFactory $validationFactory
    ) {
        $this->service = $service;
        $this->validationFactory = $validationFactory;
    }

    /**
     * Send mail
     *
     * @param MailSenderRequest $request
     * @return Json
     */
    public function sendMail(MailSenderRequest $request) 
    {
        $validator = $this->validationFactory->make(
            $request->json()->all(), 
            $request->rules()
        );
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $this->responseJson(
            $this->service->sendMail(
                $request->json()->all()
            )
        );
    }
}