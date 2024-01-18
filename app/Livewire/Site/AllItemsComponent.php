<?php

namespace App\Livewire\Site;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\{Item,Category, Company, Review};
use Darryldecode\Cart\Facades\CartFacade as Cart;

class AllItemsComponent extends Component
{
    use LivewireAlert;
    public $category,$companyid,$comment,$stars = 1,$itemid;
    protected $listeners = ['close'=>'close'];
 
    public function placeholder()
    {
        return <<<'HTML'
        <div>
           <p>Carregando...</p>
        </div>
        HTML;
    }

    public function render()
    {

         
      
        return view('livewire.site.all-items-component',[
            'items'=>$this->getItems($this->category),
            'categories'=>$this->getCategories(),
            'company'=>Company::find($this->companyid)
        ])->layout('layouts.site.app');
    }


       //Pegar todos os items {filtrando pela categoria}
       public function getItems($category = null)
       {
           try {

               if(isset($category) and $category != null)
               {
                    
               
                 return Item::where('category_id','=',$category)
                 ->where('company_id','=',$this->companyid)
                 ->where('quantity','>',0)
                 ->where('status','=','DISPONIVEL')
                 ->get();
                 
                }else{
                    
                  
                    return Item::where('company_id','=',$this->companyid)
                   ->where('quantity','>',0)
                   ->where('status','=','DISPONIVEL')
                   ->get();
               }
           } catch (\Throwable $th) {
               $this->alert('error', 'ERRO', [
                   'toast'=>false,
                   'position'=>'center',
                   'showConfirmButton' => true,
                   'confirmButtonText' => 'OK',
                   'text'=>'Falha ao realizar operação'
               ]);
           }
       }
       //Pegar todos as categorias 
       public function getCategories()
       {
           try {
             return  Category::where('company_id','=',$this->companyid)
                     ->get();
           } catch (\Throwable $th) {
               $this->alert('error', 'ERRO', [
                   'toast'=>false,
                   'position'=>'center',
                   'showConfirmButton' => true,
                   'confirmButtonText' => 'OK',
                   'text'=>'Falha ao realizar operação'
               ]);
           }
       }


       //Adicionar produto no carrinho
       public function addToCart($id)
       {
        try {
            
            $item = Item::find($id);
            if ($item->status == 'INDISPONIVEL') {
                $this->alert('warning', 'AVISO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'ITEM INDISPONÍVEL'
                ]);
            }else{

                if ($item->quantity == 0) {
                    $this->alert('warning', 'AVISO', [
                        'toast'=>false,
                        'position'=>'center',
                        'showConfirmButton' => true,
                        'confirmButtonText' => 'OK',
                        'text'=>'ITEM INDISPONÍVEL'
                    ]);
                } else {
                 
               
                
                
                Cart::add(array(
                    'id' => $item->id,
                    'name' => $item->description,
                    'price' => $item->price,
                    'quantity' => 1,
                    'attributes' => array(
                        'image' => $item->image,
                        

                    )
                ));
                
                session()->put('companyid',$this->companyid);
                $this->alert('success', 'SUCESSO', [
                    'toast'=>false,
                    'position'=>'center',
                    'timer' => '1000',
                    'text'=>'Item '.$item->description.', adicionado'
                ]);
                $this->dispatch('getTotalItems');
            }
            }
            
        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
       }



       public function saveReview()
        {
        try {
            $item = Item::find($this->itemid);
            Review::create([
                "star_number"=>$this->stars,
                "comment"=>$this->comment,
                "site"=>'Site',
                "item"=>$item->description,
                "item_id"=>$item->id,
                "company_id"=>$this->companyid,
            ]);
           

            $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'A sua avaliação foi recebida'
            ]);
            $this->dispatch('close');
        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
    }


    public function getItemId($id)
    {
        try {
            
          $this->itemid =  Item::find($id)->id;


        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
    }
   
}
