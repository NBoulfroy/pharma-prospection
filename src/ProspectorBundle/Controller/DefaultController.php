<?php

namespace ProspectorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
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

            // Controls the variables content.
            $verification = $this->verification(array($night, $middayMeal, $mileage));

            // If verification returns false, processing to add new expense account is canceled.
            if ($verification != 0) {
                $json = json_encode(array('status' => 'error', 'data' => 'You have entered wrong data in the form.'));
            } else {
                $json = $this->newExpenseAccount($night, $middayMeal, $mileage, $endDateEntry, $expenseAccount);
            }

            // Returns JSON.
            return new Response($json);
        }

        return $this->render('prospector/expenses.html.twig', array(
            'expensesAccount' => $expensesAccount,
            'dates' => $dates,
            'form' => $form->createView()
        ));
    }

    /**
     * Controls if the data contains in an array passed in parameter are correct.
     *
     * @param array $array
     * @return int
     */
    private function verification($array)
    {
        $error = 0;

        foreach ($array as $item) {
            $verification = ExpenseAccount::control($item);

            if (!$verification) {
                $error += 1;
            }
        }

        return $error;
    }

    /**
     * AJAX treatment which returns a vie with the new expense account.
     *
     * @param int $night - number of nights
     * @param int $middayMeal - number of midday meals
     * @param float $mileage - number of mileages
     * @param \Datetime $today - date when the new expense account has been stored in database.
     * @param ExpenseAccount $expenseAccount - ExpenseAccount entity object
     * @return array
     */
    private function newExpenseAccount($night, $middayMeal, $mileage, $today, $expenseAccount)
    {
        // $expenseAccount->setIsSubmit(false);
        $expenseAccount->setMonth(new Datetime(date('y-m-d')));
        $expenseAccount->setNight($night);
        $expenseAccount->setMiddayMeal($middayMeal);
        $expenseAccount->setMileage($mileage);
        $expenseAccount->setTotalAmount(9.99);
        $expenseAccount->setIsSubmit(false);
        $expenseAccount->setPerson($this->getUser());

//        $this->getDoctrine()->getManager()->persist($expenseAccount);
//        $this->getDoctrine()->getManager()->flush();

        $response = array(
            'status' => 'success',
            'data' => array(
                $expenseAccount->getMonth()->format('Y-m-d'),
                $expenseAccount->getNight(),
                $expenseAccount->getMiddayMeal(),
                $expenseAccount->getMileage(),
                $expenseAccount->getTotalAmount(),
                $expenseAccount->getId(),
            ),
        );

        return json_encode($response);
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
