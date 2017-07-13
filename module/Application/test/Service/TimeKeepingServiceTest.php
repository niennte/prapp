<?php
namespace ApplicationTest\Service;

use Application\Model\TimeReport;
use Application\Service\TimeKeepingService;
use Doctrine\ORM\EntityManager;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ServiceTest extends AbstractHttpControllerTestCase
{
    protected $service;

    public function setUp()
    {
        // Load framework's config
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        // Get service from the framework
        $serviceLocator = $this->getApplicationServiceLocator();
        $this->service = $serviceLocator->get(TimeKeepingService::class);

        // Isolate by replacing ORM's entity manager with a mock object
        $entityManagerStub = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['getRepository'])
            ->getMock();

        $this->service->setEntityManager($entityManagerStub);

        parent::setUp();
    }

    /**
     * Service instantiates model and collects feedback
     * @dataProvider csvProvider
     */
    public function testHandleTimeReportUpload($csv) {
        $this->service->handleTimeReportUpload($csv);
        $this->assertContains('Error: ', $this->service->getServiceErrors());
    }

    public function csvProvider() {
        return [
            ['no-file'],
        ];
    }

    /**
     * Service calls save method on valid model
     */
    public function testHandleSaveTimeReportValid() {
        $timeReportStub = $this->getMockBuilder(TimeReport::class)
            ->disableOriginalConstructor()
            ->setMethods(['isValid', 'save'])
            ->getMock();

        $timeReportStub->method('isValid')
            ->willReturn(true);

        $timeReportStub->expects($this->once())
            ->method('save');

        $this->service->handleSaveTimeReport($timeReportStub);
    }

    /**
     * Service validates model before saving
     */
    public function testHandleSaveTimeReportInvalid() {
        $timeReportStub = $this->getMockBuilder(TimeReport::class)
            ->disableOriginalConstructor()
            ->setMethods(['isValid', 'save'])
            ->getMock();

        $timeReportStub->method('isValid')
            ->willReturn(false);

        $timeReportStub->expects($this->never())
            ->method('save');

        $this->service->handleSaveTimeReport($timeReportStub);
    }
}
