<?php
namespace App\Controller;
use App\Entity\Noticia;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class DeportesController extends Controller

{
    /**
     * @Route("/deportes", name="inicio" )
     */
    public function inicio() {
        return $this->render("base.html.twig",['texto' =>'Mi página de deportes']);
    }



    /**
    * @Route("/deportes/cargarbd", name="noticia")
    */
    public function cargarBd() {
        $em=$this->getDoctrine()->getManager();

        $noticia=new Noticia();
        $noticia->setSeccion("Tenis");
        $noticia->setEquipo("noticia5");
        $noticia->setFecha("1706018");
        $noticia->setTextoTitular("Noticia 5");
        $noticia->setTextoNoticia("Noticia5 Noticia5 Noticia5 Noticia5 Noticia5 Noticia5 Noticia5 Noticia5 Noticia5 Noticia5 Noticia5 Noticia5 ");
        $noticia->setImagen('noticia5.jpg');
        $em->persist($noticia);

        $em->flush();

        return new Response("Noticia guardada con éxito con id:".$noticia->getId());

    }

    /**
     * @Route("/deportes/actualizar", name="actualizarNoticia")
     */
    public function actualizarBd(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $id=$request->query->get('id');
        $noticia = $em->getRepository(Noticia::class)->find($id);
    
	$noticia->setTextoTitular("Roger-Federer-a-una-victoria-del-númerouno-de-Nadal");

        $noticia->setTextoNoticia("El suizo Roger Federer, el tenista más laureado de la historia, está a son un paso de regresar a la cima del tenis mundial a sus 36 años. Clasificado sin admitir ni réplica para cuartos de final del torneo de Rotterdam, si vence este viernes a Robin Haase se convertirá en el número uno del mundo ...");
        $noticia->setImagen('federer.jpg');
        $em->flush();

        return new Response("Noticia actualizada!");

    }


    /**
     * @Route("/deportes/eliminar", name="eliminarNoticia")
     */
    public function eliminarBd(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $id=$request->query->get('id');
        $noticia = $em->getRepository(Noticia::class)->find($id);

        $em->remove($noticia);
        $em->flush();

        return new Response("Noticia eliminada!");

    }


    /**
     * @Route("/deportes/usuario", name="usuario" )
     */
    public function sesionUsuario(Request $request) {
        $usuario_get=$request->query->get('nombre');
        $session = $request->getSession();
        $session->set('nombre', $usuario_get);
        
        return $this->redirectToRoute('usuario_session',array('nombre'=>$usuario_get));

    }


    /**
     * @Route("/deportes/usuario/{nombre}", name="usuario_session" )
     */
    public function paginaUsuario() {
        $session=new Session();
        $usuario=$session->get('nombre');
        return new Response(sprintf('Sesión iniciada con el atributo nombre: %s'
            , $usuario
        ));
    }



    /**
     * @Route("/deportes/{seccion}/{pagina}", name="lista_paginas",
     * requirements={"pagina"="\d+"},
     * defaults={"seccion":"tenis"})
     */
    public function lista($pagina = 1, $seccion) {
    
        $em=$this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Noticia::class);

        $noticiaSec= $repository->findOneBy(['seccion' => $seccion]);
        //Si el deporte que buscamos no se encuentra lanzamos la
        //excepcion 404 deporte no encontrado
        if(!$noticiaSec){
            //throw $this->createNotFoundException('Error 404 este deporte no esta en nuestra Base de Datos');
            return $this->render("base.html.twig",[
                'texto'=>"Error 404 Página no encontrada"
            ]);
        }

        //almacenamos todas las noticias de una sección en una lista
        $noticias = $repository->findBy([
            "seccion"=>$seccion
        ]);
        // La función str_replace elimina los símbolos - de los títulos
        return $this->render('noticias/listar.html.twig', [
            'titulo' => ucwords(str_replace('-', ' ', $seccion)),
            'noticias'=>$noticias
        ]);
    }

    /**
     * @Route("/deportes/{seccion}/{titular} ",
     * defaults={"seccion":"tenis"}, name="verNoticia")
     */
    public function noticia($titular, $seccion)
    {

        $em=$this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Noticia::class);

        $noticia= $repository->findOneBy(['textoTitular' => $titular]);
        //Si la noticia que buscamos no se encuentra lanzamos error 404
        if(!$noticia){
            //Ahora que controlamos el manejo de plantilla twig, vamos a redirigir al usuario a la pagina de inicio
            //y mostraremos el error 404, para así no mostrar la página de errores generica de symfony
            //throw $this->createNotFoundException('Error 404 este deporte no esta en nuestra Base de Datos');
            return $this->render("base.html.twig",[
                'texto'=>"Error 404 Página no encontrada"
            ]);

        }

        return $this->render('noticias/noticia.html.twig', [
            //parseamos el titular para quitar los simbolos -
            'titulo' => ucwords(str_replace('-', ' ', $titular)),
            'noticias'=>$noticia

        ]);
    }

    // /**
    // * @Route("/deportes/{slug}")
    // */
    // public function mostrar($slug) {
    //     return new Response(sprintf(
    //        'Mi artículo en mi pagina de deportes: ruta %s',$slug));
    // }

    
    /**
    * @Route(
    *     "/deportes/{_idioma}/{fecha}/{seccion}/{equipo}/{pagina}",
    *     defaults={"slug": "1","_formato":"html","pagina":"1"},
    *     requirements={
    *         "_idioma": "es|en",
    *         "_formato": "html|json|xml",
    *         "fecha": "[\d+]{8}",
    *         "pagina"="\d+"
    *     }
    * )
    */
    // public function rutaAvanzadaListado($_idioma,$fecha, $seccion, $equipo, $pagina) {
    //    return new Response(sprintf(
    //        'Listado de noticias  en idioma=%s,
    //         fecha=%s,deporte=%s,equipo=%s, página=%s ',
    //        $_idioma, $fecha, $seccion, $equipo, $pagina));
    // }

    /**
    * @Route(
    *    "/deportes/{_idioma}/{fecha}/{seccion}/{equipo}/{slug}.{_formato}",
    *     defaults={"slug": "1","_formato":"html"},
    *     requirements={
    *         "_idioma": "es|en",
    *         "_formato": "html|json|xml",
    *          "fecha": "[\d+]{8}"
    *     }
    * )
    */
    
    public function rutaAvanzada($_idioma,$fecha, $seccion, $equipo, $slug) {
        // Simulamos una base de datos de equipos o personas
        $deportes=["valencia", "barcelona","federer", "rafa-nadal"];

       // Si el equipo o persona que buscamos no se encuentra redirigimos
       // al usuario a la página de inicio

       if(!in_array($equipo,$deportes)) {
          return $this->redirectToRoute('inicio');
       }
       return new Response(sprintf(
           'Mi noticia en idioma=%s,
            fecha=%s,deporte=%s,equipo=%s, noticia=%s ',
           $_idioma, $fecha, $seccion, $equipo, $slug));
    }



}




