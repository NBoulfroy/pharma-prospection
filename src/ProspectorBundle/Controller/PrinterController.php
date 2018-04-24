<?php

namespace ProspectorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Profile;
use AppBundle\Entity\ExpenseAccount;
use AppBundle\Entity\OtherExpenseAccount;
use AppBundle\Entity\Parameter;
use AppBundle\Entity\Power;
use Dompdf\Dompdf;
use Dompdf\Options;

class PrinterController extends Controller
{
    /**
     * @Route("/expense-account-print/{id}", name="prospector_expense_account_printer", requirements={"id"= "\d+"})
     */
    public function printerAction($id)
    {
        // TODO : USES SECURITY YML TO REDIRECT USER.
        if ($this->getUser() == null || empty($this->getUser())) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        $doctrine =  $this->getDoctrine();

        $expenseAccount = $doctrine->getRepository(ExpenseAccount::class)->findBy(array(
            'id' => $id,
            'person' => $this->getUser()
        ));

        $otherExpensesAccount = $doctrine->getRepository(OtherExpenseAccount::class)->findBy(array(
            'expenseAccount' => $expenseAccount[0]
        ));

        $html =  $this->renderView('/prospector/pdfExpenseAccount.html.twig', array(
            'person' => $this->getUser(),
            'profile' => $doctrine->getRepository(Profile::class)->findBy(array('person' => $this->getUser())),
            'expenseAccount' => $expenseAccount,
            'nightPrice' => $doctrine->getRepository(Parameter::class)->getPrice('night')[0]['value'],
            'middayMealPrice' => $doctrine->getRepository(Parameter::class)->getPrice('meal')[0]['value'],
            'mileagePrice' => $doctrine->getRepository(Power::class)->getPowerCost($this->getUser()->getId())[0]['cost'],
            'otherExpensesAccount' => $otherExpensesAccount
        ));

        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);

        $pdf = new Dompdf($options);
        $pdf->loadHtml($html);
        $pdf->render();

        $fileName = $this->getUser()->getUsername() . '-' . $expenseAccount[0]->getDate()->format('Y-m-d');

        return new Response($pdf->stream($fileName));
        // return new Response($html);
    }
}
