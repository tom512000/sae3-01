<?php

declare(strict_types=1);

namespace App\tests\Support\Helper;

use Codeception\Lib\Interfaces\DependsOnModule;
use Codeception\Module;
use Codeception\Module\Symfony;
use Codeception\TestInterface;
use Doctrine\Persistence\ManagerRegistry;

class EntityManagerReset extends Module implements DependsOnModule
{
    private Symfony $symfony;
    protected string $dependencyMessage = <<<EOF
Set Symfony as dependent module:

modules:
    enabled:
        - \App\Tests\Support\Helper\EntityManagerReset:
            depends: Symfony
EOF;

    protected array $config = [
        'depends' => null,
    ];

    public function _depends(): array
    {
        return [Symfony::class => $this->dependencyMessage];
    }

    public function _inject(Symfony $symfony): void
    {
        $this->symfony = $symfony;
    }

    /**
     * Executed before tests.
     *
     * Fix "The EntityManager is closed" after test failure. If EntityManager is closed, reset it.
     */
    public function _before(TestInterface $test): void
    {
        parent::_before($test);

        /** @var ManagerRegistry $doctrine */
        $doctrine = $this->symfony->grabService('doctrine');
        if (!$doctrine->getManager()->isOpen()) {
            $doctrine->resetManager();
        }
    }
}
