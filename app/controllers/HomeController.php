<?php
class HomeController extends Controller
{
    // tambahkan logika untuk menampilkan grafik dan jumlah data product,cart dan category yang ada di database
    public function index(){
        $this->view('home/index');
    }
}