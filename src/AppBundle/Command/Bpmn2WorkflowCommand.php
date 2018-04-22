<?php
namespace AppBundle\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Yaml\Yaml;

class Bpmn2WorkflowCommand extends Command
{
    private const BPMN_DIR = 'src/AppBundle/Resources/config/workflower/';
    private const BPMN_ID = 'bpmn_id';

    private static function singleToArray(&$a) {
        if (!is_array($a) || !key_exists(0, $a))
            $a = [$a];
    }

    protected function configure()
    {
        $this->setName('app:bp2wf')
            ->addArgument(self::BPMN_ID, InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $wfId = $input->getArgument(self::BPMN_ID);
        $bpmnSrc = self::BPMN_DIR.$wfId.'.bpmn';
        $bpmnText = file_get_contents($bpmnSrc);
        $bpmnContent = (new XmlEncoder())
            ->decode($bpmnText, 'xml')['bpmn:process'];

        $ymlContent = [
            'type' => 'state_machine',
            'supports' => 'AppBundle\Entity\Event',
            'marking_store' => [
                'type' => 'single_state',
                'argument' => 'currentPlace',
            ],
            'places' => [],
            'transitions' => [],
        ];
        $bpmnStartEvents = $bpmnContent['bpmn:startEvent'];
        $bpmnTasks = $bpmnContent['bpmn:task'];
        $bpmnGts = $bpmnContent['bpmn:exclusiveGateway'];;
        $bpmnEndEvents = $bpmnContent['bpmn:endEvent'];
        $bpmnFlows = $bpmnContent['bpmn:sequenceFlow'];

        self::singleToArray($bpmnStartEvents);
        foreach ($bpmnStartEvents as $bpmnEvent)
            $ymlContent['places'][] = $bpmnEvent['@id'];
        self::singleToArray($bpmnTasks);
        foreach ($bpmnTasks as $bpmnTask)
            $ymlContent['places'][] = $bpmnTask['@id'];

        self::singleToArray($bpmnGts);
        foreach ($bpmnGts as $bpmnGt) {
            $gtId = $bpmnGt['@id'];
            $gtOuts = $bpmnGt['bpmn:outgoing'];
            $ymlContent['places'][] = $gtId;

            self::singleToArray($gtOuts);
            foreach ($gtOuts as $gtOut) {
                $ymlContent['transitions'][$gtOut] = [];
                $ymlContent['transitions'][$gtOut]['from'] = $gtId;
            }
        }
        self::singleToArray($bpmnEndEvents);
        foreach ($bpmnEndEvents as $bpmnEvent)
            $ymlContent['places'][] = $bpmnEvent['@id'];

        $i = 0;
        self::singleToArray($bpmnFlows);
        foreach ($bpmnFlows as $bpmnFlow) {
            $flowId = $bpmnFlow['@id'];
            if (!key_exists($flowId, $ymlContent['transitions']))
                $flowId = 'f'.$i++;
            $ymlContent['transitions'][$flowId] = [
                'from' => $bpmnFlow['@sourceRef'],
                'to' => $bpmnFlow['@targetRef'],
            ];
        }

        $ymlMinInlineLvl = 99;
        $configYml = Yaml::parseFile('app/config/config.yml');
        if (!key_exists('workflows', $configYml['framework']))
            $configYml['framework']['workflows'] = [];

        $configYml['framework']['workflows'][$wfId] = $ymlContent;
        file_put_contents('app/config/config.yml',
            Yaml::dump($configYml, $ymlMinInlineLvl));
    }
}