<?php
namespace ApplicationTest\Model;

use Application\Model\Factory\TimeReportFactory;
use Application\Repository\TimeKeepingRepository;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use SplFileObject;

class TimeReportTest extends TestCase
{
    protected $service;
    protected $fileName;

    public function setUp()
    {
        touch($this->fileName = __DIR__ . '/../tmp/sample.csv');
        parent::setUp();
    }

    /**
     * Model applies rules
     * @dataProvider csvDataProvider
     */
    public function testRules($list, $isValid)
    {

        $repositoryStub = $this->getMockBuilder(TimeKeepingRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['fetchTimeReportIsUnique', 'saveTimeCard'])
            ->getMock();

        $repositoryStub->method('fetchTimeReportIsUnique')
            ->willReturn(true);

        $entityManagerStub = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['getRepository'])
            ->getMock();

        $entityManagerStub->method('getRepository')
            ->willReturn($repositoryStub);

        $this->makeCsv($list);
        $timeReport = TimeReportFactory::constructFromCsv($this->fileName, $entityManagerStub);

        $this->assertEquals($isValid, $timeReport->isValid());

    }

    public function csvDataProvider()
    {
        // rule definitions
        // data[], expected isValid() value
        return [
            [ // good to go
                'data' => [
                    ['date','hours worked','employee id','job group'],
                    ['4/11/2016',10,1,'A'],
                    ['report id',43,null,null]
                ],
                true,
            ],
            [ // no id
                'data' => [
                    ['date','hours worked','employee id','job group'],
                    ['4/11/2016',10,1,'A'],
                    ['report id',null,null,null]
                ],
                false,
            ],
            [ // no records
                'data' => [
                    ['date','hours worked','employee id','job group'],
                    ['report id',123,null,null]
                ],
                false,
            ],
            [ // not well formed
                'data' => [
                    ['date','hours worked','employee id','job group'],
                    ['4/11/2016',1,'A'],
                    ['report id',null,null,null]
                ],
                false,
            ],
        ]; // etc.
    }

    protected function makeCsv($list)
    {
        $file = new SplFileObject($this->fileName, 'w');
        foreach ($list as $fields) {
            $file->fputcsv($fields);
        }
    }


    public function tearDown() {
        unlink($this->fileName);
    }

}
