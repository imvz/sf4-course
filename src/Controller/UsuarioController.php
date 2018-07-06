<?php
namespace App\Controller;

use App\Entity\Usuario;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class UsuarioController extends Controller

{

    /**
    * @Route("/admin/login", name="login_seguro" )
    */

    public function loginUsuario​(Request $request, AuthenticationUtils $authUtils)
    
    {
// Capturamos el error de autenticación
        $error = $authUtils->getLastAuthenticationError();
// Último nombre de usuario autenticado
        $lastUsername = $authUtils->getLastUsername();
        
        return $this->render( 'Security/login.html.twig' , [
            'last_username'=> $lastUsername,
            'error' => $error,
        ]);
    }

    /**
    * @Route("/admin/nuevousuario", name="usuariobd")
    */
    public function nuevoUsuarioBd​ ()
    {
        $em= $this->getDoctrine()->getManager();
        $usuario= new Usuario();
        $usuario->setEmail("jose@imaginaformacion.com");
        $usuario->setUsername("jose");
        $password = $this->get('security.password_encoder' )->encodePassword($usuario, "imaginapass" );
        $usuario->setPassword($password);
        $em->persist($usuario);
        $em->flush();
        return new Response( "Usuario guardado!" );
    }

    /**
     * @Route("/admin/login_check", name="login_check")
     */
    public function loginCheck()
    {
        return $this->render("base.html.twig",[
        'texto'=>'a'
    ]);
    }
}
