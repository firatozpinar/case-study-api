<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Works;
use App\Repository\WorksRepository;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class WorkController extends AbstractController
{
    /**
     * @Route("/",  methods="GET", name="work_index")
     *
     * @param Request         $request
     * @param WorksRepository $works
     * @return JsonResponse
     * @throws \Exception
     */
    public function index(Request $request, WorksRepository $works): JsonResponse
    {
        $response = $works->findLatest($request->get('page') ?? 1);

        $items = [];

        foreach ($response->getResults() as $item) {
            $items[] = $this->item($item);
        }

        return new JsonResponse([
            'status'   => 'success',
            'paginate' => $response->getResponseData(),
            'data'     => $items
        ]);
    }

    /**
     * @param $id
     * @Route("/{id}", name="work_detail")
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $item = $this->item($this->getDoctrine()->getRepository(Works::class)->find($id));

        return new JsonResponse([
            'status' => 'success',
            'data'   => [
                'work'       => $item,
                'developers' => $this->calculate($item)
            ]
        ]);
    }

    /**
     * @param $work
     * @return array
     */
    protected function calculate($work): array
    {
        $items = [];
        $easyTime = $work['time'] * $work['level'];
        $now = Carbon::now();

        foreach ($this->getDoctrine()->getRepository(Users::class)->findAll() as $developer) {

            $date = Carbon::now()->addHour($easyTime / $developer->getLevel());
            $diff = $now->diff($date);

            $week = $diff->d ? floor($diff->d / 5) : 0;
            $day = $week ? $diff->d - ($week * 5) : $diff->d;

            $items[] = [
                'id'     => $developer->getId(),
                'name'   => $developer->getName(),
                'time'   => $developer->getTime(),
                'level'  => $developer->getLevel(),
                'result' => [
                    'week'   => $week,
                    'day'    => $day,
                    'hour'   => $diff->h,
                    'minute' => $diff->i,
                    'o_day'  => $diff->d
                ]
            ];
        }

        return $items;
    }

    /**
     * Generate response data
     *
     * @param $item
     * @return array
     */
    protected function item($item)
    {
        return [
            'id'         => $item->getId(),
            'title'      => $item->getTitle(),
            'time'       => $item->getTime(),
            'level'      => $item->getLevel(),
            'created_at' => $item->getCreatedAt(),
            'deleted_at' => $item->getUpdatedAt(),
        ];
    }
}
