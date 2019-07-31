<?php
namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Example_class;
class ExampleController extends Controller {
/**
* @Route("/example/add")
*/
public function addAction()
{
$stud = new Example_class();
$stud->setName('Thomas');
$stud->setAddress('Herklotzgasse 21');
$doct = $this->getDoctrine()->getManager();
// tells Doctrine you want to save the Product
$doct->persist($stud);
//executes the queries (i.e. the INSERT query)
$doct->flush();
return new Response('Saved new student with id ' . $stud->getId());
}

/**
* @Route("/example/display")
*/
public function displayAction(){
	$stud = $this->getDoctrine()->getRepository('AppBundle:Example_class')->findAll();
	return $this->render('example/display.html.twig', array('data' => $stud));
}
/**
* @Route("/example/update/{id}")
*/
public function updateAction($id){
	$doct = $this->getDoctrine()->getManager();
	$stud = $doct->getRepository('AppBundle:Example_class')->find($id);
	if (!$stud) {
		throw $this->createNotFoundException('No student found for id' . $id);
	}
	$stud->setAddress('Herklotzgasse 21, Test');
	$doct->flush();
	return new Response('Change updated!');
}
/**
* @Route("example/delete/{id}")
*/
public function deleteAction($id){
	$doct = $this->getDoctrine()->getManager();
	$stud = $doct->getRepository('AppBundle:Example_class')->find($id);
	if (!$stud) {
		throw $this->createNotFoundException('No student found for id '.$id);
	}
	$doct->remove($stud);
	$doct->flush();
	return new Response('Record deleted!');
}

}