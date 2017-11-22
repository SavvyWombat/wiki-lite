<?php

namespace SavvyWombat\WikiLite\Tests\Feature;

/**
 * @uses SavvyWombat\WikiLite\ServiceProvider
 */
class PageTest extends TestCase
{
    /**
     * @covers SavvyWombat\WikiLite\Controllers\PageController::save
     */
    public function testSave()
    {
        $this->post('/wiki/save')
            ->assertStatus(200);
    }
}