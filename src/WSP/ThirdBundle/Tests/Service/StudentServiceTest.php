<?php

namespace WSP\ThirdBundle\Tests\Service;

use WSP\ThirdBundle\Service\StudentService;

class StudentServiceTest extends \PHPUnit_Framework_TestCase
{
    public function encodeStringProvider()
    {
        return [
            '1' => [ 'Test data', 'test_data' ],
            '2' => [ 'Test data2', 'test_data2' ],
            '3' => [ 'Data @#&^', 'data' ],
            '4' => [ '#@@ Data @#55', 'data_55' ],
        ];
    }

    public function getUniquePathProvider()
    {
        return [
            [ 'name', 'name' ],
            [ 'name', 'name_1' ],
            [ 'name', 'name_2' ],
            [ 'test', 'test' ],
            [ 'yyyy', 'yyyy' ],
            [ 'test', 'test_1' ],
            [ 'name', 'name_3' ],
        ];
    }

    /**
     * @param string $str
     * @param string $expected
     *
     * @dataProvider encodeStringProvider
     */
    public function testEncodeString($str, $expected)
    {
        $studentService = $this->getService();
        $actual = $studentService->encodeString($str);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return StudentService
     */
    public function getService()
    {
        $em = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        return new StudentService($em);
    }

    /**
     * @param string $actual
     * @param string $expected
     */
    public function testGetUniquePath()
    {
        $studentService = $this->getService();
        foreach($this->getUniquePathProvider() as $dataSet)
        $this->assertEquals($dataSet[1], $studentService->getUniquePath($dataSet[0]));
    }
} 