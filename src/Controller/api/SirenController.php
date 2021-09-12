<?php

namespace App\Controller\api;

use App\Siren\Application\Command\GetCompanyInfoCommand;
use App\Siren\Application\Command\GetCompanyInfoCommandHandler;
use App\Siren\Application\Query\FindCompanyQuery;
use App\Siren\Application\Query\FindCompanyQueryHandler;
use App\Siren\Domain\Exception\SirenNotFoundException;
use App\Siren\Domain\Services\JsonFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SirenController extends AbstractController
{
    /**
     * @Route("/siren/{siren}", name="find_company_by_siren")
     */
    public function findCompanyBySiren(
        int $siren,
        FindCompanyQueryHandler $queryHandler,
        GetCompanyInfoCommandHandler $commandHandler,
        JsonFormatter $formatter
    ): JsonResponse {
        try {
            $query = new FindCompanyQuery($siren, 'csv');
            $occurrences = $queryHandler->handle($query);
            $command = new GetCompanyInfoCommand($occurrences->occurrencesIndexes);
            $data = $commandHandler->handle($command);
            $json = $formatter->format($data);
            $response = new JsonResponse($json, Response::HTTP_OK, [], true);
        } catch (SirenNotFoundException $throwable) {
            $response = new JsonResponse($throwable->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Throwable $throwable) {
            $response = new JsonResponse(
                "An unexpected error occurred: {$throwable->getMessage()}",
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $response;
    }
}