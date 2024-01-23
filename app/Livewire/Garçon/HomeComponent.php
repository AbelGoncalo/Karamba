<?php

namespace App\Livewire\Garçon;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\{
    Table,
    Item,
    Category,
    CartLocal,
    ClientLocal,
    CartLocalDetail,
    CartLocalDetailDailydish,
    DailyDish,
    GarsonTable,
    HistoryOfAllActivities
};


class HomeComponent extends Component
{
    use LivewireAlert;
    public $searchItems;
    public $searchCategories,$search,$category_id,$qtd = [],$allItems = [],$tableNumber, $client_entrance = null
    ,$client_dessert = null,$client_drink = null, $client_maindish = null, $client_coffe = null;
   
    protected $listeners = ['modal'=>'modal'];

    public function render()
    {
        return view('livewire.garson.home-component',[
            'allCategories'=>$this->allCategories($this->searchCategories),
            'allTables'=>$this->getTables(),
            'typesMenuDailydishes' =>  $this->getAllTypesOfMenuOfDailydish(),
            'itemsDailydishes' => $this->getAllDetailsAboutDailyDishes(),
        ])->layout('layouts.garson.app');

    }

    public function getAllDetailsAboutDailyDishes(){
       return DailyDish::where("company_id" , auth()->user()->company_id)->get();
    }

    public function getAllTypesOfMenuOfDailydish(){
        return Item::Join("categories", "items.category_id" , "=" , "categories.id")
        ->where("categories.description" , '=' , "Prato do Dia")
        ->get(["items.description"]);
    }

    public function getDeatailsAboutDailyDish(){
        return DailyDish::where("company_id" , auth()->user()->company_id)->get();
    }

    public function allCategories($search = null)
    {
        try {

            if($search != null)
            {
                return Category::where('description','like','%'.$search.'%')
                ->where('company_id','=',auth()->user()->company_id)
                ->get();
            }else{
                return Category::where('company_id','=',auth()->user()->company_id)->get();
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
            $this->allItems =  Item::where('category_id','=',$id)
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

                if ($this->qtd[$id]  > $item->quantity || $item->quantity <= 0) {
                    $this->alert('warning', 'AVISO', [
                        'toast'=>false,
                        'position'=>'center',
                        'showConfirmButton' => true,
                        'confirmButtonText' => 'OK',
                        'text'=>'A quantidade superior a disponivel'
                    ]);
                } else {
                
                if($this->tableNumber == null)
                {
                    $this->alert('warning', 'AVISO', [
                        'toast'=>false,
                        'position'=>'center',
                        'showConfirmButton' => true,
                        'confirmButtonText' => 'OK',
                        'text'=>'Selecione a mesa que pretende anotar o pedido, porfavor...'
                    ]);
                }else{


                    $category = Category::find($this->category_id);
                    $itemExist =   CartLocalDetail::where('name','=',$item->description)
                    ->where('company_id','=',auth()->user()->company_id)
                    ->where('table','=',$this->tableNumber)
                    ->where('status','=','PENDENTE')
                    ->first();

                   
                      
                if ($itemExist) {
                    
                    if ($item->category->description == "Prato do Dia"){
                        $itemExist->quantity = 1;
                        $itemExist->save();
                    }else{
                        $itemExist->quantity += $this->qtd[$id];
                        $itemExist->save();
                    }
                    

                        //Registando Atividade na tabela de Log  para o acto de anotar pedidos
                        $log_registers = new HistoryOfAllActivities();
                        $log_registers->tipo_acao = "Anotar pedidos";
                        $log_registers->descricao = "O Garçon ".auth()->user()->name." anotou " .$this->qtd[$id]. ($this->qtd[$id] > 1 ? " quantidades " : " quantidade ") ." do produto ".$item->description;
                        $log_registers->responsavel = auth()->user()->name;
                        $log_registers->company_id = auth()->user()->company_id;
                        $log_registers->save();



                        $this->alert('success', 'SUCESSO', [
                            'toast'=>false,
                            'position'=>'center',
                            'showConfirmButton' => true,
                            'confirmButtonText' => 'OK',
                            'text'=>'Seu Pedido de '.$this->qtd[$id].' '.$item->description.', foi enviado.'
                        ]);                   

                }else{

                    if ($item->category->description == "Prato do Dia"){

                        $dailyDishes = DailyDish::get();
                        $itemsFound = Item::get();
     
                        foreach($dailyDishes as $daily){
                             foreach($itemsFound as $foundedItem){
                                 
                                 if($daily->entrance == $foundedItem->description){
                                    $foundedItem->quantity =  $foundedItem->quantity - 1;
                                    $foundedItem->save();
     
                                 } if($daily->maindish == $foundedItem->description){
                                     $foundedItem->quantity  =  $foundedItem->quantity - 1;
                                     $foundedItem->save();
                                    
                                 }else if($daily->dessert == $foundedItem->description){
                                     $foundedItem->quantity  =  $foundedItem->quantity - 1;
                                     $foundedItem->save();
     
                                 }else if($daily->drink == $foundedItem->description){
                                     $foundedItem->quantity  =  $foundedItem->quantity -1;
                                     $foundedItem->save();
     
                                     }
                                     
                                         }
                                 }

                                 $cartDetails = CartLocalDetail::create([
                                    'name'=>$item->description,
                                    'table'=>$this->tableNumber,
                                    'price'=>$item->price,
                                    'quantity'=> 1,
                                    'category'=>$category->description,
                                    'company_id'=>auth()->user()->company_id
        
                                ]);


                                //Armazenando as informações referentes a escolha do cliente sobre o prato
                                
                                $cartDailyDishOfClient = CartLocalDetailDailydish::create([
                                    "cart_local_detail_id" => $cartDetails['id'],
                                    "entrance" => $this->client_entrance,
                                    "maindish" => $this->client_maindish,
                                    "dessert" => $this->client_dessert,
                                    "drink" => $this->client_drink,
                                    "coffe" => $this->client_coffe,
                                    "company_id" => auth()->user()->company_id
                                    
                                ]);

                    }else{
                        $item->quantity -= $this->qtd[$id];
                        $item->save();

                        CartLocalDetail::create([
                            'name'=>$item->description,
                            'table'=>$this->tableNumber,
                            'price'=>$item->price,
                            'quantity'=>$this->qtd[$id],
                            'category'=>$category->description,
                            'company_id'=>auth()->user()->company_id

                        ]);
                    }  

                        //Registando Atividade na tabela de Log  para o acto de anotar pedidos
                        $log_registers = new HistoryOfAllActivities();
                        $log_registers->tipo_acao = "Anotar pedidos";
                        $log_registers->descricao = "O Garçon ".auth()->user()->name." anotou " .$this->qtd[$id]. ($this->qtd[$id] > 1 ? " quantidades " : " quantidade ") ." do produto ".$item->description;
                        $log_registers->responsavel = auth()->user()->name;
                        $log_registers->company_id = auth()->user()->company_id;
                        $log_registers->save();

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

          

            $this->getItems($this->category_id);
           
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



    public function getTables()
    {
        try {
                 $tables =  GarsonTable::where('user_id','=',auth()->user()->id)
                    ->where('status','=','Turno Aberto')
                    ->where('user_id','=',auth()->user()->id)
                    ->where('company_id','=',auth()->user()->company_id)
                    ->get();
            if($tables)
            {
                return $tables;
            }else{
                return [];
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

    public function clealAllFields()
    {
        try {
            //code...
             $this->searchItems = '';
             $this->searchCategories = '';
             $this->search = '';
             $this->category_id = '';
             $this->qtd = [];
             $this->allItems = [];
             $this->tableNumber ='';
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
