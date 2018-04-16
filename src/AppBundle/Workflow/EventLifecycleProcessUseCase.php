<?php
/**
 * Created by PhpStorm.
 * User: afedotov
 * Date: 16.04.18
 * Time: 23:29
 */

namespace AppBundle\Workflow;


use AppBundle\Entity\Event;
use AppBundle\Entity\Workflow\EventLifecycleProcess;
use PHPMentors\Workflower\Process\EventContext;
use PHPMentors\Workflower\Process\EventContextInterface;
use PHPMentors\Workflower\Process\Process;
use PHPMentors\Workflower\Process\ProcessAwareInterface;
use PHPMentors\Workflower\Process\ProcessContextInterface;
use PHPMentors\Workflower\Process\WorkItemContext;

class EventLifecycleProcessUseCase implements ProcessAwareInterface
{
    /**
     * Runtime-процесс
     * @var Process
     */
    private $process;

    /**
     * Контекст runtime-процесса, включающий
     * экземпляр workflow и читаемые/записываемые данные
     * @var ProcessContextInterface
     */
    private $processContext;

    /**
     * {@inheritdoc}
     */
    public function setProcess(Process $process)
    {
        $this->process = $process;
    }

    /**
     * @return \PHPMentors\Workflower\Workflow\Workflow
     */
    public function getProcessWorkflow()
    {
        return $this->processContext->getWorkflow();
    }

    /**
     * Return true is process active or false if process is completed of cancelled
     * @return bool
     */
    public function isActive()
    {
        return $this->getProcessWorkflow()->isActive();
    }

    /**
     * Get last activity
     * @return null|\PHPMentors\Workflower\Workflow\Element\FlowObjectInterface
     */
    public function getCurrentActivity()
    {
        return $this->getProcessWorkflow()->getCurrentFlowObject();
    }

    /**
     * Set process that contains flow to execute
     * @param ProcessContextInterface $processContext
     * @return EventLifecycleProcessUseCase
     */
    public function setProcessContext(ProcessContextInterface $processContext)
    {
        $this->processContext = $processContext;
        return $this;
    }

    /**
     * Set process to current process
     * @param $key
     * @param $val
     *
     * @return EventLifecycleProcessUseCase
     */
    public function setProcessData($key, $val)
    {
        //TODO: Validate that param exist
        $this->processContext->setProcessData($key, $val);
        return $this;
    }

    /**
     * Start a new process
     * @param EventContextInterface|null $startEvent
     * @return EventLifecycleProcessUseCase
     */
    public function start()
    {
        // Создаём контекст runtime-процесса
        $this->processContext = new EventLifecycleProcess();
        // Hardcoded value
        $startEventId = '_inicio';
        // Генерируем start event с новым контекстом runtime-процесса
        // (кружочек слева на диаграмме)...
        $startEvent = new EventContext($startEventId, $this->processContext);

        // ...и запускаем runtime-процесс с этим контекстом
        $this->process->start($startEvent);

        return $this;
    }

    /**
     * Выполнение очередного activity
     * @return EventLifecycleProcessUseCase
     */
    public function run(EventLifecycleProcess $process, Event $event)
    {
        if ($event->getStatus() === Event::STATUS_OPEN || $event->getStatus() === Event::STATUS_DRAFT) {
            $this->process->allocateWorkItem($process);
        } elseif ($event->getStatus() === Event::STATUS_WORK ){
            $this->process->startWorkItem($process);
        } elseif ($event->getStatus() === Event::STATUS_FINISH || $event->getStatus() === Event::STATUS_FINISH) {
            $this->process->completeWorkItem($process);
        }

        return $this;
    }
}