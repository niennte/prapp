<?php
namespace Application\Controller;

use Application\Form\TimeReportForm;
use Application\Service\TimeKeepingService;
use Exception;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;



/**
 * Controller class for the micro app.
 * Render views, receive and dispatch input.
 */
class IndexController extends AbstractActionController
{
    /**
     * Service deals with entities and repositories.
     * Keeps controllers out of trouble.
     *
     * @var \Application\Service\TimeKeepingService
     */
    private $timeKeepingService;

    /**
     * Service dependency-injected in the Factory
     *
     * @param TimeKeepingService $timeKeepingService
     */
    public function __construct(TimeKeepingService $timeKeepingService)
    {
        $this->timeKeepingService = $timeKeepingService;
    }


    /**
     *
     * Single action based on the one-page concept.
     * Display report and the upload form.
     * Get data, errors and warnings from the service, pass data to the service.
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        // Time Report upload form.
        $form = new TimeReportForm();
        $form->get('submit')->setValue('Upload Time Report');

        // Handle upload form data
        $request = $this->getRequest();
        if ($request->isPost()) {

            $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            $form->setData($post);

            if ($form->isValid()) {
                // Pass uploaded file to the service and report result back to the form
                $csvUpload = $form->get($form::CSV_UPLOAD)->getValue()["tmp_name"];
                $this->timeKeepingService->handleTimeReportUpload($csvUpload);
                $form->setMessages([$form::CSV_UPLOAD => $this->reportUploadResult()]);
            }
        }

        // Paginated payroll report.
        $page = $this->params()->fromQuery('page', 1);
        $pageSize = $this->params()->fromQuery('pageSize', 5);
        $payrollReport = $this->timeKeepingService->getPayrollReport($page, $pageSize);

        // Pass what's done into the view
        return new ViewModel([
            'payrollReport' => $payrollReport,
            'form' => $form,
        ]);
    }

    /**
     *
     * Stub.
     * Stub to format error messages and warnings.
     * @return array
     */
    private function reportUploadResult() {

        $messages = ["Success" => "Report saved."];

        if ($this->timeKeepingService->hasWarnings()) {
            $messages = ["Warning" => "Report saved with warnings. "
                        . $this->timeKeepingService->getServiceWarnings()];
        }

        if ($this->timeKeepingService->hasErrors()) {
            $messages = ["Error" => "Report not saved. "
                        . $this->timeKeepingService->getServiceErrors()];
        }
        return $messages;
    }

}