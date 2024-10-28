<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HabilidadesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HabilidadesTable Test Case
 */
class HabilidadesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\HabilidadesTable
     */
    public $Habilidades;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Habilidades',
        'app.Usuarios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Habilidades') ? [] : ['className' => HabilidadesTable::class];
        $this->Habilidades = TableRegistry::getTableLocator()->get('Habilidades', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Habilidades);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
