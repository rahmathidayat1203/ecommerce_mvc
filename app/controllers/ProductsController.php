<?php

class ProductsController extends Controller
{
    public function index()
    {
        $productModel = new Product();
        $products = $productModel->getAll();
        $this->view('products/index', ['products' => $products]);
    }

    public function show($params)
    {
        $productId = $params['id'];
        echo "Menampilkan product dengan ID: " . $productId;
    }

    public function create()
    {
        $this->view('products/create');
    }
    public function store($params)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Invalid request method.");
        }
        $name = $_POST['name'] ?? null;
        $data = [
            'category_id' => 1,
            'name' => $name,
            'description' => "test",
            'price' => 1500.00,
            'stock' => 12,
        ];

        $productModel = new Product();
        $newId  = $productModel->store($data);
        $this->redirect('products');
    }

    public function edit($params){
        // lengkapi function ini untuk menampilkan halaman edit beserta data product yang akan di edit

    }

    public function update($params){
        // lengkapi function ini untuk mengupdate data product yang telah dipilih
    }

    public function delete($params){
        // lengkapi function ini untuk menghapus data product yang telah dipilih
    }
}
