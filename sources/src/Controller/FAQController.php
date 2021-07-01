<?php

namespace App\Controller;

use App\Entity\FAQ;
use App\Entity\ExportEntity;
use App\Repository\FAQRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FAQController extends AbstractController
{
    

    /**
     * @Route("/FAQ/add", name="add_faq", methods={"POST"})
     */
    public function add(Request $request, FAQRepository $faqRepository)
    {
        $data = json_decode($request->getContent(), true);
        if (empty($data['title']) || empty($data['promoted']) || empty($data['status']) || empty($data['answers'])) {
            return $this->json(['status' => 'Error!','message' => 'Expecting mandatory parameters!'], Response::HTTP_BAD_REQUEST);
        }
        $result = $faqRepository->saveFAQ($data);
        if(is_array($result))
            return $this->json($result, Response::HTTP_BAD_REQUEST);
        else
            return $this->json(['status' => 'Faq created!'], Response::HTTP_CREATED);
    }
    /**
     * @Route("/FAQ/update", name="update_faq", methods={"POST"})
     */
    public function update(Request $request, FAQRepository $faqRepository)
    {
        $data = json_decode($request->getContent(), true);
        $result = $faqRepository->updateFAQ($data);
        if(is_array($result))
            return $this->json($result, Response::HTTP_BAD_REQUEST);
        else
            return $this->json(['status' => 'Faq modified!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/FAQ/export", name="export_faq", methods={"GET"})
     */
    public function export(Request $request, FAQRepository $faqRepository)
    {
        $data = json_decode($request->getContent(), true);
        $result = $faqRepository->exportCSV($data['entity']);
        if(is_array($result))
            return $this->json($result, Response::HTTP_BAD_REQUEST);
        else
            return $this->json(['status' => 'Faq exported!'], Response::HTTP_CREATED);
        
    }
}
