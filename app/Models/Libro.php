<?php 
namespace App\Models;

use CodeIgniter\Model;

class Libro extends Model{//Herencia
    protected $table= 'libros';//nombre de la tabla
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id';
    protected $allowebFields = ['nombre','imagen']; 
}