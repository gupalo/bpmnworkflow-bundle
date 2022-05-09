<?php

namespace Gupalo\BpmnWorkflowBundle\Tests\Extension;

use Doctrine\ORM\EntityManagerInterface;
use Gupalo\BpmnWorkflowBundle\Tests\Example\Cart\Cart;
use Gupalo\BpmnWorkflow\Bpmn\Loader\BpmnDirLoader;
use Gupalo\BpmnWorkflow\Context\ContextInterface;
use Gupalo\BpmnWorkflow\Context\DataContext;
use Gupalo\BpmnWorkflowBundle\Process\Workflow;
use Gupalo\BpmnWorkflowBundle\ProcessLoader\DbProcessLoader;
use Nelmio\Alice\Loader\NativeLoader;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WorkflowTest extends WebTestCase
{
    private EntityManagerInterface $em;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->em = self::$kernel->getContainer()->get('doctrine')->getManager();
        $this->loadData();
    }

    protected function tearDown(): void
    {
        $this->em->createQuery(
            'DELETE FROM Gupalo\BpmnWorkflowBundle\Entity\Process p WHERE 1 = 1'
        )->execute();
        parent::tearDown();
    }

    private function loadData(): void
    {
        $loader = new NativeLoader();
        $data = $loader->loadFile(__DIR__. '/../fixtures/process.yaml');
        foreach ($data->getObjects() as $object) {
            $this->em->persist($object);
        }
        $this->em->flush();
        $this->em->clear();
    }

    /**
     * @dataProvider contexts
     */
    public function testFlow(ContextInterface $context, int $result): void
    {
        /** @var Workflow $workflow */
        $workflow = self::getContainer()->get(Workflow::class);

        $workflow->executeProcess(self::$kernel->getContainer()->get(DbProcessLoader::class), $context, 'cart_discount');

        self::assertEquals($result, $context->getData()->getPrice());
    }

    public function contexts(): iterable
    {
        yield 'cart big price' => [
            new DataContext(new Cart(
                items: ['name' => 'cola', 'price' => 5000],
                locale: 'en',
                price: 5000,
            )),
            2000
        ];
    }
}
