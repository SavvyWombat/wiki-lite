<?php

namespace SavvyWombat\WikiLite\Tests\Feature;

/**
 * @uses SavvyWombat\WikiLite\ServiceProvider
 */
class PageTest extends TestCase
{
    /**
     * @covers SavvyWombat\WikiLite\Controllers\PageController::save
     * @uses SavvyWombat\WikiLite\Requests\SavePage
     */
    public function testSave()
    {
        $this->post('/wiki/save', [
                'title' => 'Fresh new wiki page',
                'content' => 'Some content for our fresh new page',
            ])
            ->assertStatus(200);
    }

    /**
     * @covers SavvyWombat\WikiLite\Controllers\PageController::save
     * @covers SavvyWombat\WikiLite\Requests\SavePage::rules
     * @uses SavvyWombat\WikiLite\Requests\SavePage
     */
    public function testSave_ensureRequiredContent()
    {
        $this->post('/wiki/save')
            ->assertRedirect('/wiki/edit')
            ->assertSessionHasErrors(['title', 'content']);

        $this->post('/wiki/save', [
                'title' => '',
                'content' => '',
            ])
            ->assertRedirect('/wiki/edit')
            ->assertSessionHasErrors(['title', 'content']);
    }
}