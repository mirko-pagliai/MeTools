<?php
namespace MeTools\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use MeTools\View\Helper\RecaptchaHelper;

/**
 * MeTools\View\Helper\RecaptchaHelper Test Case
 */
class RecaptchaHelperTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Recaptcha = new RecaptchaHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Recaptcha);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
