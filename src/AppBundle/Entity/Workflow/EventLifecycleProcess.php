<?php
/**
 * Created by PhpStorm.
 * User: afedotov
 * Date: 16.04.18
 * Time: 23:15
 */

namespace AppBundle\Entity\Workflow;


use AppBundle\Entity\Event;
use Doctrine\ORM\Mapping\Column;
use PHPMentors\Workflower\Persistence\WorkflowSerializableInterface;
use PHPMentors\Workflower\Process\ProcessContextInterface;
use PHPMentors\Workflower\Workflow\Workflow;
use Doctrine\ORM\Mapping as ORM;

class EventLifecycleProcess implements ProcessContextInterface, WorkflowSerializableInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Type("string")
     * @Serializer\Groups({"list"})
     */
    protected $id;

    /**
     * @var Event
     * @ORM\OneToOne(targetEntity="Event")
     */
    protected $event;


    /**
     * @var Workflow
     */
    private $workflow;

    /**
     * @var string
     *
     * @Column(type="blob", name="serialized_workflow")
     */
    private $serializedWorkflow;

    /**
     * {@inheritdoc}
     */
    public function getProcessData()
    {
        return [
            'id' => $this->id,
            'event' => $this->event,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function setWorkflow(Workflow $workflow)
    {
        $this->workflow = $workflow;
    }

    /**
     * {@inheritdoc}
     */
    public function getWorkflow()
    {
        return $this->workflow;
    }

    /**
     * {@inheritdoc}
     */
    public function setSerializedWorkflow($workflow)
    {
        $this->serializedWorkflow = $workflow;
    }

    /**
     * {@inheritdoc}
     */
    public function getSerializedWorkflow()
    {
        if (is_resource($this->serializedWorkflow)) {
            return stream_get_contents($this->serializedWorkflow, -1, 0);
        } else {
            return $this->serializedWorkflow;
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Event
     */
    public function getEvent(): Event
    {
        return $this->event;
    }

    /**
     * @param Event $event
     */
    public function setEvent(Event $event): void
    {
        $this->event = $event;
    }

}