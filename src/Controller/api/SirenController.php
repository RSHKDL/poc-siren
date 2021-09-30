<?php

namespace App\Controller\api;

use App\Siren\Application\Command\GetCompanyInfoCommand;
use App\Siren\Application\Command\GetCompanyInfoCommandHandler;
use App\Siren\Application\Query\FindCompanyQuery;
use App\Siren\Application\Query\FindCompanyQueryHandler;
use App\Siren\Domain\Exception\SirenApiException;
use App\Siren\Domain\Exception\SirenNotFoundException;
use App\Siren\Domain\Services\JsonFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SirenController extends AbstractController
{
    /**
     * @Route("/siren/{siren}/{from}", name="find_company_by_siren")
     */
    public function findCompanyBySiren(
        string $siren,
        string $from,
        FindCompanyQueryHandler $queryHandler,
        GetCompanyInfoCommandHandler $commandHandler,
        JsonFormatter $formatter
    ): JsonResponse {
        try {
            $query = new FindCompanyQuery($siren, $from);
            $sirenResult = $queryHandler->handle($query);
            $command = new GetCompanyInfoCommand($sirenResult);
            $companyResult = $commandHandler->handle($command);
            $json = $formatter->format($companyResult);
            $response = new JsonResponse($json, Response::HTTP_OK, [], true);
        } catch (SirenNotFoundException $throwable) {
            $response = new JsonResponse($throwable->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (SirenApiException $throwable) {
            $response = new JsonResponse(
                "The insee Api returned an error: {$throwable->getMessage()}",
                $throwable->getCode());
        } catch (\Throwable $throwable) {
            $response = new JsonResponse(
                "An unexpected error occurred: {$throwable->getMessage()}",
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $response;
    }
}