<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * @Route("dashboard")
 */
class DashboardController extends Controller
{
    /**
     * @Route("/", name="dashboard_index")
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $cmdPath = $this->getParameter('kernel.root_dir')
            . '\mdx2csv.bat';

        $url = ' http://localhost:8080/pentaho/Xmla';
        $user = ' admin';
        $pass = ' password';
        $catalog = ' rapierdb';

        $query = ' "WITH
SET [~COLUMNS] AS
    {[EventMonth.MonthHierarchy].[Month].Members}
SET [~ROWS] AS
    {[EventEmployee.EmployeeHierarchy].[EventEmployee].Members}
SELECT
NON EMPTY CrossJoin([~COLUMNS], {[Measures].[EventCount], [Measures].[FinishedCount]}) ON COLUMNS,
NON EMPTY [~ROWS] ON ROWS
FROM [Event]"';

        $process = new Process($cmdPath . $url . $user . $pass . $catalog . $query);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $this->render('dashboard/dashboard.html.twig', array(
            'report_table' => $process->getOutput(),
        ));
    }
}