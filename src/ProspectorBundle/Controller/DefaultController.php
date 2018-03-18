<?php

namespace ProspectorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\ExpenseAccount;
use ProspectorBundle\Form\ExpenseAccountType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use \DateTime;
use \DateInterval;

class DefaultController extends Controller
{
    /**
     * @Route("/expenses-account", name="prospector_expenses_account")
     */
    public function expenseAction(Request $request)
    {
        // TODO : USES SECURITY YML TO REDIRECT USER.
        if ($this->getUser() == null || empty($this->getUser())) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        // Gets expenses account from database owned by connected user.
        $expensesAccount = $em->getRepository(ExpenseAccount::class)->findBy(array(
            'person' => $this->getUser()->getId()
        ));

        // Gets dates if user would create new expense account.
        $today = date('F');
        $endDateEntry = new DateTime($today);
        $endDateEntry->add(new DateInterval('P30D'));
        $dates = array(
            'today' => $today,
            'month' => $endDateEntry->format('F')
        );

        // Creates an expense account.
        $expenseAccount = new ExpenseAccount();

        $form = $this->createForm(ExpenseAccountType::class, $expenseAccount);

        // If an AJAX request is send.
        if ($request->isXmlHttpRequest()) {
            $night = $request->get('expense_account')['night'];
            $middayMeal = $request->get('expense_account')['middayMeal'];
            $mileage = $request->get('expense_account')['mileage'];

            // $expenseAccount->setIsSubmit(false);
            $expenseAccount->setMonth(new Datetime(date('Y-m-d')));
            $expenseAccount->setNight($night);
            $expenseAccount->setMiddayMeal($middayMeal);
            $expenseAccount->setMileage($mileage);
            $expenseAccount->setTotalAmount(9.99);
            $expenseAccount->setPerson($this->getUser());

//            $em->persist($expenseAccount);
//            $em->flush();

            // Gets the HTML content with the new values.
            $response = $this->renderView('prospector/ajax/newExpense.html.twig', array(
                'isSubmit' => $expenseAccount->getIsSubmit(),
                'month' => $endDateEntry,
                'night' => $night,
                'middayMeal' => $middayMeal,
                'mileage' => $mileage,
                'totalAmount' => $totalAmount = $expenseAccount->getTotalAmount(),
                'id' => $expenseAccount->getId()
            ));

            // Returns the HTML content.
            return new Response($response);
        }

        return $this->render('prospector/expenses.html.twig', array(
            'expensesAccount' => $expensesAccount,
            'dates' => $dates,
            'form' => $form->createView()
        ));
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
