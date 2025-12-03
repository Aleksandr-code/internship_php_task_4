<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class UserController extends AbstractController
{
    #[Route('/admin/user', name: 'app_admin_user_index')]
    public function index(UserRepository $userRepository, UserService $userService, EntityManagerInterface $em): Response
    {
        $users = $userRepository->findBy([], ['lastLoginTime' => 'DESC']);

        $datesPretty = $userService->transformDatesPretty($users);

        $user = $this->getUser();
        if (isset($user)){
            $user->setLastLoginTime();
            $em->flush();
        }

        return $this->render('admin/user/index.html.twig', [
            'users' => $users,
            'user_date_login' => $datesPretty
        ]);
    }

    #[Route('/admin/user/block-multiple', name:'app_admin_user_block_multiple')]
    public function blockMultiple(Request $request, EntityManagerInterface $em):Response
    {
        $ids = json_decode($request->request->get('data'));

        if (!isset($ids)){
            throw $this->createNotFoundException("Ids not found");
        }

        $query = $em->getConnection()->executeStatement(
            'UPDATE `user`
            SET roles = JSON_ARRAY_APPEND(roles, "$", ?)
            WHERE id IN (?) AND NOT JSON_CONTAINS(roles, ?, "$")',
            ['ROLE_USER_BLOCKED', $ids,'"ROLE_USER_BLOCKED"'],
            [\Doctrine\DBAL\ParameterType::STRING, \Doctrine\DBAL\ArrayParameterType::INTEGER, \Doctrine\DBAL\ParameterType::STRING]
        );

        $this->addFlash('success', 'Block operation completed successfully');

        return $this->redirectToRoute('app_admin_user_index');
    }

    #[Route('/admin/user/unlock-multiple', name:'app_admin_user_unlock_multiple')]
    public function unblockMultiple(Request $request, EntityManagerInterface $em):Response
    {
        $ids = json_decode($request->request->get('data'));

        if (!isset($ids)){
            throw $this->createNotFoundException("Ids not found");
        }

        $query = $em->getConnection()->executeStatement(
            'UPDATE `user`
            SET roles = JSON_REMOVE(roles, JSON_UNQUOTE(JSON_SEARCH(roles, "one", ?)))
            WHERE id IN (?) AND JSON_CONTAINS(roles, ?) = 1',
            ['ROLE_USER_BLOCKED', $ids, '"ROLE_USER_BLOCKED"'],
            [\Doctrine\DBAL\ParameterType::STRING, \Doctrine\DBAL\ArrayParameterType::INTEGER, \Doctrine\DBAL\ParameterType::STRING]
        );

        $this->addFlash('success', 'Unblock operation completed successfully');

        return $this->redirectToRoute('app_admin_user_index');
    }

    #[Route('/admin/user/delete-multiple', name:'app_admin_user_delete_multiple')]
    public function deleteMultiple(Request $request, EntityManagerInterface $em):Response
    {
        $ids = json_decode($request->request->get('data'));

        if (!isset($ids)){
            throw $this->createNotFoundException("Ids not found");
        }

        $query = $em->createQuery('DELETE FROM App\Entity\User u WHERE u.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->execute();

        $this->addFlash('success', 'Delete operation completed successfully');

        return $this->redirectToRoute('app_admin_user_index');
    }

    #[Route('/admin/user/delete-unverified-multiple', name:'app_admin_user_delete_unverified_multiple')]
    public function deleteUnverifiedMultiple(Request $request, EntityManagerInterface $em):Response
    {
        $ids = json_decode($request->request->get('data'));

        if (!isset($ids)){
            throw $this->createNotFoundException("Ids not found");
        }

        $query = $em->getConnection()->executeStatement(
            'DELETE FROM `user`
            WHERE id IN (?) AND JSON_CONTAINS(roles, ?) = 1',
            [$ids, '"ROLE_UNVERIFIED"'],
            [\Doctrine\DBAL\ArrayParameterType::INTEGER, \Doctrine\DBAL\ParameterType::STRING]
        );

        $this->addFlash('success', 'Delete operation completed successfully');

        return $this->redirectToRoute('app_admin_user_index');
    }

}
