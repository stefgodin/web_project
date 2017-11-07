<?php

class ShopController extends Controller
{
    /**
     * Product list view
     *
     * @param int $_page
     * @param string $_tag
     */
    function indexAction($_page = 1,$_tag = ""){
        $rep = new ProductRepository();

        $limit = 10;
        $offset = ($_page - 1) * $limit;
        $productCount = $rep->countAllByTag($_tag);
        $pageCount = (int)ceil($productCount/$limit);

        $products = $rep->findAllByTag($limit,$offset,$_tag);

        $this->view('shop/index',array("products" => $products,"pagesCount" => $pageCount,"tag" => $_tag));
    }

    /**
     * Single product view
     *
     * @param int $_id
     */
    function productAction($_id){
        if(empty($_id)){
            GlobalHelper::redirect("shop/index");
        }

        $rep = new ProductRepository();
        $product = $rep->find($_id);

        if(!$product){
            throw new Exception("Le produit recherché n'existe pas");
        }

        $this->view("shop/product",array("product"=>$product));
    }
}