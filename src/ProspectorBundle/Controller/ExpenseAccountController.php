<?php

namespace ProspectorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\ExpenseAccount;
use ProspectorBundle\Form\ExpenseAccountType;
use ProspectorBundle\Form\ExpenseAccountSubmitType;
use AppBundle\Entity\Parameter;
use AppBundle\Entity\Power;
use ProspectorBundle\Model\Ajax;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Doctrine\Bundle\DoctrineBundle\Registry;
use \DateTime;
use \DateInterval;

class ExpenseAccountController extends Controller
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

        // Gets today.
        $today = new DateTime();
        // Gets - 30 days before today.
        $begin = new DateTime();
        $begin->sub(new DateInterval('P30D'));

        // Creates an expense account.
        $expenseAccount = new ExpenseAccount();

        // Creates ExpenseAccount form for the view.
        $form = $this->createForm(ExpenseAccountType::class, $expenseAccount);

        return $this->render('prospector/expenses.html.twig', array(
            'begin' => $begin,
            'today' => $today,
            'expensesAccount' => $expensesAccount,
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/expense-account-add", name="prospector_expense_account_add")
     */
    public function addExpenseAccountAction(Request $request)
    {
        // Gets today.
        $today = new DateTime();
        // Gets - 30 days before today.
        $begin = new DateTime();
        $begin->sub(new DateInterval('P30D'));

        // If an AJAX request is send.
        if ($request->isXmlHttpRequest()) {
            // Gets all date from input's name.
            $date = $request->get('expense_account')['date'];
            $night = $request->get('expense_account')['night'];
            $middayMeal = $request->get('expense_account')['middayMeal'];
            $mileage = $request->get('expense_account')['mileage'];

            if (ExpenseAccount::verification(array($date, $night, $middayMeal, $mileage)) != 0) {
                // One of the data sends by AJAX request is invalid.
                return new Response(Ajax::JSONResponse('error', 'You have entered wrong data in the form.'));
            } else {
                // Control if the date sends by AJAX request is correct.
                $dateVerification = ExpenseAccount::controlDate($today, $begin, $date);

                // The date is invalid.
                if (!$dateVerification) {
                    return new Response(Ajax::JSONResponse(
                        'error',
                        'You have entered wrong data in the form.'
                    ));
                } else {
                    $expenseAccount = new ExpenseAccount();
                    // Sets all data to ExpenseAccount object.
                    $expenseAccount->setDate(new DateTime($date));
                    $expenseAccount->setNight($night);
                    $expenseAccount->setMiddayMeal($middayMeal);
                    $expenseAccount->setMileage($mileage);
                    $expenseAccount->setIsSubmit(false);
                    $expenseAccount->setIsRepay(false);
                    $expenseAccount->setIsValidate(false);
                    $expenseAccount->setPerson($this->getUser());

                    $amont = $expenseAccount->amount(array(
                        $this->getDoctrine()->getRepository(Parameter::class)->getPrice('night')[0]['value'],
                        $this->getDoctrine()->getRepository(Parameter::class)->getPrice('meal')[0]['value'],
                        $this->getDoctrine()->getRepository(Power::class)->getPowerCost($this->getUser()->getId())[0]['cost']
                    ));
                    $expenseAccount->setTotalAmount($amont);

                    // Try to insert new ExpenseAccount object in database.
                    try {
                        $this->getDoctrine()->getManager()->persist($expenseAccount);
                        $this->getDoctrine()->getManager()->flush();
                    } catch (ORMException $e) {
                        return new Response(Ajax::JSONResponse(
                            'error',
                            'An error is occurred, please contact support if this happens again.'
                        ));
                    }

                    return new Response(Ajax::JSONResponse('success', array(
                            $expenseAccount->getDate()->format('Y-m-d'),
                            $expenseAccount->getNight(),
                            $expenseAccount->getMiddayMeal(),
                            $expenseAccount->getMileage(),
                            $expenseAccount->getTotalAmount(),
                            'waiting for processing',
                            $expenseAccount->getId())
                    ));
                }
            }
        } else {
            return $this->redirectToRoute('prospector_expenses_account');
        }
    }
}
