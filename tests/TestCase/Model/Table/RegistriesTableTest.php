<?php
declare(strict_types=1);

namespace MakvilleRegistry\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use MakvilleRegistry\Model\Table\RegistriesTable;

/**
 * MakvilleRegistry\Model\Table\RegistriesTable Test Case
 */
class RegistriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \MakvilleRegistry\Model\Table\RegistriesTable
     */
    protected $Registries;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'plugin.MakvilleRegistry.Registries',
        'plugin.MakvilleRegistry.RegistryFields',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Registries') ? [] : ['className' => RegistriesTable::class];
        $this->Registries = TableRegistry::getTableLocator()->get('Registries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Registries);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test removeSpecialCharacters method
     *
     * @return void
     */
    public function testRemoveSpecialCharacters(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test dbName method
     *
     * @return void
     */
    public function testDbName(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test createRegistry method
     *
     * @return void
     */
    public function testCreateRegistry(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test editRegistry method
     *
     * @return void
     */
    public function testEditRegistry(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test deleteRegistry method
     *
     * @return void
     */
    public function testDeleteRegistry(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getData method
     *
     * @return void
     */
    public function testGetData(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getLists method
     *
     * @return void
     */
    public function testGetLists(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getListData method
     *
     * @return void
     */
    public function testGetListData(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getFields method
     *
     * @return void
     */
    public function testGetFields(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test scrubber method
     *
     * @return void
     */
    public function testScrubber(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test filter method
     *
     * @return void
     */
    public function testFilter(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test userTotal method
     *
     * @return void
     */
    public function testUserTotal(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test userSummary method
     *
     * @return void
     */
    public function testUserSummary(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test userDailySummary method
     *
     * @return void
     */
    public function testUserDailySummary(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test userEntries method
     *
     * @return void
     */
    public function testUserEntries(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test entrySummary method
     *
     * @return void
     */
    public function testEntrySummary(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
