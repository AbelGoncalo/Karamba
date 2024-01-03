<?php

namespace App\Livewire\Client;

use Livewire\Component;
use App\Models\{Category,Item,CartLocal,ClientLocal,Table,CartLocalDetail, GarsonTable, GarsonTableManagement};
use Jantinnerezo\LivewireAlert\LivewireAlert;

class OrderComponent extends Component
{
    use LivewireAlert;
    public $searchCategories,$search,$category_id, $qtd = [] ,$allItems = [];


    
    

    public function render()
    {
        return view('livewire.client.order-component',[
            'allCategories'=>$this->allCategories($this->searchCategories),
        ])->layout('layouts.client.app');
    }


    public function allCategories($search = null)
    {
        try {

            if($search != null)
            {
                
                return Category::where('description','like','%'.$search.'%')
                ->where('company_id','=',auth()->user()->company_id)
                ->latest()->get();
            }else{
                return Category::latest()->get();
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


    public function getItems($id)
    {
        try {
            $this->category_id = $id;
            $this->allItems =   Item::where('category_id','=',$id)
            ->where('company_id','=',auth()->user()->company_id)
            ->where('quantity','>',0)
            ->where('status','=','DISPONIVEL')
            ->get();
            if (isset($this->allItems) and count($this->allItems) > 0) {
                foreach ($this->allItems as $value) {
                    
                    $this->qtd[$value->id] = 1;
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


  


 

    //Armazenar Pedidos
    public function makeOrder($id){
        $item = Item::find($id);

        try {
            if(!array_key_exists($id,$this->qtd)){

                $this->alert('warning', 'AVISO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'A quantidade não pode ser nula'
                ]);

                return;
            }elseif($this->qtd[$id] == 0){

                
                    $this->alert('warning', 'AVISO', [
                        'toast'=>false,
                        'position'=>'center',
                        'showConfirmButton' => true,
                        'confirmButtonText' => 'OK',
                        'text'=>'A quantidade não pode ser nula'
                    ]);


            }else{

                if ($this->qtd[$id]  > $item->quantity) {
                    

                    $this->alert('warning', 'AVISO', [
                        'toast'=>false,
                        'position'=>'center',
                        'showConfirmButton' => true,
                        'confirmButtonText' => 'OK',
                        'text'=>'A quantidade superior a disponível'
                    ]);
                    
                
                } else {
                $clientLocal = ClientLocal::where('user_id','=',auth()->user()->id)->first();
                $cartLocal = CartLocal::where('client_local_id','=',$clientLocal->id)
                ->where('company_id','=',auth()->user()->company_id)
                ->first();
                
                $category = Category::find($this->category_id);

                if ($cartLocal) {

                   $itemExist =   CartLocalDetail::where('name','=',$item->description)
                   ->where('company_id','=',auth()->user()->company_id)
                   ->first();

                  if ($itemExist) {
                      
                        $itemExist->quantity += $this->qtd[$id];
                        $itemExist->save();

                        $this->alert('success', 'SUCESSO', [
                            'toast'=>false,
                            'position'=>'center',
                            'showConfirmButton' => true,
                            'confirmButtonText' => 'OK',
                            'text'=>'Seu Pedido de '.$this->qtd[$id].' '.$item->description.', foi enviado.'
                        ]);

                    }else{
                        $garsontable = GarsonTable::where('status','=','Turno Aberto')
                        ->first();
                        $client = ClientLocal::where('user_id','=',auth()->user()->id)->first();
                        $garsontablemanagement = GarsonTableManagement::where('garson_table_id','=',$garsontable->id)
                        ->where('table','=',$client->tableNumber)
                        ->first();
                        $cartLocalFirst = CartLocal::where('client_local_id','=',$client->id)->first();
                       
                        CartLocalDetail::create([
                            'cart_local_id'=>$cartLocalFirst->id,
                            'name'=>$item->description,
                            'table'=>$client->tableNumber,
                            'price'=>$item->price,
                            'quantity'=>$this->qtd[$id],
                            'category'=>$category->description,
                            'company_id'=>auth()->user()->company_id

                        ]);

                        $this->alert('success', 'SUCESSO', [
                            'toast'=>false,
                            'position'=>'center',
                            'showConfirmButton' => true,
                            'confirmButtonText' => 'OK',
                            'text'=>'Seu Pedido de '.$this->qtd[$id].' '.$item->description.', foi enviado.'
                        ]);
                    }

                }else{

                    $garsontable = GarsonTable::where('status','=','Turno Aberto')
                    ->first();
                    $client = ClientLocal::where('user_id','=',auth()->user()->id)->first();
                    $garsontablemanagement = GarsonTableManagement::where('garson_table_id','=',$garsontable->id)
                    ->where('table','=',$client->tableNumber)
                    ->first();


                

                       $cartLocalFirst =  CartLocal::create([
                            'table'=>$garsontablemanagement->table,
                            'client_local_id'=>$clientLocal->id,
                            'company_id'=>auth()->user()->company_id,
                            'user_id'=>$garsontablemanagement->garsontable->user_id
                        ]);


                        CartLocalDetail::create([
                            'cart_local_id'=>$cartLocalFirst->id,
                            'name'=>$item->description,
                            'table'=>$client->tableNumber,
                            'price'=>$item->price,
                            'quantity'=>$this->qtd[$id],
                            'category'=>$category->description,
                            'company_id'=>auth()->user()->company_id

                        ]);

                        $this->alert('success', 'SUCESSO', [
                            'toast'=>false,
                            'position'=>'center',
                            'showConfirmButton' => true,
                            'confirmButtonText' => 'OK',
                            'text'=>'Seu Pedido de '.$this->qtd[$id].' '.$item->description.', foi enviado.'
                        ]);

                }
                
          
               
            }
            }



       
           
        } catch (\Throwable $th) {
            dd($th->getMessage());
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
