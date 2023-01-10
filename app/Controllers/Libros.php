<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Libro;

class Libros extends Controller{

    public function index(){

        $libro = new Libro();
        $datos['libros']= $libro->orderBy('id','ASC')->findAll();
        // var_dump($datos);
        // exit;
        
        $datos['cabecera']= view('templates/cabecera');
        $datos['pie']= view('templates/piepagina');
        
        
        return view('libros/listar',$datos);
        
    }

    public function crear(){
        $datos['cabecera']= view('templates/cabecera');
        $datos['pie']= view('templates/piepagina');
        
        return view('libros/crear', $datos);
    }

    

    public function guardar(){
        // $img = $this->request->getFile('imagen');
        // print_r($img);
       

        // $nombre = $this->request->getVar('nombre');
        // print_r($nombre);
   
        $libro = new Libro();

        $validacion = $this->validate([
            'nombre'=>'required|min_length[3]',
            'imagen'=>[
                'uploaded[imagen]',
                'mime_in[imagen,image/jpg,image/jpeg,image/png]',
                'max_size[imagen,1024]'
            ]
        ]);

        if(!$validacion){
            $session = session();
            $session->setFlashdata('mensaje','Revise la información');
            // return $this->response->redirect(site_url('/listar'));
            return redirect()->back()->withInput();
        }
  
        if($imagen = $this->request->getFile('imagen')){
            $nuevoNombre= $imagen->getRandomName();
            $imagen->move('../public/uploads/',$nuevoNombre);
            

            $datos=[
                'nombre'=>$this->request->getVar('nombre'),
                'imagen'=>$nuevoNombre
            ];
            $libro->protect(false);
            $libro->insert($datos); 
            $libro->protect(true); 
        }
        return $this->response->redirect(site_url('/listar'));
    }

    public function borrar($id=null){
        $libro = new Libro();
        $datosLibros= $libro->where('id', $id)->first();

        $ruta =('../public/uploads/'.$datosLibros['imagen']);
        unlink($ruta);#borrado del archivo

        $libro->where('id',$id)->delete($id);#borrado en la bd dependiendo del id
        return $this->response->redirect(site_url('/listar'));
    }

    public function editar($id=null){
        print_r($id);
        $libro = new Libro();

        $datos['libro']=$libro->where('id', $id)->first();
        
        $datos['cabecera']= view('templates/cabecera');
        $datos['pie']= view('templates/piepagina');

        return view('libros/editar',$datos);
    }

    public function actualizar(){
        $libro = new Libro();
        $datos=[
            'nombre'=>$this->request->getVar('nombre')
        ];
        $id = $this->request->getVar('id');#rececpcionamos de la interfeaz de editar el id

        $validacion = $this->validate([
            'nombre'=>'required|min_length[3]',
        ]);

        if(!$validacion){
            $session = session();
            $session->setFlashdata('mensaje','Revise la información');
            // return $this->response->redirect(site_url('/listar'));
            return redirect()->back()->withInput();
        }


        $libro->protect(false);
        $libro->update($id,$datos);
        $libro->protect(true); 

        $validacion = $this->validate([
            'imagen'=>[
                'uploaded[imagen]',
                'mime_in[imagen,image/jpg,image/jpeg,image/png]',
                'max_size[imagen,1024]'
            ]
        ]);
        if($validacion){
            if($imagen = $this->request->getFile('imagen')){

                $datosLibro = $libro->where('id',$id)->first();
                $ruta =('../public/uploads/'.$datosLibro['imagen']);
                unlink($ruta);#borrado del archivo

                $nuevoNombre= $imagen->getRandomName();
                $imagen->move('../public/uploads/',$nuevoNombre);
                
                $datos=[
                    'imagen'=>$nuevoNombre
                ];
                $libro->protect(false);
                $libro->update($id,$datos); 
                $libro->protect(true); 
            }

        }
        return $this->response->redirect(site_url('/listar'));
    }
}