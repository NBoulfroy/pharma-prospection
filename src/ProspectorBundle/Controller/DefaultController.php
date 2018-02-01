<?php

namespace ProspectorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\ExpenseAccount;
use AppBundle\Entity\OtherExpenseAccount;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use \DateTime;
use \DateInterval;

class DefaultController extends Controller
{
    /**
     * @Route("/expense-account", name="prospector_expense_account")
     */
    public function expenseAction(Request $request)
    {
        // TODO : USE SECURITY YML TO REDIRECT USER.
        if ($this->getUser() == null || empty($this->getUser())) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        // Gets expenses account from database owned by connected user.
        $expensesAccount = $em->getRepository(ExpenseAccount::class)->getExpensesAccount($this->getUser()->getId());

        // Gets dates if user would create new expense account.
        $today = date('F');
        $endDateEntry = new DateTime($today);
        $endDateEntry->add(new DateInterval('P30D'));
        $dates = array(
            'today' => $today,
            'month' => $endDateEntry->format('F')
        );

//        echo '<pre>';
//        var_dump($dates);
//        echo '</pre>';
//        die();

        return $this->render('prospector/expense.html.twig', array(
            'expensesAccount' => $expensesAccount,
            'dates' => $dates
        ));
    }

    /**
     * @Route("/expense-account/submit", name="prospector_expense_account_submit")
     */
    public function expenseSubmitAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

        }
    }

    /**
     * @Route("/expense-account/{id}", name="prospector_expense_account_detail", requirements={"id"= "\d+"})
     */
    public function expenseDetailAction($id, Request $request)
    {
        return $this->render('prospector/expenseDetail.html.twig');
    }

    /**
     * @Route("/stock", name="prospector_stock")
     */
    public function stockAction(Request $request)
    {
        // TODO : USE SECURITY YML TO REDIRECT USER.
        if ($this->getUser() == null || empty($this->getUser())) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        return $this->render('prospector/stock.html.twig');
    }

    /**
     * @Route("/prospecting", name="prospector_prospecting")
     */
    public function prospectingAction(Request $request)
    {
        // TODO : USE SECURITY YML TO REDIRECT USER.
        if ($this->getUser() == null || empty($this->getUser())) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        return $this->render('prospector/prospecting.html.twig');
    }
}
