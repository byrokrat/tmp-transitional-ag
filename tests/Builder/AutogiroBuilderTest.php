<?php
namespace ledgr\autogiro\Builder;

use ledgr\banking\Bankgiro;
use Mockery as m;

class AutogiroBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetXML()
    {
        $giro = m::mock('\ledgr\giro\Giro');
        $giro->shouldReceive('convertToXML')->once()->andReturn('<xml>');
        
        $org = m::mock('ledgr\autogiro\Builder\Organization');
        $org->shouldReceive('getAgCustomerNumber')->once();
        $org->shouldReceive('getBankgiro')->once()->andReturn(new Bankgiro('111-1111'));

        $converter = m::mock('ledgr\autogiro\Builder\AutogiroConverter');
        $converter->shouldReceive('convertBankgiro')->once();

        $builder = new AutogiroBuilder($giro, $org, $converter);
        $this->assertEquals('<xml>', $builder->getXML());
    }

    public function testAddConsent()
    {
        $giro = m::mock('\ledgr\giro\Giro');
        $giro->shouldReceive('convertToXML')->once();
        
        $org = m::mock('ledgr\autogiro\Builder\Organization');
        $org->shouldReceive('getAgCustomerNumber')->once();
        $org->shouldReceive('getBankgiro')->once()->andReturn(new Bankgiro('111-1111'));

        $converter = m::mock('ledgr\autogiro\Builder\AutogiroConverter');
        $converter->shouldReceive('convertBankgiro')->once()->andReturn('12341234');
        $converter->shouldReceive('convertPayerNr')->once()->andReturn('232323233');
        $converter->shouldReceive('convertId')->once()->andReturn('191963231234');

        $builder = new AutogiroBuilder($giro, $org, $converter);

        $id = m::mock('ledgr\id\PersonalId');
        
        $account = m::mock('ledgr\banking\AccountInterface');
        $account->shouldReceive('getClearing')->andReturn('1111');
        $account->shouldReceive('getNumber')->andReturn('2222222');

        $builder->addConsent($id, $account);
        $this->assertFalse($builder->getNative() == '');
    }

    public function testClear()
    {
        $giro = m::mock('\ledgr\giro\Giro');
        $giro->shouldReceive('convertToXML')->once();
        
        $org = m::mock('ledgr\autogiro\Builder\Organization');
        $org->shouldReceive('getAgCustomerNumber')->once();
        $org->shouldReceive('getBankgiro')->once()->andReturn(
            m::mock('ledgr\banking\Bankgiro')
        );

        $converter = m::mock('ledgr\autogiro\Builder\AutogiroConverter');
        $converter->shouldReceive('convertBankgiro')->once();

        $builder = new AutogiroBuilder($giro, $org, $converter);

        $builder->addConsent(
            m::mock('ledgr\id\PersonalId'),
            m::mock('ledgr\banking\AccountInterface')
        );

        $builder->clear();
        $this->assertTrue($builder->getNative() == '');
    }

    public function testBill()
    {
        $giro = m::mock('\ledgr\giro\Giro');
        $giro->shouldReceive('convertToXML')->once();
        
        $org = m::mock('ledgr\autogiro\Builder\Organization');
        $org->shouldReceive('getAgCustomerNumber')->once();
        $org->shouldReceive('getBankgiro')->once()->andReturn(new Bankgiro('111-1111'));

        $converter = m::mock('ledgr\autogiro\Builder\AutogiroConverter');
        $converter->shouldReceive('convertBankgiro')->once()->andReturn('1234');
        $converter->shouldReceive('convertPayerNr')->once()->andReturn('1234');

        $builder = new AutogiroBuilder($giro, $org, $converter);

        $id = m::mock('ledgr\id\PersonalId');
        
        $amount = m::mock('ledgr\amount\Amount');
        $amount->shouldReceive('__toString')->andReturn('999.99');

        $builder->bill($id, $amount, new \DateTime);
        $this->assertFalse($builder->getNative() == '');
    }
}
