<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage;

use Mockery;
use EthicalJobs\Foundation\Storage\QueryAdapter;
use EthicalJobs\Foundation\Storage\ParameterMapper;
use EthicalJobs\Tests\Foundation\Fixtures\MockRepository;

class QueriesByPararmetersTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Integration
     */
    public function it_can_get_and_set_its_query_adapter()
    {
        $repository = new MockRepository;

        $queryAdapter = Mockery::mock(QueryAdapter::class);

        $repository->setQueryAdapter($queryAdapter);

        $this->assertEquals($queryAdapter, $repository->getQueryAdapter());
    }

    /**
     * @test
     * @group Integration
     */
    public function it_can_set_its_query_adapter_query_instance()
    {
        $repository = new MockRepository;

        $query =  Mockery::mock('query');

        $queryAdapter = Mockery::mock(QueryAdapter::class)
            ->shouldReceive('setQuery')
            ->once()
            ->with($query)
            ->getMock();        

        $repository->setQueryAdapter($queryAdapter)
            ->setQuery($query);
    }    

    /**
     * @test
     * @group Integration
     */
    public function it_can_get_and_set_its_parameter_map()
    {
        $repository = new MockRepository;

        $parameterMap = Mockery::mock(ParameterMapper::class);

        $repository->setParameterMapper($parameterMap);

        $this->assertEquals($parameterMap, $repository->getParameterMapper());
    }   

    /**
     * @test
     * @group Integration
     */
    public function it_can_set_its_parameter_mapper_map_array()
    {
        $repository = new MockRepository;

        $map = ['123' => '456'];

        $parameterMapper = Mockery::mock(ParameterMapper::class)
            ->shouldReceive('setParameterMap')
            ->once()
            ->with($map)
            ->getMock();        

        $repository->setParameterMapper($parameterMapper)
            ->setParameterMap($map);
    }        

    /**
     * @test
     * @group Integration
     */
    public function it_can_set_its_parameter_mapper_default_values_array()
    {
        $repository = new MockRepository;

        $defaultValues = ['parameter' => 456];

        $parameterMapper = Mockery::mock(ParameterMapper::class)
            ->shouldReceive('setDefaultValues')
            ->once()
            ->with($defaultValues)
            ->getMock();        

        $repository->setParameterMapper($parameterMapper)
            ->setDefaultValues($defaultValues);
    }               

    /**
     * @test
     * @group Integration
     */
    public function it_can_call_a_query_function_that_wants_one_arg()
    {
        $queryAdapter = Mockery::mock(QueryAdapter::class)
            ->shouldReceive('hasQueryFunction')->once()->with('limitQuery')->andReturn(true)
            ->shouldReceive('limitQuery')->once()->with(15)->andReturn(true)            
            ->getMock();

        $parameterMapper = (new ParameterMapper)->setParameterMap([
            'limit' => 'limitQuery',
        ]);

        $repository = (new MockRepository)
            ->setParameterMapper($parameterMapper)
            ->setQueryAdapter($queryAdapter);

        $repository->limit(15);
    }         

    /**
     * @test
     * @group Integration
     */
    public function it_can_call_a_query_function_that_wants_two_args()
    {
        $queryAdapter = Mockery::mock(QueryAdapter::class)
            ->shouldReceive('hasQueryFunction')->once()->with('termsQuery')->andReturn(true)
            ->shouldReceive('termsQuery')->once()->with('categories', ['it','web','dev'])->andReturn(true)            
            ->getMock();

        $parameterMapper = (new ParameterMapper)->setParameterMap([
            'categories' => 'termsQuery',
        ]);

        $repository = (new MockRepository)
            ->setParameterMapper($parameterMapper)
            ->setQueryAdapter($queryAdapter);

        $repository->categories(['it','web','dev']);
    }  

    /**
     * @test
     * @group Integration
     */
    public function it_attempts_to_pass_function_calls_back_to_self()
    {
        $queryAdapter = Mockery::mock(QueryAdapter::class)
            ->shouldNotReceive('hasQueryFunction')
            ->getMock();

        $parameterMapper = (new ParameterMapper)->setParameterMap([
            'categories' => 'termsQuery',
            'limit'      => 'limitQuery',
        ]);

        $repository = Mockery::mock(new MockRepository)
            ->makePartial()
            ->shouldReceive('search')
            ->with('React Developer', ['it','admin','dev'], 123, 'andrew@ethicaljobs.com.au')
            ->andReturn(['results' => 656])
            ->getMock();

        $repository
            ->setParameterMapper($parameterMapper)
            ->setQueryAdapter($queryAdapter);

        $repository->search('React Developer', ['it','admin','dev'], 123, 'andrew@ethicaljobs.com.au');
    }                  

    /**
     * @test
     * @group Integration
     */
    public function it_can_query_by_multiple_parameters_at_once()
    {
        $parameterMapper = (new ParameterMapper)->setParameterMap([
            'orderBy'       => 'orderByQuery',
            'limit'         => 'limitQuery',
            'dateFrom'      => 'dateFromQuery',
            'dateTo'        => 'dateToQuery',
            'categories'    => 'termsQuery',
        ]);

        $queryAdapter = Mockery::mock(QueryAdapter::class);

        $queryAdapter
            ->shouldReceive('hasQueryFunction')->once()->with('orderByQuery')->andReturn(true)
            ->shouldReceive('orderByQuery')->once()->with('expires_at')->andReturn(null);

        $queryAdapter
            ->shouldReceive('hasQueryFunction')->once()->with('limitQuery')->andReturn(true)
            ->shouldReceive('limitQuery')->once()->with(15)->andReturn(null);
        
        $queryAdapter
            ->shouldReceive('hasQueryFunction')->once()->with('dateFromQuery')->andReturn(true)
            ->shouldReceive('dateFromQuery')->once()->with('dateFrom', '2018-09-28 13:30:00')->andReturn(null);   

        $queryAdapter
            ->shouldReceive('hasQueryFunction')->once()->with('dateToQuery')->andReturn(true)
            ->shouldReceive('dateToQuery')->once()->with('dateTo', '2020-09-28 13:30:00')->andReturn(null);

        $queryAdapter
            ->shouldReceive('hasQueryFunction')->once()->with('termsQuery')->andReturn(true)
            ->shouldReceive('termsQuery')->once()->with('categories', ['admin','it','development'])->andReturn(null)
            ->getMock();        

        $repository = (new MockRepository)
            ->setParameterMapper($parameterMapper)
            ->setQueryAdapter($queryAdapter);


        $repository->queryByParameters([
            'orderBy'       => 'expires_at',
            'limit'         => 15,
            'dateFrom'      => '2018-09-28 13:30:00',
            'dateTo'        => '2020-09-28 13:30:00',
            'categories'    => ['admin','it','development'],
        ]);
    }      

    /**
     * @test
     * @group Integration
     */
    public function it_merges_default_parameter_values()
    {
        $parameterMapper = (new ParameterMapper)
            ->setParameterMap([
                'orderBy'       => 'orderByQuery',
                'limit'         => 'limitQuery',
                'dateFrom'      => 'dateFromQuery',
            ])
            ->setDefaultValues([
                'orderBy'       => 'created_at',
                'limit'         => 100,
                'dateFrom'      => '2000-09-28',
            ]);

        $queryAdapter = Mockery::mock(QueryAdapter::class);

        $queryAdapter
            ->shouldReceive('hasQueryFunction')->once()->with('orderByQuery')->andReturn(true)
            ->shouldReceive('orderByQuery')->once()->with('expires_at')->andReturn(null);

        $queryAdapter
            ->shouldReceive('hasQueryFunction')->once()->with('limitQuery')->andReturn(true)
            ->shouldReceive('limitQuery')->once()->with(10)->andReturn(null);
        
        $queryAdapter
            ->shouldReceive('hasQueryFunction')->once()->with('dateFromQuery')->andReturn(true)
            ->shouldReceive('dateFromQuery')->once()->with('dateFrom', '2000-09-28')->andReturn(null)
            ->getMock();        

        $repository = (new MockRepository)
            ->setParameterMapper($parameterMapper)
            ->setQueryAdapter($queryAdapter);


        $repository->queryByParameters([
            'orderBy'       => 'expires_at',
            'limit'         => 10,
        ]);
    }                   
}
