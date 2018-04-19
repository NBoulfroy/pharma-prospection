<?php

namespace ProspectorBundle\Controller;

use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\ExpenseAccount;
use ProspectorBundle\Form\ExpenseAccountType;
use AppBundle\Entity\OtherExpenseAccount;
use ProspectorBundle\Form\OtherExpenseAccountType;
use AppBundle\Entity\Parameter;
use AppBundle\Entity\Power;
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

        // Gets today.
        $today = new DateTime();
        // Gets - 30 days before today.
        $begin = new DateTime();
        $begin->sub(new DateInterval('P30D'));

        // Creates an expense account.
        $expenseAccount = new ExpenseAccount();

        $form = $this->createForm(ExpenseAccountType::class, $expenseAccount);

        // If an AJAX request is send.
        if ($request->isXmlHttpRequest()) {
            // Gets all date from input's name.
            $date = $request->get('expense_account')['date'];
            $night = $request->get('expense_account')['night'];
            $middayMeal = $request->get('expense_account')['middayMeal'];
            $mileage = $request->get('expense_account')['mileage'];

            // Controls the variables content.
            $verification = $this->dataVerification('expenseAccount', array($date, $night, $middayMeal, $mileage));

            if ($verification != 0) {
                // One of the data sends by AJAX request is invalid.
                $json = json_encode(array('status' => 'error', 'data' => 'You have entered wrong data in the form.'));
            } else {
                // Control if the date sends by AJAX request is correct.
                $dateVerification = $expenseAccount::controlDate($today, $begin, $date);

                if (!$dateVerification) {
                    // The date is invalid.
                    $json = json_encode(array('status' => 'error', 'data' => 'You have entered wrong data in the form.'));
                } else {
                    // The date is valid.
                    $json = $this->newExpenseAccount($night, $middayMeal, $mileage, $date, $expenseAccount);
                }
            }

            // Returns JSON.
            return new Response($json);
        }

        return $this->render('prospector/expenses.html.twig', array(
            'begin' => $begin,
            'today' => $today,
            'expensesAccount' => $expensesAccount,
            'form' => $form->createView()
        ));
    }

    /**
     * Database query which returns the value from database.
     *
     * @param string $price
     * @return float
     */
    private function getPrice($price)
    {
        switch ($price) {
            case 'night':
                return floatval(
                    $this->getDoctrine()->getRepository(Parameter::class)->getPrice('night')[0]['value']
                );
                break;
            case 'middayMeal':
                return floatval(
                    $this->getDoctrine()->getRepository(Parameter::class)->getPrice('middayMeal')[0]['value']
                );
                break;
            case 'mileage':
                return floatval(
                    $this->getDoctrine()->getRepository(Power::class)
                        ->getPowerCost($this->getUser()->getId())[0]['cost']
                );
                break;
        }
    }

    /**
     * AJAX treatment which returns a vie with the new expense account.
     *
     * @param int $night - number of nights
     * @param int $middayMeal - number of midday meals
     * @param float $mileage - number of mileages
     * @param string $date - date when the new expense account has been stored in database.
     * @param ExpenseAccount $expenseAccount - ExpenseAccount entity object
     * @return array
     */
    private function newExpenseAccount($night, $middayMeal, $mileage, $date, $expenseAccount)
    {
        $expenseAccount->setDate(new DateTime($date));
        $expenseAccount->setNight($night);
        $expenseAccount->setMiddayMeal($middayMeal);
        $expenseAccount->setMileage($mileage);

        $nightPrice = $this->getPrice('night');
        $middayMealPrice = $this->getPrice('middayMeal');
        $mileagePrice = $this->getPrice('mileage');
        $expenseAccount->setTotalAmount($expenseAccount->amount(array($nightPrice, $middayMealPrice, $mileagePrice)));
        $expenseAccount->setIsSubmit(false);
        $expenseAccount->setPerson($this->getUser());

        try {
            $this->getDoctrine()->getManager()->persist($expenseAccount);
            $this->getDoctrine()->getManager()->flush();
        } catch (ORMException $e) {
            return json_encode(array('status' => 'error', 'data' => $e->getMessage()));
        }

        $response = array(
            'status' => 'success',
            'data' => array(
                $expenseAccount->getDate()->format('Y-m-d'),
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
        $expenseAccount = $this->getDoctrine()->getRepository(ExpenseAccount::class)->findBy(array(
            'id' => $id,
            'person' => $this->getUser()
        ));

        // ExpenseAccount verification (if not exists, redirection to /expenses-account.
        if (empty($expenseAccount) || $expenseAccount == null) {
            return $this->redirectToRoute('prospector_expenses_account');
        }

        $otherExpensesAccount = $this->getDoctrine()->getRepository(OtherExpenseAccount::class)->findBy(array(
            'expenseAccount' => $expenseAccount[0]
        ));

        // Gets submission date of the current expense account.
        $end = new DateTime($expenseAccount[0]->getDate()->format('Y-m-d'));
        // Creates new date with the submission date.
        $begin = new DateTime($expenseAccount[0]->getDate()->format('Y-m-d'));
        // Subtracts 30 days.
        $begin->sub(new DateInterval('P30D'));

        $otherExpenseAccount = new OtherExpenseAccount();

        $form = $this->createForm(OtherExpenseAccountType::class, $otherExpenseAccount);

        // If an AJAX request is send.
        if ($request->isXmlHttpRequest()) {
            // Get data from AJAX request.
            $date = $request->get('other_expense_account')['date'];
            $designation = $request->get('other_expense_account')['designation'];
            $file = $request->files->get('other_expense_account')['file'];
            $amount = $request->get('other_expense_account')['amount'];

            $verification = $this->dataVerification('otherExpenseAccount', array(
                    $date, $designation, $file->getMimeType(), $amount)
                );

            if ($verification) {
                // One of the data sends by AJAX request is invalid.
                $json = json_encode(array('status' => 'error', 'data' => 'You have entered wrong data in the form.'));
            } else {
                // Control if the date sends by AJAX request is correct.
                // TODO : UPGRADE THIS CODE BECAUSE I CALL A STATIC FUNCTION FROM AN OTHER CLASS (OTHER EXPENSE)
                $dateVerification = ExpenseAccount::controlDate($end, $begin, $date);

                // DateTime control.
                if (!$dateVerification) {
                    $json = json_encode(array('status' => 'error', 'data' => 'You have entered wrong data in the form.'));
                } else {
                    // The date is valid.
                    $json = $this->newOtherExpenseAccount($date, $designation, $file, $amount, $otherExpenseAccount, $expenseAccount[0]);
                }

                // Returns JSON.
                return new Response($json);
            }
        }

        return $this->render('prospector/expenseDetail.html.twig', array(
            'id' => $id,
            'expenseAccount' => $expenseAccount,
            'nightPrice' => $this->getPrice('night'),
            'middayMealPrice' => $this->getPrice('middayMeal'),
            'mileagePrice' => $this->getPrice('mileage'),
            'end' => $end,
            'begin' => $begin,
            'otherExpensesAccount' => $otherExpensesAccount,
            'otherExpensesAccountDirectory' => $this->getParameter('upload_otherExpenseAccount_directory'),
            'form' => $form->createView()
        ));
    }

    /**
     * @param \DateTime $date
     * @param string $designation
     * @param * $file
     * @param int|float $amount
     * @param OtherExpenseAccount $otherExpenseAccount
     * @param ExpenseAccount $expenseAccount
     * @return array
     */
    public function newOtherExpenseAccount($date, $designation, $file, $amount, $otherExpenseAccount, $expenseAccount) {
        $otherExpenseAccount->setDate(new DateTime($date));
        $otherExpenseAccount->setDesignation($designation);
        $otherExpenseAccount->setAmount($amount);
        $otherExpenseAccount->setExpenseAccount($expenseAccount);

        // Rename file with unique name
        $fileName = uniqid().".".$file->getClientOriginalExtension();
        // Moves file to the upload directory
        $file->move($this->getParameter('upload_otherExpenseAccount_directory'), $fileName);

        $otherExpenseAccount->setFile($fileName);

        try {
            $this->getDoctrine()->getManager()->persist($otherExpenseAccount);
            $this->getDoctrine()->getManager()->flush();

            $response = array(
                'status' => 'success',
                'data' => array(
                    $otherExpenseAccount->getDate()->format('Y-m-d'),
                    $otherExpenseAccount->getDesignation(),
                    floatval($otherExpenseAccount->getAmount()),
                    '/upload/otherExpenseAccount/' . $otherExpenseAccount->getFile(),
                    $expenseAccount->getId(),
                    $otherExpenseAccount->getId()
                )
            );

            return json_encode($response);
        } catch (ORMException $e) {
            $response = array(
                'status' => 'error',
                'data' => 'An error is occurred, please contact support if this happens again.'
            );

            return json_encode($response);
        }
    }

    /**
     * @Route("/otherExpenseAccount-delete/{expenseAccountId}/{otherExpenseAccountId}",
     *     name="prospector_other_expense_account_delete",
     *     requirements={
     *         "expenseAccountId"= "\d+",
     *         "otherExpenseAccountId"= "\d+"
     *     })
     */
    public function deleteOtherExpense($expenseAccountId, $otherExpenseAccountId)
    {
        // TODO : USE SECURITY YML TO REDIRECT USER.
        if ($this->getUser() == null || empty($this->getUser())) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        $doctrine = $this->getDoctrine();

        $expenseAccount = $doctrine->getRepository(ExpenseAccount::class)->findBy(array(
            'id' => $expenseAccountId,
            'person' => $this->getUser()
        ));
        $otherExpenseAccount = $doctrine->getRepository(OtherExpenseAccount::class)->findBy(array(
            'id' => $otherExpenseAccountId,
            'expenseAccount' => $expenseAccount[0]
        ));

        if (empty($otherExpenseAccount) || is_null($otherExpenseAccount)) {
            $this->get('session')->getFlashBag()->set('warning', 'You don\'t have the permission to manipulate this expense account.');

            return $this->redirectToRoute('prospector_expense_account_detail', array(
                'id' => $expenseAccountId
            ));
        }

        try {
            $doctrine->getManager()->remove($otherExpenseAccount[0]);
            $doctrine->getManager()->flush();
        } catch (ORMException $e) {
            $this->get('session')->getFlashBag()->set('error', 'An error is occurred, please contact support if this happens again.');

            return $this->redirectToRoute('prospector_expense_account_detail', array(
                'id' => $expenseAccountId
            ));
        } finally {
            $this->get('session')->getFlashBag()->set('success', 'Other expense account removed with success.');

            return $this->redirectToRoute('prospector_expense_account_detail', array(
                'id' => $expenseAccountId
            ));
        }
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
     * Controls if the data contains in an array passed in parameter are correct.
     *
     * @param string $type
     * @param array $array
     * @return int
     */
    private function dataVerification($type, $array)
    {
        $error = 0;

        switch($type) {
            default:
                $error = 1;
                break;
            case 'expenseAccount':
                foreach ($array as $item) {
                    $verification = ExpenseAccount::control($item);

                    if (!$verification) {
                        $error += 1;
                    }
                }
                break;
            case 'otherExpenseAccount':
                foreach ($array as $item) {
                    $verification = OtherExpenseAccount::control($item);

                    if (!$verification) {
                        $error += 1;
                    }
                }
                break;
        }

        return $error;
    }
}
