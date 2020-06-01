<?php
// mi_primer_modulo/src/Command/CrearProductoCommand.php
namespace Webimpacto\MiPrimerModulo\Command;
//require_once('./PSWebServiceLibrary.php');
require_once('C:/xampp/htdocs/mitienda/modules/miprimermodulo/src/PSWebServiceLibrary.php');

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Webimpacto\MiPrimerModulo\Command\PSWebServiceLibrary;
use Language;
use Product;
use Context;
use Configuration;
use Shop;
use Employee;
use FrontController;
use Category;
use Image;
use AdminImportController;
//use PrestaShop\Adapter\Shop\Context;


class CrearProductoCommand extends Command
{
    protected function configure()
    {
        // The name of the command (the part after "bin/console")
        $this->setName('miprimermodulo:create');
        // $this->addArgument('name', InputArgument::REQUIRED, '¿Escriba el nombre?');
        // $this->addArgument('description', InputArgument::REQUIRED, '¿Escriba la descripcion?');
        // $this->addArgument('precio', InputArgument::REQUIRED,'Escriba el precio');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $id_shop = $input->getOption('id_shop');
        
        $this->context = Context::getContext();
        if(!$id_shop){
            $id_shop = Configuration::get('PS_SHOP_DEFAULT');
            Shop::setContext(Shop::CONTEXT_ALL, $id_shop);
        }
        $this->context->employee = new Employee(1);
        $this->context->controller = new FrontController();
        //GET productos de otro Presta

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "localhost/mitiendanueva/api/products?output_format=JSON",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "Authorization: Basic WjVXOTJQWlVXS0FOSENSWVMxNjY4VVNXNFg4VEJTR0k6",
            "Cookie: PrestaShop-cbac049c40e842298a95cd1e70b00bde=def502005ac6399522b20915c9c7419579212faa98e3f7b446f0ddd05de0a35d8ffee28119193fcba07051ce504c022894f334144f573ee2ee2b7f7a35227dd5acedb7c5f25b8b8207f3da3e84f456573cfb36895b210f110e52ecfe555707b58245a1355ade386e149ac0b2f3610e2c29a61b764b5382bc24891a24bcea9b02f9ea508c68adacd9a731fabdfb87f3021480a09654ce7b4a8c6e3f9fefa023b7d9d23f"
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);

            $array = json_decode($response,true);
            
            foreach($array['products'] as $productoArrayFuera){
                $curlId = curl_init();
                curl_setopt_array($curlId, array(
                    CURLOPT_URL => "localhost/mitiendanueva/api/products/".$productoArrayFuera["id"]."?output_format=JSON",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "Authorization: Basic WjVXOTJQWlVXS0FOSENSWVMxNjY4VVNXNFg4VEJTR0k6",
                        "Cookie: PrestaShop-cbac049c40e842298a95cd1e70b00bde=def502005ac6399522b20915c9c7419579212faa98e3f7b446f0ddd05de0a35d8ffee28119193fcba07051ce504c022894f334144f573ee2ee2b7f7a35227dd5acedb7c5f25b8b8207f3da3e84f456573cfb36895b210f110e52ecfe555707b58245a1355ade386e149ac0b2f3610e2c29a61b764b5382bc24891a24bcea9b02f9ea508c68adacd9a731fabdfb87f3021480a09654ce7b4a8c6e3f9fefa023b7d9d23f"
                    ),
                  ));
                  $responseId = curl_exec($curlId);
                  
                  //dump($responseId);
                    curl_close($curlId);
                    $arrayId = json_decode($responseId,true);


                $productImport= $arrayId['product'];

                
                $productos = new Product();
                $arrayProductos =$productos->getProducts(1,0,0,'id_product','asc',false,false,null);
                
                $veces_igual= 0;
                        foreach($arrayProductos as $productoArray){
                                if($productImport['reference'] == $productoArray['reference']){
                                    $veces_igual++; 
                                }
                                //$veces++;
                            //}
                        }
                    
                    
                if($veces_igual==0){
//Crear categoria

                $curlCategory = curl_init();
                    curl_setopt_array($curlCategory, array(
                    CURLOPT_URL => "localhost/mitiendanueva/api/categories/".$productImport["id_category_default"]."?output_format=JSON",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "Authorization: Basic WjVXOTJQWlVXS0FOSENSWVMxNjY4VVNXNFg4VEJTR0k6",
                        "Cookie: PrestaShop-cbac049c40e842298a95cd1e70b00bde=def502005ac6399522b20915c9c7419579212faa98e3f7b446f0ddd05de0a35d8ffee28119193fcba07051ce504c022894f334144f573ee2ee2b7f7a35227dd5acedb7c5f25b8b8207f3da3e84f456573cfb36895b210f110e52ecfe555707b58245a1355ade386e149ac0b2f3610e2c29a61b764b5382bc24891a24bcea9b02f9ea508c68adacd9a731fabdfb87f3021480a09654ce7b4a8c6e3f9fefa023b7d9d23f"
                    ),
                    ));
                    $responseCategory = curl_exec($curlCategory);

                    //dump($responseCategory);
                    curl_close($curlCategory);
                    $arrayCategory = json_decode($responseCategory,true);
                    //dump($arrayCategory['category']);
                    $categoryImport =$arrayCategory['category'];

                    $categoriaJSON = new Category(1,1,1); // Remove ID later
                    //dump($categoriaJSON);
                    
                    $categoriaJSON->id_category_import = $categoryImport['id'];

                    dump($categoriaJSON->id_category_import);
                    $categoriaJSON->id_category=$categoriaJSON->id;
                    $categoriaJSON->name=$categoryImport['name'][0]['value'];
                    $categoriaJSON->id_parent=$categoryImport['id_parent'];
                    $categoriaJSON->level_depth=$categoryImport['level_depth'];
                    $categoriaJSON->link_rewrite=$categoryImport['link_rewrite'][0]['value'];
                    $categoriaJSON->id_shop_default=$categoryImport['id_shop_default'];
                    $categoriaJSON->is_root_category=$categoryImport['is_root_category'];
                    $categoriaJSON->description=$categoryImport['description'][0]['value'];


                $categoriaJSON->add();
                $categoriaJSON->save();
                $output->writeln('Hello Word! id_category es: '.$categoriaJSON->id_category_import.' ');

 //Fin crear categoria

                    //dump('creamos');

                     //$pro= $array['product'];

                     $productJSON = new Product(); // Remove ID later
                         $productJSON->id_category_default = $productImport['id_category_default'];
                         //dump($productJSON->id_category_default);
                         $productJSON->id_category=$productImport['id_category_default'];
                         $productJSON->new;
                         $productJSON->type = $productImport['type'];
                         $productJSON->reference = $productImport['reference'];
                         $productJSON->weight =  $productImport['weight'];
                         // $nlProduct->price = ceil($input->getArgument('precio'));
                         $productJSON->price = $productImport['price'];
                         //$output->writeln('Precio: '.$nlProduct->price);
                         $productJSON->wholesale_price = $productImport['wholesale_price'];
                         $productJSON->active = $productImport['active'];
                         $productJSON->available_for_order = $productImport['available_for_order'];
                         $productJSON->show_price = $productImport['show_price'];
                         $languages = Language::getLanguages();
                         foreach($languages as $lang){
                             //  $nlProduct->name[$lang['id_lang']] = $sgProduct->name->language;
                             //  $nlProduct->description[$lang['id_lang']] = $sgProduct->description->language;
                             $productJSON->name[$lang['id_lang']] = $productImport['name'][0]['value'];
                             //$output->writeln('Hello Word! Nombre Language '.$lang['name'].' es: '.$nlProduct->name[$lang['id_lang']].' ');
                             $productJSON->description[$lang['id_lang']] = $productImport['description'][0]['value'];
                             //$output->writeln('Hello Word! Description Language '.$lang['name'].' es: '.$nlProduct->description[$lang['id_lang']].' ');
                         }



                $productJSON->add();
                $productJSON->save();
                $output->writeln('Hello Word! id_Product es: '.$productJSON->id.' ');
                $imagenes = $productImport['associations']['images'];
                $i=1;
                $idd=0;
                //$image = new Image();
                foreach($imagenes as $imagen){
                    $id_product = $productJSON->id;
                    $url = 'http://localhost/mitiendanueva/'.$imagen['id'].'/'.$productImport['link_rewrite'][0]['value'].'.jpg';
                    //dump($url);
                    $image = new Image();
                    //dump($image);
                    $image->id_product = $id_product;
                    $shops = Shop::getShops(true, null, true); 
                    $image->position = Image::getHighestPosition($productImport['id']) + 1;
                    if($idd==0){
                        $image->cover = true;
                    }else{
                        $image->cover = null;
                    }
                    
                    if (($image->validateFields(false, true)) === true && ($image->validateFieldsLang(false, true)) === true && $image->add()){
                        //dump('Estoy');
                        $i++;
                        if (AdminImportController::copyImg($id_product, $image->id, $url, 'products', false)){
                            $output->writeln('Hello Word! He copiado la imagen');
                            
                        }else{
                            //echo "fallido";
                            $image->delete();
                        }
                     }
                     $idd++;
                      //$image->add();
                $image->save();
                }
                
                
            } else{
              // dump('Esta repetido');
            }                   
                
                
            }
        //dump($productJSON);      // Dump all data of the Object



         $output->writeln('Hello Word! Finalllllllll');
        //  $output->writeln('Hello Word! id_Product es: '.$nlProduct->name.' ');
        // $output->writeln('Hello Word! id_Product es: '.$nlProduct->name.' ');
        // $output->writeln('Nombre: '.$nlProduct.' ');
        //$output->writeln('Categoría: '.$nlProduct->id_category.' ');
    }
}