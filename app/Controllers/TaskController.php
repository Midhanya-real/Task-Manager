<?php

namespace App\Controllers;

use App\Services\TaskService;
use App\Views\Request\TaskRequestView;
use App\Views\Response\TaskResponseView;
use Exception;

class TaskController
{
    private TaskRequestView $requestView;
    private TaskResponseView $responseView;
    private TaskService $service;

    public function __construct()
    {
        $this->requestView = new TaskRequestView();
        $this->responseView = new TaskResponseView();
        $this->service = new TaskService();

    }

    /**
     * @return bool
     */
    public function get(): bool
    {
        $request = $this->requestView->getDataCollection();
        $request == false ? $showData = false : $showData = $this->service->show($request);

        return $this->responseView->get($showData);
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function post(): bool
    {
        $request = $this->requestView->postDataCollection();
        $request == false ? $isAdd = false : $isAdd = $this->service->add($request);

        return $this->responseView->post($isAdd);
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function put(): bool
    {
        $request = $this->requestView->putDataCollection();
        $request == false ? $isChange = false : $isChange = $this->service->change($request);

        return $this->responseView->put($isChange);
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function remove(): bool
    {
        $request = $this->requestView->removeDataCollection();
        $request == false ? $isRemove = false : $isRemove = $this->service->remove($request);

        return $this->responseView->remove($isRemove);
    }
}