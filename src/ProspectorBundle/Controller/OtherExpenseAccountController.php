<?php

namespace ProspectorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\ExpenseAccount;
use AppBundle\Entity\OtherExpenseAccount;
use AppBundle\Entity\Parameter;
use AppBundle\Entity\Power;
use ProspectorBundle\Form\OtherExpenseAccountType;
use ProspectorBundle\Model\Ajax;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Doctrine\Bundle\DoctrineBundle\Registry;
use \DateTime;
use \DateInterval;

class OtherExpenseAccountController extends Controller
{
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

        $formOtherExpense = $this->createForm(OtherExpenseAccountType::class, $otherExpenseAccount);

        // If an AJAX request is send.
        if ($request->isXmlHttpRequest()) {
            // Get data from AJAX request.
            $date = $request->get('other_expense_account')['date'];
            $designation = $request->get('other_expense_account')['designation'];
            $file = $request->files->get('other_expense_account')['file'];
            $amount = $request->get('other_expense_account')['amount'];

            if (otherExpenseAccount::verification(array($date, $designation, $file->getMimeType(), $amount)) != 0) {
                // One of the data sends by AJAX request is invalid.
                return new Response(Ajax::JSONResponse('error', 'You have entered wrong data in the form.'));
            } else {
                $dateVerification = OtherExpenseAccount::controlDate($end, $begin, $date);
                // DateTime control.
                if (!$dateVerification) {
                    return new Response(Ajax::JSONResponse('error', 'You have entered wrong data in the form.'));
                } else {
                    $json = $this->newOtherExpenseAccount($date, $designation, $file, $amount, $otherExpenseAccount, $expenseAccount[0]);
                    return new Response($json);
                }
            }
        }

        return $this->render('prospector/expenseDetail.html.twig', array(
            'id' => $id,
            'expenseAccount' => $expenseAccount,
            'nightPrice' => $this->getDoctrine()->getRepository(Parameter::class)->getPrice('night')[0]['value'],
            'middayMealPrice' => $this->getDoctrine()->getRepository(Parameter::class)->getPrice('meal')[0]['value'],
            'mileagePrice' => $this->getDoctrine()->getRepository(Power::class)->getPowerCost($this->getUser()->getId())[0]['cost'],
            'end' => $end,
            'begin' => $begin,
            'otherExpensesAccount' => $otherExpensesAccount,
            'otherExpensesAccountDirectory' => $this->getParameter('upload_otherExpenseAccount_directory'),
            'formNewOtherExpense' => $formOtherExpense->createView(),
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

            return Ajax::JSONResponse('success', array(
                $otherExpenseAccount->getDate()->format('Y-m-d'),
                $otherExpenseAccount->getDesignation(),
                floatval($otherExpenseAccount->getAmount()),
                '/upload/otherExpenseAccount/' . $otherExpenseAccount->getFile(),
                $expenseAccount->getId(),
                $otherExpenseAccount->getId(),
                floatval($otherExpenseAccount->getAmount())
            ));
        } catch (ORMException $e) {
            return Ajax::JSONResponse('error', 'An error is occurred, please contact support if this happens again.');
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
            $this->get('session')->getFlashBag()->set('success_delete', 'Other expense account removed with success.');

            return $this->redirectToRoute('prospector_expense_account_detail', array(
                'id' => $expenseAccountId
            ));
        }
    }

    /**
     * @Route("/otherExpenseAccount-submit/{expenseAccountId}",
     *     name="prospector_other_expense_account_submit",
     *     requirements={
     *         "expenseAccountId"= "\d+"
     *     })
     */
    public function SubmitOtherExpense($expenseAccountId)
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

        if (empty($expenseAccount) || is_null($expenseAccount)) {
            $this->get('session')->getFlashBag()->set('error', 'You don\'t have the permission to manipulate this expense account.');

            return $this->redirectToRoute('prospector_expense_account_detail', array(
                'id' => $expenseAccountId
            ));
        }

        try {
            $expenseAccount[0]->setIsSubmit(true);
            $doctrine->getManager()->flush();
        } catch (ORMException $e) {
            $this->get('session')->getFlashBag()->set('error', 'An error is occurred, please contact support if this happens again.');

            return $this->redirectToRoute('prospector_expense_account_detail', array(
                'id' => $expenseAccountId
            ));
        } finally {
            $this->get('session')->getFlashBag()->set('success_submit', 'Other expense account submitted with success.');

            return $this->redirectToRoute('prospector_expense_account_detail', array(
                'id' => $expenseAccountId
            ));
        }
    }
}
